<?php

namespace App\Repositories;

use App\Models\Favorite;
use App\Models\Words;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FavoriteRepository {
    public function createFavorite($word) {
        $wordRepository = new WordRepository();
        $word_exists = $wordRepository->checkWord($word);
        
        if($word_exists !== true) {
            return $word_exists;
        }

        $wordObject = Words::where('word', $word)->first();

        $favorite = Favorite::create([
            'user_id' => Auth::user()->id,
            'word_id' => $wordObject->id,
            'added' => (new DateTime())->format(DateTime::ATOM)
        ]);

        return $favorite;
    }

    public function deleteFavorite($word) {
        $wordRepository = new WordRepository();
        $word_exists = $wordRepository->checkWord($word);
        
        if($word_exists !== true) {
            return $word_exists;
        }

        $wordObject = Words::where('word', $word)->first();

        return Favorite::where('word_id', $wordObject->id)->delete();
    }

    public function getUserFavorites($user_id, $page) {
        $user_favorites = Favorite::where('user_id', $user_id)
            ->join('words', 'favorites.word_id', '=', 'words.id')
            ->select('favorites.added', 'words.word')
            ->paginate(10, ['*'], ['page'], $page)
        ;

        if($user_favorites->total() <= 0) {
            return ['message' => 'Error message'];
        }

        return $this->formatResponse($user_favorites);
    }

    private function formatResponse($user_favorites) {
        return [
            'results' => $this->formatResults($user_favorites),
            'totalDocs' => $user_favorites->total(),
            'page' => $user_favorites->currentPage(),
            'totalPages' => $user_favorites->lastPage(),
            'hasNext' => $user_favorites->hasMorePages(),
            'hasPrev' => $user_favorites->currentPage() > 1,
        ];
    }

    private function formatResults($user_favorites) {
        $results = $user_favorites->map(function($visited_word) {
            return [
                $visited_word->word, 
                Carbon::parse($visited_word->added)->format('Y-m-d\TH:i:s.v\Z')
            ];
        })->all();

        return $results;
    }
}