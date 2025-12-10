@extends('layouts.app')
@section('title', 'Search Page')


@section('content')
  <div class="container d-flex flex-column gap-3">
     @if($users->isEmpty())
       <div style="width:100%; height:80vh;" class="d-flex align-items-center justify-content-center fs-1">No Users Found</div>
     @endif   
     @foreach($users as $user)
     @if(auth()->user()->id !== $user->id)
     <a href="/profile/details/{{$user->id}}" class="d-flex justify-content-between align-items-center p-3 border rounded text-decoration-none text-dark">
        <div class="d-flex align-items-center">
           @if($user->profile_photo) 
             <img src="{{ asset('storage/' . $user->profile_photo) }}" alt="logo" style="height: 50px; width: 50px" class="me-2 rounded-circle"/>
           @else
             <img src="{{ asset('asset/user.png') }}" alt="profile" style="height: 50px; width: 50px" class="me-2 rounded-circle">
           @endif    
          <div>
            <h5 class="mb-1">{{$user->name}}</h5>
            <small class="text-muted">{{'@'.$user->username}}</small>
          </div>  
        </div>
        @if(!collect($following)->contains('following_id', $user->id))
          <form action="{{ route('user_follow',$user->id) }}" method="POST" class="text-end">
            @csrf
            <button class="btn btn-primary btn-sm">Follow</button>
          </form>
        @else
          <p class="text-primary fw-bold">Following</p>
        @endif  
      </a>
      @endif
      @endforeach
  </div>
@endsection
