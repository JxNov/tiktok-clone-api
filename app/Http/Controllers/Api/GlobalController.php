<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\UsersCollection;
use App\Models\User;

class GlobalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getRandomUsers()
    {
        try {
            $suggested = User::inRandomOrder()->limit(5)->get();
            $following = User::inRandomOrder()->limit(10)->get();

            return response()->json([
                'success' => 'OK',
                'suggested' => new UsersCollection($suggested),
                'following' => new UsersCollection($following)
            ], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
