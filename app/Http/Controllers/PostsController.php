<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PostsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $auth_user = User::find(Auth::user()->id);
        $users_following = $auth_user->following()->pluck('profiles.user_id');

        $posts = Post::whereIn('user_id', $users_following)
                        ->with('user') //eager loading,
                        ->latest()
                        ->paginate(5);

        //dd($posts);
        return view('posts.index', compact('posts'));
    }


    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'caption' => 'required',
            'image' => 'required|image'
        ]);

        //Use Intervention image to fit our image to same size when to render it to view
        $imagePath = $request->file('image')->store('uploads', 'public');
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        $image->save();

        $user = User::find(Auth::user()->id);

        $user->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath
        ]);

        return redirect('/profile/'.auth()->user()->id);
            
    }

    public function show ($id) {
        $post = Post::findOrFail($id);

        return view('posts.show', compact('post'));
    } 
}
