<?php

namespace App\Http\Controllers;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('pages.home')->with([
            'profile' => $user = auth()->user(),
            'adverts' => $user->adverts()->paginate()
        ]);
    }
}
