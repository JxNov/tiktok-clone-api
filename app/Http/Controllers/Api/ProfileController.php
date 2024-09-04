<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\AllPostsCollection;
use App\Http\Resources\UsersCollection;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ProfileController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show($username)
    {
        try {
            $id = User::where('username', $username)->first()->id;

            $posts = Post::where('user_id', $id)->orderBy('created_at', 'desc')->get();
            $user = User::where('id', $id)->get();

            return response()->json([
                'posts' => new AllPostsCollection($posts),
                'user' => new UsersCollection($user),
                'following' => new UsersCollection(User::find($id)->following),
                'followers' => new UsersCollection(User::find($id)->followers),
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
