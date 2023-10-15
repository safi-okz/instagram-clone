<?php

namespace App\Http\Controllers;

use App\Http\Resources\AllPostsCollection;
use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Services\FileService;
use Inertia\Inertia;

class UserController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = User::find($id);
        if($user === null) {
            return redirect()->route('home.index');
        }

        $posts = Post::where('user_id', $id)->orderBy('created_at', 'desc')->get();

        return Inertia::render('User', [
            'user' => $user,
            'postByUser' => new AllPostsCollection($posts)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate(['file' => 'required|mimes:jpg,jpeg,png']);
        $user = (new FileService)->updateFile(auth()->user(), $request, 'user');
        $user->save();

        return redirect()->route('user.show',['id' => auth()->user()->id]);    }
}
