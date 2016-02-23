<?php

namespace App\Http\Controllers;

use Hash;
use Config;
use Validator;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp;
use GuzzleHttp\Subscriber\Oauth\Oauth1;
use App\Post;
use Carbon\Carbon;
use Auth;


class PostsController extends Controller
{


    public function __construct(){
       $this->middleware('auth');
       //$this->middleware('jwt.auth', ['except' => ['authenticate']]);
    }

    protected function createToken($user){
        $payload = [
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + (2 * 7 * 24 * 60 * 60)
        ];
        return JWT::encode($payload, Config::get('app.token_secret'));
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
        return $post;
    	
    }

    public function edit($id){
    	$post =  Post::findOrFail($id);    	
    }

    public function update($id, PostRequest $request){
    	$post =  Post::findOrFail($id);
    	$post->update($request->all());
    }
}
