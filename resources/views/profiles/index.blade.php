@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-5">
            <img
                class="rounded-circle"
                src="/images/image1.png"
                style="max-width: 150px; max-height: 150px;"
                alt="profile"
            >
        </div>
        <div class="col-9 pt-5">
            <div class="d-flex justify-content-between align-items-baseline">
                <h1>{{ $user->username }}</h1>
                <a href="#">Add New Post</a>
            </div>
            <div class="d-flex">
                <div class="pr-5"><strong>153</strong>posts</div>
                <div class="pr-5"><strong>23k</strong>followers</div>
                <div class="pr-5"><strong>212</strong>following</div>
            </div>
            <div class="pt-5 font-weight-bold">{{ $user->profile->title }}</div>
            <div>{{ $user->profile->description }}</div>
            <div><a href="#">{{ $user->profile->url }}</a></div>
        </div>
    </div>
    <div class="row pt-5">
        <div class="col-4"><img src="/images/image1.png" class="w-100"></div>
        <div class="col-4"><img src="/images/image2.png" class="w-100"></div>
        <div class="col-4"><img src="/images/image3.png" class="w-100"></div>
    </div>
</div>
@endsection
