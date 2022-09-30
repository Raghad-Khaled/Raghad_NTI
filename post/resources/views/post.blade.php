@extends('layouts.parent')
@section('contant')
    <h1 class="text-center"> {{$post->title}} </h1>
    <div class="card" >
        <img class="w-50 rounded mx-auto d-block" src="{{ asset('images/posts/' . $post->image) }}" class="card-img-top" alt="post image">
        <div class="card-body">
          <p class="card-text">{{$post->details}}</p>
        </div>
        @if ($post->link)
            <object class="mx-auto d-block" width="500" height="400" data="{{ $post->link }}" type="application/x-shockwave-flash"><param name="src" value="{{ $post->link }}" /></object>
        @endif

        <h2 class="text-center mt-5">Author : {{$post->name}}</h2>
      </div>
@endsection
