<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;

class ReadAdvertsTest extends TestCase
{
    use RefreshDatabase;

    protected $advert;

    public function setUp()
    {
        parent::setUp();

        $this->advert = AdvertFactory::create();
    }

    /** @test */
    public function a_user_can_view_all_adverts()
    {
        $this->get(route('adverts'))->assertSee($this->advert->title);
    }

    /** @test */
    public function a_user_can_view_a_single_advert()
    {
        $this->get(route('adverts.show', [$this->advert->city->slug, $this->advert->slug]))->assertSee($this->advert->title);
    }

    /** @test */
    public function ajax_can_request_adverts_from_a_city()
    {
        //$this->withoutExceptionHandling();

        $response = $this->getJson(route('ajax.city.adverts', $this->advert->city->slug))->json();

        $this->assertCount(1, $response['data']);
    }
}
