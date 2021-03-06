<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Filters\AdvertFilters;
use App\Http\Requests\CreateAdvertRequest;
use App\Advert;
use App\City;
use App\Photo;
use App\Http\Requests\UpdateAdvertRequest;
use Illuminate\Support\Facades\Input;

class AdvertsController extends Controller
{
    /**
     * Display all available Adverts.
     * To filter the results use AdvertFilters which are injected trough route model binding.
     * 
     * @param AdvertFilters $filters
     * @return view
     */
    public function index(AdvertFilters $filters) 
    {
        return view('adverts.index')->with([
            'adverts' => Advert::latest()
                                ->where('verified', true)
                                ->where('archived', false)
                                ->filter($filters)
                                ->paginate(24)
                                ->appends(Input::except('page'))
        ]);
    }

    /**
     * Display a single advert.
     * 
     * @param string $city
     * @param Advert $advert
     * @return view
     */
    public function show($city, Advert $advert) 
    {   
        $this->authorize('view', $advert);

        $advert->increment('visits');

        if(auth()->check()) auth()->user()->sawNotificationsFor($advert);

        if(request()->expectsJson())
        {
            return $advert->load(array('photos' => function($query) {
                $query->orderBy('order', 'asc');
            }));
        }

        return view('adverts.show')->with([
            'advert' => $advert->load(array('photos' => function($query) {
                $query->where('order', '!=', 0)->orderBy('order', 'asc');
            }))
        ]);
    }

    /**
     * Display a create new advert form.
     * 
     * @return view
     */
    public function create() 
    {
        return view('adverts.create');
    }

    /**
     * Store a new advert in a database.
     * 
     * @Refactor
     * @param Request $request
     * @return redirect
     */
    public function store(CreateAdvertRequest $request) 
    {
        $advert = auth()->user()->adverts()->create($request->validated()); // @refactor user->addAdvert();

        if(request()->has('photos'))
        {
            $photos = explode(',', request('photos'));

            foreach($photos as $key => $photo)
            {
                Photo::find($photo)->update([
                    'advert_id' => $advert->id,
                    'order' => $key
                ]);
            }
        }

        return redirect(route('home'))
            ->with('flash', 'Ogloszenie dodane'); // @todo display on the page ;)
    }
    
    /**
     * Display an edit form.
     * 
     * @param string $city
     * @param Advert $advert
     * @return view
     */
    public function edit($city, Advert $advert) 
    {      
        $this->authorize('update', $advert);

        $advert->loadPendingRevision();

        return view('adverts.edit')->with([
            'advert' => $advert->load(array('photos' => function($query) {
                $query->orderBy('order', 'asc');
            }))
        ]);
    }

    /**
     * Update an advert.
     * 
     * @param string $city
     * @param Advert $advert
     * @return redirect
     */
    public function update($city, Advert $advert, UpdateAdvertRequest $request) 
    {      
        $advert->revise($request->validated());

        return redirect(route('home'));
    }

    /**
     * Delete an advert.
     * 
     * @param $city
     * @param Advert $advert
     * @return redirect
     */
    public function destroy($city, Advert $advert) 
    {
        $this->authorize('update', $advert);

        $advert->archive();

        if(request()->expectsJson())
        {
            return response(['status' => 'Ogłoszenie usunięte']); // @refactor - vue component
        }
     
        return redirect()->back();        
    }
}
