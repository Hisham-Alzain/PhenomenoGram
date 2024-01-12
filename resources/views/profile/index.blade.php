@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-5 pt-7 ">
            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTMLtHFpEfPc1E--Yn3fad12QFJuFbxpY_SRA&usqp=CAU" height="190" width="190"class="rounded-circle" >
        </div>
        <div class="col-7 pt-6">
            <div class="d-flex justify-content-between align-items-baseline" >
                <h1>{{$user ->username}}</h1>
                <a href="#">Add New post</a>
        </div>
            <div class="d-flex" >
                <div class="pr-9"><strong> 3</strong> posts </div>
                <div class="pr-9"><strong> 670 </strong> followers </div>
                <div class="pr-9"><strong>  270  </strong> following </div>
            </div>
            <div class="pt-4" ><strong>{{$user ->profile->title ?? 'fill in the blank'}} </strong></div>
            <div >{{$user ->profile->description ?? 'fill in the blank' }}</div>
        </div>
    </div>
    <div class="row pt-5">
        @foreach($user->posts as $post)
        <div class="col-4">
            <img src="/storage/{{$post->image }}" class="w- 100">
        </div>
    </div>
</div>
@endsection
