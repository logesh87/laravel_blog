<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Http\Requests\PostRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;


class PostsController extends Controller
{

    public function __construct(){
       //$this->middleware('auth');
       $this->middleware('jwt.auth', ['except' => ['authenticate']]);
    }


    public function index(){
    	$posts = Post::latest('published_at')->published()->get();
    	return  $posts;
    }

    public function show($id){
    	$post = Post::findOrFail($id);
        return $post;
    	//dd($post->published_at);
    }
    public function store(PostRequest $request){ 

        $user = Auth::User();
        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->published_at = $request->published_at;
        $post->user_id = $user->id;
        $post->save();

        //$post = new Post($request->all);    	    
    	//Auth::user()->posts()->save($post);
        return $post;
    	
    }

    public function edit($id){
    	$post =  Post::findOrFail($id);
    	//return view('posts.edit', compact('post'));	
    }

    public function update($id, PostRequest $request){
    	$post =  Post::findOrFail($id);
    	$post->update($request->all());
    	//return redirect('posts');
    }
}
