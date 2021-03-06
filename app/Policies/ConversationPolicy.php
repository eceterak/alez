<?php

namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use App\Conversation;
use App\User;

class ConversationPolicy
{
    use HandlesAuthorization;

    /**
     * Check if a user is an participant of conversation.
     * 
     * @param User $user
     * @param Conversation $conversation
     * @return bool
     */
    public function view(User $user, Conversation $conversation) 
    {
        return $conversation->users->contains($user);
    }

    /**
     * Check if user can reply and if any of the account was not already deleted.
     * 
     * @param User $user
     * @param Conversation $conversation
     * @return bool
     */
    public function reply(User $user, Conversation $conversation) 
    {
        return $conversation->users->contains($user);
    }
}
