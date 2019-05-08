<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\AdvertFactory;
use Facades\Tests\Setup\CityFactory;

class SearchTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function search_by_id_of_selected_item_from_autocomplete_list()
    {        
        $advert = AdvertFactory::create();

        $this->get(route('search.index', [
            'city' => 'ignore this value',
            'city_id' => $advert->city->id
        ]))
        ->assertRedirect(route('cities.show', [$advert->city->slug]));
    }

    /** @test */
    public function search_by_query() 
    {
        $this->withoutExceptionHandling();

        $advert = AdvertFactory::create();

        $this->get(route('search.index', [
            'city' => $advert->city->name,
            'city_id' => ''
        ]))
        ->assertRedirect(route('cities.show', [$advert->city->slug]));
    }

    /** @test */
    public function search_by_query_with_commas() 
    {
        $this->withoutExceptionHandling();

        $advert = AdvertFactory::create();

        $this->get(route('search.index', [
            'city' => $advert->city->name.','.$advert->city->community.','.$advert->city->state,
            'city_id' => ''
        ]))
        ->assertRedirect(route('cities.show', [$advert->city->slug]));
    }
    
    /** @test */
    public function ajax_autocomplete_suggestions() 
    {
        $city = CityFactory::create();
        
        $this->post(action('AjaxController@cities'), [
            'city' => substr($city->name, 0, 3)
        ])
        ->assertSee($city->name);
    }
    
    //@test
    public function empty_search_query_redirect_to_adverts_index()
    {
        $this->get(route('search.index'), [
            'city' => '',
            'city_id' => ''
        ])
        ->assertRedirect(route('adverts'));
    }
    
}
