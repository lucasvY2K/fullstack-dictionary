<?php

namespace App\Console\Commands;

use App\Models\Words;
use Illuminate\Console\Command;

class ImportWords extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:import-words';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import english words to database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Retrieve the words from the source file
        $urlFile = 'https://raw.githubusercontent.com/meetDeveloper/freeDictionaryAPI/refs/heads/master/meta/wordList/english.txt';
        $content = file_get_contents($urlFile);

        // Separates the words from the retrieved file
        $lines = explode(PHP_EOL, $content);
        foreach($lines as $line) {
            $words[] = ['word' => $line];
        }

        // Make batches of words to insert faster into the database
        $wordChunks = array_chunk($words, 300);
        foreach($wordChunks as $wordChunk) {
            Words::insert($wordChunk);
        }
    }
}
