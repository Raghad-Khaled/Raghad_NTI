@extends('layouts.parent')
@section('contant')
    <h1 class="text-center"> Creat Post </h1>
    <form action="{{ route('dashboard.posts.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" value="{{ old('title') }}" name="title" class="form-control" id="title">
            @error('title')
                <div class="alert alert-danger" role="alert">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="details_en">Details </label>
            <textarea name="details" id="details" cols="10" rows="5" class="form-control">{{ old('details') }}</textarea>
            @error('details')
                <div class="alert alert-danger" role="alert">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="image">Post Image</label>
            <input type="file" name="image" class="form-control" id="image">
            @error('image')
                <div class="alert alert-danger" role="alert">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="link">Youtube Link</label>
            <input type="url" value="{{ old('link') }}" name="link" class="form-control" id="link">
            @error('link')
                <div class="alert alert-danger" role="alert">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">creat Post</button>
    </form>


    <div class="card mt-5">
        <div class="col-12">
            @if (session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif
        </div>
        <div class="card-header">
            <h3 class="card-title">All Posts</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>

                        {{-- @foreach ($products[0] as $key => $value)
                            <th scope="col"> {{ $key }}</th>
                        @endforeach --}}

                        <th>Id</th>
                        <th>Title</th>
                        <th>Image</th>
                        <th>Operations</th>

                    </tr>
                </thead>
                <tbody>

                    @foreach ($posts as $post)
                        <tr>
                            <td>{{ $post->id }}</td>
                            <td> <a href="{{route('dashboard.post.index', $post->id)}}"> {{ $post->title }} </a> </td>
                            <td><img src="{{ asset('images/posts/' . $post->image) }}" class="w-20" alt="post image"></td>

                            <td>
                                <form action="{{ route('dashboard.posts.delete', $post->id) }}" method="post"
                                    calss="d-inline">
                                    @method('DELETE')
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger">Delete</button>
                                </form>

                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
@endsection
