<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Facades\Tests\Setup\CityFactory;
use App\City;

class CitiesManagementTest extends TestCase
{
    use RefreshDatabase;

    // @test
    public function test_guest_can_view_a_city() 
    {        
        $city = CityFactory::create();

        $this->get(route('cities'))->assertSee($city->name);

        $this->get(route('cities.show', $city->path()))->assertSee($city->name);
    }

    // @test
    public function test_guests_cannot_manage_cities() 
    {
        $city = CityFactory::create();

        $this->get(route('admin.cities'))->assertRedirect(route('admin.login'));
        $this->get(route('admin.cities.create'))->assertRedirect(route('admin.login'));
        $this->post(route('admin.cities.store'), [])->assertRedirect(route('admin.login'));
        $this->get(route('admin.cities.edit', [$city->path()]))->assertRedirect(route('admin.login'));
        $this->patch(route('admin.cities.update', [$city->path()]), [])->assertRedirect(route('admin.login'));
    }

    // @test
    public function test_admin_can_create_a_city() 
    {        
        $this->withoutExceptionHandling();

        $this->admin();

        $this->get(route('admin.cities.create'))->assertStatus(200);

        $this->post(route('admin.cities.store'), $attributes = factory(City::class)->raw())->assertRedirect(route('admin.cities'));

        $city = City::where($attributes)->first();
        
        $this->get(route('admin.cities'))->assertSee($attributes['name']);
        
        $this->get(route('admin.cities.edit', $city->path()))->assertStatus(200);
    }

    // @test
    public function test_admin_can_update_a_city() 
    {
        $this->admin();

        $city = CityFactory::create();
        
        $this->get(route('admin.cities.edit', $city->path()))->assertSee($city->name);

        $this->patch(route('admin.cities.update', $city->path()), $attributes = [
            'name' => 'changed'
        ])->assertRedirect(route('admin.cities'));

        $this->assertDatabaseHas('cities', $attributes);
    }
}
