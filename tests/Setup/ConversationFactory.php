<?php

namespace Tests\Setup;

use App\Conversation;
use App\User;
use Facades\Tests\Setup\AdvertFactory;

class ConversationFactory 
{    
    protected $sender = null;

    /**
     * Set a sender.
     * 
     * @return
     */
    public function sentBy(User $user) 
    {
        $this->sender = $user;

        return $this;
    }

    /**
     * Create a new instance of App\Conversation.
     * 
     * @return
     */
    public function create() 
    {
        $advert = AdvertFactory::create();

        return factory(Conversation::class)->create([
            'advert_id' => $advert->id,
            'sender_id' => $this->sender ?? factory(User::class),
            'receiver_id' => $advert->user->id
        ]);
    }
}