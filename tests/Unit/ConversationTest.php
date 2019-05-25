<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\ConversationFactory;
use Facades\Tests\Setup\AdvertFactory;

class ConversationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_has_exactly_two_participants()
    {
        $conversation = ConversationFactory::create();

        $this->assertCount(2, $conversation->users);
    }

    /** @test */
    public function it_can_reply()
    {
        $this->signIn();

        $conversation = ConversationFactory::create();
        
        $conversation->reply('Thanks mate', $conversation->advert);

        $this->assertCount(2, $conversation->messages);
    }

    /** @test */
    public function it_requires_a_body()
    {
        $conversation = ConversationFactory::create();

        $this->actingAs($conversation->users[0])->post(route('conversations.reply', $conversation->id), [
            'body' => null
        ])->assertSessionHasErrors('body');
    }

    /** @test */
    public function it_can_define_who_sent_inquiry()
    {
        $advert = AdvertFactory::create();

        $user = $this->signIn();

        $conversation = $advert->inquiry('Hi bruh');

        $this->assertSame($user->id, $conversation->sender->id);
    }
}
