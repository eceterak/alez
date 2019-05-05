<?php

namespace Tests\Feature\Admin;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\CityFactory;
use Facades\Tests\Setup\RoomFactory;
use App\City;

class CitiesManagementTest extends TestCase
{
    use RefreshDatabase;

    // @test
    public function test_admin_can_create_a_city() 
    {        
        $this->admin();

        $this->get(action('Admin\CitiesController@create'))->assertStatus(200);

        $this->post(route('admin.cities.store'), $attributes = factory(City::class)->raw())->assertRedirect(route('admin.cities'));

        $city = City::where($attributes)->first();
        
        $this->get(route('admin.cities'))->assertSee($city->name);
    }

    // @test
    public function test_admin_can_update_a_city() 
    {
        $this->admin();

        $city = CityFactory::create();
        
        $this->get(route('admin.cities.edit', $city->slug))->assertSee($city->name);

        $this->patch(route('admin.cities.update', $city->slug), $attributes = factory(City::class)->raw())->assertRedirect(route('admin.cities'));

        $this->assertDatabaseHas('cities', $attributes);
    }

    // @test
    public function test_adverts_from_city_can_be_displayed()
    {
        $this->admin();

        $room = RoomFactory::create();

        $this->get(route('admin.cities.adverts', $room->city->slug))->assertSee($room->shortTitle());
    }

    // @test
    public function test_streets_of_a_city_can_be_displayed()
    {
        $this->admin();

        $street = RoomFactory::create();

        $this->get(route('admin.cities.streets', $street->city->slug))->assertSee($street->name);
    }

    // @test
    public function test_a_city_can_be_deleted()
    {
        $this->admin();

        $city = CityFactory::create();

        $this->delete(route('admin.cities.destroy', $city->id))->assertRedirect(route('admin.cities'));

        $this->assertDatabaseMissing('cities', $city->only('id'));
    }
}