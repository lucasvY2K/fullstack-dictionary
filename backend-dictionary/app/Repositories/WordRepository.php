<?php

namespace App\Repositories;

use App\Models\Words;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;

class WordRepository {
    const BASE_API_URL = "https://api.dictionaryapi.dev/api/v2/entries/en/";
    public function searchWords($search, $limit, $page) {
        $words = Words::where('word', 'like', "%$search%")
            ->select('word')
            ->paginate($limit, ['*'], ['page'], $page)
        ;

        return $this->formatResponse($words);
    }

    private function formatResponse($words) {
        $results = $words->pluck('word')->all();
        return [
            'results' => $results,
            'totalDocs' => $words->total(),
            'page' => $words->currentPage(),
            'totalPages' => $words->lastPage(),
            'hasNext' => $words->hasMorePages(),
            'hasPrev' => $words->currentPage() > 1,
        ];
    }

    public function fetchWord($word) {
        $wordExists = $this->checkWord($word);

        if($wordExists !== true) {
            return $wordExists;
        }

        $historyRepository = new HistoryRepository();
        $historyRepository->createHistory(Auth::user()->id, $word);
        return Http::get(self::BASE_API_URL . $word)->json();
    }

    public function checkWord($word) {
        $response = Http::get(self::BASE_API_URL . $word);
        
        if($response->notFound()) {
            return ['message' => 'Error message'];
        }

        return true;
    }
}