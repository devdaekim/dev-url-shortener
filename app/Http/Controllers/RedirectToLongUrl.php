<?php

namespace App\Http\Controllers;

use App\Models\Word;
use Illuminate\Http\Request;

class RedirectToLongUrl extends Controller
{
    /**
     * Handle the incoming request.
     * Redirect to the relevant logn url after incrementing the visit counts
     *
     * @param  $word
     * @return \Illuminate\Http\Response
     */
    public function __invoke($word)
    {
        $word = Word::where('word', $word)->first();
        $word->link->counts++;
        $word->link->timestamps = false; // to prevent updated_at updated
        $word->link->save();
        return redirect()->away($word->link->long_url);
    }
}
