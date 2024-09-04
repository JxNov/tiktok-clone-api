<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use App\Models\Follow;

class FollowController extends Controller
{
    public function follow(Request $request)
    {
        $request->validate([
            'username' => 'required',
        ]);

        try {
            $username = $request->input('username');
            $id = User::where('username', $username)->first()->id;

            $follow = new Follow();
            $follow->follower_id = auth()->user()->id;
            $follow->following_id = $id;
            $follow->save();

            $userFollow = User::findOrfail($id)->followers()->where('follower_id', auth()->user()->id)->first();

            return response()->json([
                'follow' => [
                    'id' => $follow->id,
                    'followers' => $userFollow,
                ],
                'success' => 'OK',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }

    }

    public function unfollow(Request $request)
    {
        $request->validate([
            'user_followed' => 'required',
            'user_following' => 'required',
        ]);

        try {
            $username_follow = $request->input('user_followed');
            $username_following = $request->input('user_following');
            $idUserFollow = User::where('username', $username_follow)->first()->id;
            $idUserFollowing = User::where('username', $username_following)->first()->id;

            $follow = Follow::where('follower_id', $idUserFollow)->where('following_id', $idUserFollowing)->first();
            if (count(collect($follow)) > 0) {
                $follow->delete();
            }

            return response()->json([
                'follow' => [
                    'id' => $follow->id,
                    'followers' => $follow,
                ],
                'success' => 'OK',
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
