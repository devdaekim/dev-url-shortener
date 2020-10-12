<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;

class RedirectToLongUrl extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke($word)
    {
        $word = Word::where('word', $word)->first();
        return redirect()->away($word->link->long_url);
    }
}
