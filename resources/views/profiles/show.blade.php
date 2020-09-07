@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-5">
                <img
                    class="rounded-circle"
                    src="{{ $user->profile->profileImage() }}"
                    style="max-width: 150px; max-height: 150px;"
                    alt="profile"
                >
        </div>
        <div class="col-9 pt-5">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class="d-flex align-items-center pb-4">
                    <h4 class="pr-3">{{ $user->username }}</h4>
                    
                    <follow-button user-id="{{ $user->id }}" follow-status="{{ $follow_status }}"/>
                </div>
                
                @can('update', $user->profile)
                    <a href="/p/create">Add New Post</a>
                @endcan
            </div>

            @can('update', $user->profile)
                <a href="/profile/{{ $user->id }}/edit">Edit Profile</a>
            @endcan

            <div class="d-flex">
                <div class="pr-5"><strong>{{ $postCount }}</strong>posts</div>
                <div class="pr-5"><strong>{{ $followersCount }}</strong>followers</div>
                <div class="pr-5"><strong>{{ $followingCount }}</strong>following</div>
            </div>
            <div class="pt-5 font-weight-bold">{{ $user->profile->title }}</div>
            <div>{{ $user->profile->description }}</div>
            <div><a href="#">{{ $user->profile->url }}</a></div>
        </div>
    </div>
    <div class="row pt-5">
        @foreach ($user->posts as $post)
            <div class="col-4 pb-3">
            <a href="/p/{{ $post->id }}">
                    <img src="/storage/{{ $post->image }}" class="w-100">
                </a>
            </div>
        @endforeach
    </div>
</div>
@endsection
