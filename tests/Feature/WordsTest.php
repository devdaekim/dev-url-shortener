<?php

namespace Tests\Feature;

use App\Models\Word;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class WordsTest extends TestCase
{
    use RefreshDatabase;
    protected $file = 'eff_short_wordlist_2_0.txt';

    /**
     * testing the word list file exists in storage/app
     * @test
     * @return boolean
     */
    public function does_the_word_list_exist()
    {
        $this->withExceptionHandling();
        $file_exists = Storage::disk('local')->exists($this->file);
        $this->assertTrue($file_exists);
    }


    /**
     * test if the word list is readable
     * @test */
    public function is_the_word_list_readable()
    {
        $path = Storage::disk('local')->path($this->file);
        $this->assertFileIsReadable($path);
    }

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

    /** @test */
    public function can_word_list_table_be_populated_with_the_list_file()
    {
        if (Storage::disk('local')->exists($this->file) && Storage::disk('local')->path($this->file)) {
            foreach ($this->processWordList($this->file) as $row) {
                $word = Word::UpdateOrCreate(['word' => $row['word']], $row);
                $this->assertDatabaseHas('words', $word->toArray());
            }
        }
    }
}
