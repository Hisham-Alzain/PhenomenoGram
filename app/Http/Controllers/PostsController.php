<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
class PostsController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }
    public function create()
    {    
        return view('posts.create');
    }

    public function store()
    {    
        $data=request()->validate([
            'caption'=>'',
            'image'=>['required','image'],
        ]);
        $imagePath=request('image')->store('uploads','public');
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        $image->save();
        auth()->user()->posts()->create([
            'caption'=> $data['caption'],
            'image'=>$imagePath,
         ]);
        return redirect('/profile/'. auth()->user()->id);
    }

    public function show(\App\Models\Post $post){
        return view('posts.show',['post'=>$post]);
    }

    public function index(){
        $users=auth()->user()->following()->pluck("profiles.user_id");
        $posts=\App\Models\Post::whereIn('user_id',$users)->with('user')->orderBy('created_at','DESC')->get();
        return view('posts.index',compact('posts'));
    }
}

