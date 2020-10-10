<?php

namespace Database\Seeders;

use App\Models\Word;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class WordSeeder extends Seeder
{
    protected $file = 'eff_short_wordlist_2_0.txt';

    private function processWordList($file)
    {
        $path = Storage::disk('local')->path($file);
        $contents = fopen($path, 'r');
        while (!feof($contents)) {
            $row = trim(fgets($contents));
            if (!empty($row)) {
                $data = explode("\t", $row);
                yield [
                    'listing_no' => (int) $data[0],
                    'word' => $data[1]
                ];
            }
        }
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Storage::disk('local')->exists($this->file) && Storage::disk('local')->path($this->file)) {
            foreach ($this->processWordList($this->file) as $row) {
                Word::UpdateOrCreate(['word' => $row['word']], $row);
            }
        }
    }
}
