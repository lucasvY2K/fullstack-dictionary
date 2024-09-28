<?php

namespace App\Repositories;

use App\Models\Histories;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Facades\Http;

class HistoryRepository {
    public function createHistory($user_id, $word) {
        $base_api_url = "https://api.dictionaryapi.dev/api/v2/entries/en/$word";
        $response = Http::get($base_api_url);

        if($response->notFound()) {
            return ['message' => 'Error message'];
        }

        $history = Histories::create([
            'user_id' => $user_id,
            'word' => $word,
            'added' => (new DateTime())->format(DateTime::ATOM)
        ]);

        return $history->id;
    }

    public function getUserHistory($user_id, $page) {
        $user_history = Histories::where('user_id', $user_id)->select('*')->paginate(10, ['*'], ['page'], $page);
        if($user_history->total() <= 0) {
            return ['message' => 'Error message'];
        }

        return $this->formatResponse($user_history);
    }

    private function formatResponse($user_history) {
        return [
            'results' => $this->formatResults($user_history),
            'totalDocs' => $user_history->total(),
            'page' => $user_history->currentPage(),
            'totalPages' => $user_history->lastPage(),
            'hasNext' => $user_history->hasMorePages(),
            'hasPrev' => $user_history->currentPage() > 1,
        ];
    }

    private function formatResults($user_history) {
        $results = $user_history->map(function($visited_word) {
            return [
                $visited_word->word,
                Carbon::parse($visited_word->added)->format('Y-m-d\TH:i:s.v\Z')
            ];
        })->all();

        return $results;
    }
}