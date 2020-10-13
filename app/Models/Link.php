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
        'long_url', 'word_id', 'description', 'user_id', 'counts',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
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

    /**
     * Construct Shortened link
     *
     * @return string
     */
    public function getShortenedUrlAttribute()
    {
        return asset("/{$this->word->word}");
    }

    /**
     * Private link or not
     *
     * @return bool
     */
    public function getPrivateAttribute()
    {
        return $this->user_id !== null ? true : false;
    }
}
