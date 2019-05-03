<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\Street;

class AjaxController extends Controller
{
    /**
     * Fetch cities for autocomplete search suggestions.
     * 
     * @param Request $request
     * @return json
     */
    public function cities(Request $request) 
    {
        $city = $request->city;

        $cities = City::where('name', 'LIKE', '%'.$city.'%')
                        ->orderBy('importance', 'desc')
                        ->limit(10)
                        ->select('id', 'name', 'county', 'state')
                        ->get();

        return response()->json($cities);
    }

    /**
     * Fetch streets for autocomplete search suggestions.
     * 
     * @param Request $request
     * @return json
     */
    public function streets(Request $request) 
    {
        $streets = Street::where('city_id', $request->city_id)
                        ->select('id', 'name')
                        ->limit(10)
                        ->get();

        return response()->json($streets);
    }
}
