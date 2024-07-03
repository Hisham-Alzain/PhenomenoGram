<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    public function profileImage(){
        if($this->image){
            return '/storage/' .$this->image;
        }
        return "https://i0.wp.com/getstamped.co.uk/wp-content/uploads/WebsiteAssets/Placeholder.jpg";
    }

    protected $guarded=[];
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function followers(){
        return $this->belongsToMany(User::class);
    }
}