<?php

namespace App\Http\Controllers;

use App\Repositories\WordRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class WordController extends Controller
{
    protected $wordRepository;

    public function __construct(WordRepository $wordRepository) {
        $this->wordRepository = $wordRepository;
    }

    public function index(Request $request) {
        $search = $request->get('search', '');
        $limit = $request->get('limit', 4);
        $page = $request->get('page', 1);

        $response = $this->wordRepository->searchWords($search, $limit, $page);
        return response()->json($response, 200);
    }

    public function show(Request $request) {
        $word = $request->route('word');
        $response = $this->wordRepository->fetchWord($word);

        if (isset($response['message'])) {
            return response()->json($response, 400);
        }

        return response()->json($response, 200);
    }
}
