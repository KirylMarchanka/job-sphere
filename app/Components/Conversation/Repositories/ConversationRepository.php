<?php

namespace App\Components\Conversation\Repositories;

use App\Models\Conversation;
use App\Models\Interfaces\SenderInterface;
use App\Models\JobApply;
use App\Models\User;

class ConversationRepository
{
    private JobApply $apply;

    public function store(string $title, ?string $channel = null): Conversation
    {
        $channel = $channel ?? sprintf('job_apply_%d', $this->apply->getKey());

        return $this->apply->conversation()->create(['title' => $title, 'channel' => $channel]);
    }

    public function setApply(JobApply $apply): ConversationRepository
    {
        $this->apply = $apply;
        return $this;
    }
}
