<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $authId = $request->user()->id;

        $perPage = max(1, min((int) $request->get('per_page', 50), 200));
        $term = trim((string) $request->get('q', ''));

        $query = User::query()
            ->where('id', '!=', $authId)
            ->select('id', 'name', 'email');

        if ($term !== '') {
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('email', 'like', "%{$term}%");
            });
        }

        $users = $query->orderBy('name')->paginate($perPage);

        return response()->json($users);
    }
}

