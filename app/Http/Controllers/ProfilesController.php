<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Cache;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
        $follows=(auth()->user()) ? auth()->user()->following->contains($user->id):false;
        
        $following=Cache::remember('count.following.' .$user->id,now()->addSeconds(5),function() use($user){
            return $user->following()->count();
        });
        $followers=Cache::remember('count.followers.' .$user->id,now()->addSeconds(5),function() use($user){
            return $user->profile->followers()->count();
        });
        $postsCount= Cache::remember('count.posts.' .$user->id,now()->addSeconds(5),function() use($user){
            return $user->posts()->count();
        });   

        return view('profiles.index',[
            'user'=>$user,'follows'=>$follows,'postsCount'=>$postsCount,'followers'=>$followers,'following'=>$following
        ]);
    }
    
    // this is two diffrent way to grab a variable from routes
    
    public function edit(\App\Models\User $user)
    {
        $this->authorize('update',$user->profile);    
        return view('profiles.edit',compact('user'));
    }

    public function update(User $user){
        $this->authorize('update',$user->profile);
        $data=request()->validate([
            'title'=>'required',
            'description'=>'required',
            'url'=>'url',
            'image'=>['image'],
        ]);
        $imagePath=request('image');
        if(request('image')){
            $imagePath=request('image')->store('uploads','public');
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();
            $imageArray=['image'=>$imagePath];
        }

        auth()->user()->profile->update(array_merge(
            $data,
            $imageArray ?? [],
        ));
        return redirect ("/profile/{$user->id}");
}
}