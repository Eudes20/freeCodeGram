@extends('layouts.app')

@section('content')
<div class="container">
  @foreach ($posts as $item)
    <div class="pt-2 pb-4">
      <div class="row">
        <div class="col-6 offset-3">
          <a href="/profile/{{ $item->user->id }}">
            <img src="/storage/{{ $item->image }}" class="w-100">
          </a>
        </div>
      </div>

      <div class="row">
        <div class="col-6 offset-3">
          <div>
            <p>
              <span class="font-weight-bold">
                <a href="/profile/{{ $item->user->id }}">
                  <span class="text-dark">{{ $item->user->username }}</span>
                </a>
              </span>
              {{ $item->caption }}
            </p>
          </div>
        </div>
      </div>
    </div>
  @endforeach
  <div class="row">
    <div class="col d-flex justify-content-center">
      {{ $posts->links() }}
    </div>
  </div>
</div>
@endsection
