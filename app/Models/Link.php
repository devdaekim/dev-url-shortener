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
     * A link can have a word
     * @return relationship
     */
    public function word()
    {
        return $this->hasOne('App\Models\Word');
    }

    /**
     * Private links belong to user
     * @return relationship
     */
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
