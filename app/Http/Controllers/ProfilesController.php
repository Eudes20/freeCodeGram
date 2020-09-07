<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
    public function show($id)
    {
        $user = User::findOrFail($id);

        $follow_status = (Auth::user()) ? User::find(Auth::user()->id)->following->contains($user->profile->id) : false;

        $postCount = Cache::remember(
            'count.post.'. $user->id,
            now()->addSeconds(30),
            function () use ($user) {
                return $user->posts->count();
            }
        );

        $followersCount = Cache::remember(
            'count.followers.'. $user->id,
            now()->addSeconds(30),
            function () use ($user) {
                return $user->profile->followers->count();
            }
        );

        $followingCount = Cache::remember(
            'count.following.'. $user->id,
            now()->addSeconds(30),
            function () use ($user) {
                return $user->following->count();
            }
        );

        return view('profiles.show',
            compact(
                'user', 'follow_status', 'postCount', 'followersCount', 'followingCount'
            )
        );
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);

        //authorization using ProfilePolicy
        $this->authorize('update', $user->profile);

        return view('profiles.edit', compact('user'));
    }

    public function update(Request $request) {

        $user = Auth::user();
        $this->authorize('update', $user->profile);

        $data = $request->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => 'image'
        ]);

        if($request->hasFile('image')) {

            $file = $request->file('image');
            $fileName = 'IMG_'.time().'.'.$file->getClientOriginalExtension();

            $imagePath = $request->image->storeAs(
                'profile', $fileName , 'public'
            );

            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();

            $setImage = ['image' => $imagePath];
        }
        
        $user->profile->update(array_merge(
            $data,
            $setImage ?? [] //if is set return itself if not return an empty array
        ));

        return redirect("/profile/{$user->id}");
    }
}
