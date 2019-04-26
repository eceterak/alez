<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Street;
use App\City;

class StreetsController extends Controller
{
    /**
     * 
     * 
     * @return
     */
    public function index($city) 
    {
        return view('admin.streets.index')->with([
            'streets' => City::getByPath($city)->streets
        ]);
    }

    public function edit($city, $street)
    {
        return view('admin.streets.edit')->with([
            'street' => Street::getByPath($city, $street)
        ]);
    }

    /**
     * 
     * 
     * @return
     */
    public function store($city) 
    {
        $city = City::getByPath($city);

        $city->streets()->create(request()->validate([
            'name' => 'required',
            'type' => 'required',
            'lat' => 'required',
            'lon' => 'required',
            'importance' => 'sometimes',
            //'city' => 'required',
            'coordinates' => 'required'
        ]));

        return redirect(route('admin.cities.streets', $city->path()));
    }

    /**
     * 
     * 
     * @return
     */
    public function update($city, $street) 
    {
        Street::getByPath($city, $street)->update(request()->validate([
            'name' => 'required',
            'type' => 'required',
            'lat' => 'required',
            'lon' => 'required',
            'importance' => 'sometimes',
            //'city' => 'required',
            'coordinates' => 'required'
        ]));

        return redirect()->route('admin.streets');
    }
}
