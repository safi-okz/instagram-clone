<?php

namespace App\Http\Controllers;

use App\Http\Resources\AllPostsCollection;
use Illuminate\Http\Request;
use App\Models\Post;
use Inertia\Inertia;
use App\Models\User;

class HomeController extends Controller
{
    public function index() {
        $posts = Post::orderBy('created_at', 'desc')->get();
        return Inertia::render('Home', [
            'posts' => new AllPostsCollection($posts),
            'allUsers' => User::all()
        ]);
    }
}
