<?php

namespace App\Components\Conversation\Repositories;

use App\Models\Conversation;
use App\Models\Employer;
use App\Models\Interfaces\SenderInterface;
use App\Models\User;

class ConversationMessageRepository
{
    private Conversation $conversation;

    public function send(SenderInterface $sender, string $message): void
    {
        $this->conversation->messages()->create([
            'message' => $message,
            'sender_type' => $sender->getMorphClass(),
            'sender_id' => $sender->getKey(),
        ]);
    }

    public function readAllMessages(string $senderType): void
    {
        $this->conversation
            ->messages()
            ->where('sender_type', $senderType)
            ->whereNull('read_at')
            ->update(['read_at' => now()->format('Y-m-d H:i:s')]);

        $this->conversation->touch();
    }

    public function setConversation(Conversation $conversation): ConversationMessageRepository
    {
        $this->conversation = $conversation;
        return $this;
    }
}
