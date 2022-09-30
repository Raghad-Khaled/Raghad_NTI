<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Models\Post;
use App\Models\User;
use App\Services\HasMedia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PostsContoller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts= Post::all();
        return view('dashboard',compact('posts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        //dd($request->user());
        $imageName =HasMedia::upload($request->file('image'),public_path('images\posts'));
        $data = $request->except('_token','image');
        $data['image'] = $imageName;
        $data['user_id']=$request->user()->id;
        if(isset($request->link)){
           $data['link']="http://www.youtube.com/v/".explode('?v=',$request->link)[1];
        }
        Post::create($data);
        return redirect()->route('dashboard')->with('success','Product Created Successfully');
    }


     /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post=Post::findOrFail($id);
        HasMedia::delete(public_path('images\posts\\'.$post->image));
        $post->delete();
        return redirect()->route('dashboard')->with('success','Product Deleted Successfully');
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function find(Request $request, $id)
    {
        // $post=Post::findOrFail($id);
        // $user=User::select('name')->where('id', $post->user_id)->get()->first();
        $post = DB::select('select posts.*,users.name as name from posts JOIN users ON posts.user_id=users.id WHERE posts.id=?',[$id])[0];
        return view('post',compact('post'));
    }
}
