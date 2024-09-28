<?php

namespace App\Http\Controllers;

use App\Repositories\HistoryRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HistoryController extends Controller
{
    protected $historyRepository;

    public function __construct(HistoryRepository $historyRepository) {
        $this->historyRepository = $historyRepository;
    }
    public function index(Request $request) {
        $user_id = Auth::user()->id;
        $page = $request->get('page', 1);
        
        $response = $this->historyRepository->getUserHistory($user_id, $page);

        return response()->json($response, 200);
    }
}
