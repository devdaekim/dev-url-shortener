<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'long_url', 'word_id', 'description', 'private', 'user_id', 'counts',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'private' => 'boolean',
        'counts' => 'integer',
    ];

    /**
     * A link belongs to a word
     * @return relationship
     */
    public function word()
    {
        return $this->belongsTo('App\Models\Word');
    }

    /**
     * Private links belong to user
     * @return relationship
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }
}
