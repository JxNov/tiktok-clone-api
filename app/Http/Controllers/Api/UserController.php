<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Services\FileService;
use App\Http\Resources\UsersCollection;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function loggedInUser()
    {
        try {
            $user = User::where('id', auth()->user()->id)->get();
            return response()->json(new UsersCollection($user), Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function updateUserImage(Request $request)
    {
        $request->validate([
            'image' => 'required|mimes:jpeg,png,jpg',
        ]);

        if ($request->height === '' || $request->width === '' || $request->top === '' || $request->left === '') {
            return response()->json(['error' => 'The dimensions are incomplete'], Response::HTTP_BAD_REQUEST);
        }

        try {
            $user = (new FileService)->updateImage(auth()->user(), $request);
            $user->save();

            return response()->json(['success' => 'OK'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Display the specified resource.
     */
    public function getUser($id)
    {
        try {
            $user = User::findOrfail($id);
            return response()->json([
                'success' => 'OK',
                'user' => $user
            ], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function updateUser(Request $request)
    {
        $request->validate([
            'username' => 'nullable|min:2|unique:users,username,' . auth()->user()->id,
            'name' => 'required'
        ]);

        try {
            $user = User::findOrfail(auth()->user()->id);

            if ($request->input('username')) {
                $user->username = $request->input('username');
            }
            $user->name = $request->input('name');
            $user->bio = $request->input('bio');
            $user->save();

            return response()->json(['success' => 'OK'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        }
    }
}
