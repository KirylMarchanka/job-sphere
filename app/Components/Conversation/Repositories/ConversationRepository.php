<?php

namespace App\Components\Conversation\Repositories;

use App\Models\Conversation;

class ConversationRepository
{
    private int $employer;
    private int $user;

    public function store(string $title, string $channel): Conversation
    {
        return Conversation::query()->create([
            'employer_id' => $this->employer,
            'user_id' => $this->user,
            'title' => $title,
            'channel' => $channel,
        ]);
    }

    public function setEmployer(int $employer): ConversationRepository
    {
        $this->employer = $employer;
        return $this;
    }

    public function setUser(int $user): ConversationRepository
    {
        $this->user = $user;
        return $this;
    }
}
