<?php

namespace App\Events;

use App\Models\Transaction;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;

class TransferCompleted implements ShouldBroadcast
{
    use InteractsWithSockets, SerializesModels;

    public $transaction;
    public $senderId;
    public $receiverId;
    public $senderNewBalance;
    public $receiverNewBalance;

    public function __construct(Transaction $tx,$senderNewBalance, $receiverNewBalance)
    {
        $this->transaction = $tx->load(['sender:id,name,balance','receiver:id,name,balance']);
        $this->senderId    = $tx->sender_id;
        $this->receiverId  = $tx->receiver_id;
        $this->senderNewBalance = $senderNewBalance;
        $this->receiverNewBalance = $receiverNewBalance;
    }

    // Private channels for each user
    public function broadcastOn()
    {
        return [
            new Channel('user.' . $this->senderId),
            new Channel('user.' . $this->receiverId),
        ];
    }

    public function broadcastAs()
    {
        return 'TransferCompleted';
    }
}
