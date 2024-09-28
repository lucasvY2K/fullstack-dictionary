<?php

namespace App\Http\Controllers;

use App\Repositories\FavoriteRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FavoriteController extends Controller
{
    protected $favoriteRepository;

    public function __construct(FavoriteRepository $favoriteRepository) {
        $this->favoriteRepository = $favoriteRepository;
    }

    public function store(Request $request) {
        $word = $request->route('word');
        $response = $this->favoriteRepository->createFavorite($word);
        
        if (isset($response['message'])) {
            return response()->json($response, 400);
        }

        return response()->noContent();
    }

    public function destroy(Request $request) {
        $word = $request->route('word');

        $response = $this->favoriteRepository->deleteFavorite($word);

        if (isset($response['message'])) {
            return response()->json($response, 404);
        }

        return response()->noContent();
    }

    public function index(Request $request) {
        $user_id = Auth::user()->id;
        $page = $request->get('page', 1);

        $response = $this->favoriteRepository->getUserFavorites($user_id, $page);

        return response()->json($response, 200);
    }
}
