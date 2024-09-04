<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class LikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'post_id' => 'required',
        ]);

        try {
            $like = new Like();

            $like->user_id = auth()->user()->id;
            $like->post_id = $request->input('post_id');

            $like->save();

            return response()->json([
                'like' => [
                    'id' => $like->id,
                    'user_id' => $like->user_id,
                    'post_id' => $like->post_id,
                ],
                'success' => 'OK',
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $like = Like::find($id);
            if (count(collect($like)) > 0) {
                $like->delete();
            }

            return response()->json([
                'like' => [
                    'id' => $like->id,
                    'user_id' => $like->user_id,
                    'post_id' => $like->post_id,
                ],
                'success' => 'OK',
            ], Response::HTTP_OK);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
