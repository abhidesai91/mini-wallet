<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $perPage = max(1, min((int) $request->get('per_page', 20), 100));

        $transactions = Transaction::query()
            ->with(['sender:id,name', 'receiver:id,name'])
            ->where(function ($q) use ($user) {
                $q->where('sender_id', $user->id)
                  ->orWhere('receiver_id', $user->id);
            })
            ->orderByDesc('id')
            ->paginate($perPage);

        return response()->json([
            'user_id' => $user->id,
            'balance' => $user->balance,
            'transactions' => $transactions,
        ]);
    }

    public function store(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'receiver_id' => ['required', 'integer', 'exists:users,id', 'not_in:' . $user->id],
            'amount' => ['required', 'numeric', 'min:0.01', 'regex:/^\d+(\.\d{1,2})?$/'],
        ]);

        $senderId = $user->id;
        $receiverId = (int) $validated['receiver_id'];
        $amount = round((float) $validated['amount'], 2);

        $result = DB::transaction(function () use ($senderId, $receiverId, $amount) {
            // Lock rows in stable order to avoid deadlocks
            $ids = [$senderId, $receiverId];
            sort($ids);

            $users = User::whereIn('id', $ids)->lockForUpdate()->get()->keyBy('id');

            $sender = $users[$senderId] ?? null;
            $receiver = $users[$receiverId] ?? null;

            if (! $sender || ! $receiver) {
                throw ValidationException::withMessages([
                    'receiver_id' => ['Invalid receiver.'],
                ]);
            }

            $commission = round($amount * 0.015, 2);
            $totalDebited = round($amount + $commission, 2);

            if ((float) $sender->balance < $totalDebited) {
                throw ValidationException::withMessages([
                    'amount' => ['Insufficient balance.'],
                ]);
            }

            // Update balances atomically in SQL to avoid floating-point issues
            DB::table('users')->where('id', $senderId)
                ->update(['balance' => DB::raw('balance - ' . number_format($totalDebited, 2, '.', ''))]);

            DB::table('users')->where('id', $receiverId)
                ->update(['balance' => DB::raw('balance + ' . number_format($amount, 2, '.', ''))]);

            $tx = Transaction::create([
                'sender_id' => $senderId,
                'receiver_id' => $receiverId,
                'amount' => $amount,
                'commission_fee' => $commission,
                'total_debited' => $totalDebited,
            ]);

            return $tx;
        }, 5);

        return response()->json([
            'message' => 'Transfer successful.',
            'transaction' => $result,
        ], 201);
    }
}

