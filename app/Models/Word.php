<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Word extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'listing_no', 'word', 'available',
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'available' => 'boolean',
    ];

    /**
     * A word has a link
     * @return relationship
     */
    public function link()
    {
        return $this->hasOne('App\Models\Link');
    }

    /**
     * Scope a query to only return the id of a random availabe word
     * returns {id: n}
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable($query)
    {
        return $query->select('id')->where('available', true)->inRandomOrder()->first();
        // TODO  remove if not errors: return $query->where('available', true)->pluck('id')->toArray();
    }
}
