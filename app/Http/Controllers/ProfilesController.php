<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
    public function show($user)
    {
        $user = User::findOrFail($user);

        return view('profiles.index', compact('user'));
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
        }
        
        $user->profile->update(array_merge(
            $data,
            ['image' => $imagePath]
        ));

        return redirect("/profile/{$user->id}");
    }
}
