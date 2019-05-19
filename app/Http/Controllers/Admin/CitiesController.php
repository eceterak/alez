<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\City;

class CitiesController extends Controller
{
    /**
     * Display all cities.
     * 
     * @return view
     */
    public function index() 
    {
        return view('admin.cities.index')->with([
            'cities' => City::paginate(10)
        ]);
    }
    
    /**
     * Display create new form.
     * 
     * @return view
     */
    public function create() 
    {
        return view('admin.cities.create');
    }
    
    /**
     * Display edit form.
     * 
     * @param City $city
     * @return view
     */
    public function edit(City $city) 
    {         
        return view('admin.cities.edit')->with([
            'city' => $city
        ]);
    }

    /**
     * Display adverts.
     * 
     * @refactor method adverts?
     * @param City $city
     * @return view
     */
    public function adverts(City $city) 
    {
        return view('admin.cities.adverts')->with([
            'city' => $city->load('adverts')
        ]);
    }
    
    /**
     * Create a new city.
     * 
     * @param Request $request
     * @return redirect
     */
    public function store(Request $request) 
    {
        $attributes = $this->validateRequest($request); // Refactor?s
        
        //$attributes['slug'] = str_slug($attributes['name']); // Refactor

        City::create($attributes);
        
        return redirect(route('admin.cities'));
    }
        
    /**
     * Update a city.
     * 
     * @param string $slug
     * @param Request $request
     * @return redirect
     */
    public function update($slug, Request $request) 
    {
        $city = City::where('slug', $slug)->firstOrFail();

        $attributes = $this->validateRequest($request);

        if($request->has('suggested')) $attributes['suggested'] = 1; // Refactor
        else $attributes['suggested'] = 0;

        $attributes['slug'] = str_slug($attributes['name']); // Refactor

        $city->update($attributes);

        return redirect()->route('admin.cities');
    }

    /**
     * Delete a city.
     * 
     * @param City $city
     * @return redirect
     */
    public function destroy(City $city) 
    {
        $city->delete();

        if(request()->wantsJson())
        {
            return response([], 204);
        }

        return redirect(route('admin.cities'));
    }

    /**
     * Perform validation on incoming request.
     * 
     * @param Request $request
     * @return array
     */
    protected function validateRequest(Request $request)
    {
        return $request->validate([
            'name' => 'required',
            'type' => 'sometimes',
            'parent' => 'sometimes',
            'lat' => 'required',
            'lon' => 'required',
            'importance' => 'sometimes',
            'community' => 'required',
            'county' => 'required',
            'state' => 'required',
            'west' => 'sometimes',
            'south' => 'sometimes',
            'east' => 'sometimes',
            'north' => 'sometimes'
        ]);
    }
}
