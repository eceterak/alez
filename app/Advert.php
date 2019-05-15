<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Filters\QueryFilter;
use App\Traits\RecordsActivity;
use App\Traits\Favouritable;

class Advert extends Model
{
    use RecordsActivity, Favouritable;

    /**
     * Mass assiggnment.
     * 
     * @var array
     */
    protected $guarded = [];

    /**
     * Always eager load user details.
     * 
     * @var array
     */
    protected $with = [
        'city',
        'user', 
        'favourites'
    ];

    /**
     * Default attributes.
     * 
     * @var array
     */
    protected $attributes = [
        'verified' => false,
        'active' => false
    ];

    /**
     * Register custom attributes.
     * 
     * @var array
     */
    protected $appends = [
        'isFavourited'
    ];

    /**
     * Replace default key for route model binding.
     * 
     * @return string
     */
    public function getRouteKeyName() 
    {
        return 'slug';
    }

    /**
     * Casts from database to model.
     * 
     * @var array
     */
    protected $casts = [
        'verified' => 'boolean',
        'active' => 'boolean'
    ];

    /**
     * Define eloquent relationship between user and advert.
     * 
     * @return App\User
     */
    public function user() 
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Define eloquent relationship between city and advert.
     * 
     * @return App\City
     */

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    /**
     * Define eloquent relationship between street and advert.
     * 
     * @return App\City
     */

    public function street()
    {
        return $this->belongsTo(Street::class);
    }

    /**
     * Advert can have many conversations.
     * 
     * @return App\Conversation
     */
    public function conversations() 
    {
        return $this->hasMany(Conversation::class);
    }

    /**
     * Create a temporary advert.
     * 
     * @return App\TemporaryAdvert
     */
    static public function temporary() 
    {
        return TemporaryAdvert::create();
    }

    /**
     * Find a temporary advert.
     * 
     * @param int $id
     * @param string $token
     * @return App\TemporaryAdvert
     */
    static public function getTemporary($id, $token) 
    {
        return TemporaryAdvert::where('id', $id)->where('token', $token)->firstOrFail();
    }

    /**
     * Return a portion of a title.
     * 
     * @return string
     */
    public function shortTitle() 
    {
        return str_limit($this->title, 20, '...');
    }

    /**
     * Scope to get access to QueryBuilder.
     * 
     * @param $query
     * @param QueryFilter $filters
     * @return QueryFilters
     */
    public function scopeFilter($query, QueryFilter $filters) 
    {
        return $filters->apply($query);
    }

    /**
     * Verify an advert. Verified advert should be also activated.
     * 
     * @return void
     */
    public function verify() 
    {
        $this->update([
            'verified' => true,
            'active' => true
        ]);

        $this->recordActivity('verified_advert');
    }

    /**
     * Send an inquiry about the advert.
     * 
     * @param string $body
     * @return void
     */
    public function inquiry($body) 
    {
        $conversation = $this->conversations()->create([
            'receiver_id' => $this->user->id,
            'sender_id' => auth()->user()->id
        ]);

        auth()->user()->messages()->create([
            'conversation_id' => $conversation->id,
            'body' => $body
        ]);
    }

    /**
     * Generate a slug after advert is added to a database (it uses a id).
     * 
     * @return void
     */
    public function generateSlug() 
    {
        $this->update([
            'slug' => str_slug($this->title.'-uid-'.$this->encodeId())
        ]);
    }

    /**
     * Encode id.
     * 
     * @return string
     */
    public function encodeId() 
    {
        return base_convert($this->id, 10, 36);
    }

}