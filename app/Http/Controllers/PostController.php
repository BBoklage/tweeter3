<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Post;
use App\Http\Resources\Post as PostResource;
use Auth;
use App\User;
class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //Get Posts
        $posts = Post::orderBy('created_at', 'desc')->paginate(10);

        return PostResource:: collection($posts);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth:: user();
        $post = $request->isMethod('put') ? Post::find($request->post_id) : new Post;
        if (isset($post->id)) {
            $post->id = $request->input('post_id');
        }
        
        $post->user_id = $user->id;
        $post->post = $request->input('post');
        
        if ($post->save()) {
            return new PostResource($post);
        }

    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //get a single post
        $post = Post:: find($id);
        return new PostResource($post);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
          //get a single post
          $post = Post:: find($id);
          if ($post->delete()) {
              return new PostResource($post);
          }
          
    }
}
