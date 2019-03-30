<?php

namespace Tests\Setup;

use App\City;
use App\Room;
use App\User;

class CityFactory 
{
    protected $roomsCount = 0;
    
    protected $user;

    /**
     * 
     * 
     * @return
     */
    public function ownedBy($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * 
     * 
     * @return
     */
    public function withRooms($count) 
    {
        $this->roomsCount = $count;

        return $this;
    }

    /**
     * 
     * 
     * @return
     */
    public function create() 
    {
        $city = factory(City::class)->create();

        factory(Room::class, $this->roomsCount)->create([
            'city_id' => $city->id,
            'user_id' => $this->user ?? factory(User::class)
        ]);

        return $city;
    }
}