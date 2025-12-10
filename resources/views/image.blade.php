
@extends('layouts.app')
@section('title', 'Image Details Page')

@section('content')
<style>
/* -------------------------------
   RESPONSIVE CUSTOM STYLES
----------------------------------*/

/* Default (Desktop) */
.image-container,
.like-comment-row,
.comment-row,
.comment-card {
    width: 40%;
}

/* Tablets (max-width: 992px) */
@media (max-width: 992px) {
    .image-container,
    .like-comment-row,
    .comment-row,
    .comment-card {
        width: 60%;
    }
}

/* Large Mobiles (max-width: 768px) */
@media (max-width: 768px) {
    .image-container {
        width: 90%;
        height: 450px !important;
    }

    .like-comment-row,
    .comment-row,
    .comment-card {
        width: 90%;
    }
}

/* Small Mobile (max-width: 576px) */
@media (max-width: 576px) {

    .image-container {
        width: 100%;
        height: 350px !important;
    }

    .like-comment-row,
    .comment-row,
    .comment-card {
        width: 100%;
    }

    .comment-row form input {
        width: 70% !important;
    }

    .comment-row form button {
        font-size: 14px;
        padding: 5px 10px;
    }
}
</style>

<div class="container d-flex flex-column gap-3 align-items-center">

    <!-- Image Section -->
    <div class="image-container" style="height:700px;">
        <img src="{{asset('storage/' . $details[0]->image_path)}}" 
             alt="details" class="w-100 h-100 object-fit-cover"/>
    </div>

    <!-- Likes / Comments Summary -->
    <div class="like-comment-row d-flex justify-content-between">
        <div class="d-flex gap-2 px-2 align-items-center">
            @if(count($imageLikes) === 0 || !in_array(auth()->user()->id, $imageLikes[0]->liked_user_ids))
               <a href="{{ route('image.like', $id) }}">
                 <img src="{{asset('asset/heart.png')}}" style="width:30px; height:30px"/>
               </a>
            @else
               <a href="{{ route('image.like', $id) }}">
                 <img src="{{asset('asset/heart2.png')}}" style="width:30px; height:30px"/>
               </a>
            @endif

            <div class="fs-5 fw-bold">
                {{ count($imageLikes) > 0 && $imageLikes[0]->like_count > 1 
                    ? $imageLikes[0]->like_count.' likes' 
                    : (count($imageLikes) > 0 && $imageLikes[0]->like_count === 1 
                    ? '1 like' 
                    : 'like') }}
            </div>
        </div>

        <div class="d-flex gap-2 px-2 align-items-center">
            <img src="{{asset('asset/comment.png')}}" style="width:30px; height:30px"/>
            <div class="fs-5 fw-bold">
                {{ count($comments) > 1 ? count($comments).' comments' : 
                   (count($comments) === 1 ? '1 comment' : 'comment') }}
            </div>
        </div>
    </div>

    <!-- Comment Input -->
    <div class="comment-row d-flex justify-content-between align-items-center mt-3">
        @if (auth()->user()->profile_photo)
            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                 style="height:50px; width:50px" class="rounded-circle me-2">
        @else
            <img src="{{ asset('asset/user.png') }}" 
                 style="height:50px; width:50px" class="rounded-circle me-2">
        @endif

        <form action="{{ route('user.comment',['imageID' => $id,'commentID' => '0']) }}" 
              method="POST" style="width:90%" class="d-flex gap-2">
            @csrf
            <input name="comment" autocomplete="off" type="text" required 
                   placeholder="Comment" class="form-control" style="width:80%">
            <button class="btn btn-primary">Comment</button>
        </form>
    </div>

    <!-- Comment List -->
    @foreach($comments as $comment)
    <div class="comment-card card shadow-sm p-4 mt-2">

        <div class="d-flex">
            <img src="{{asset('storage/' . $comment->user->profile_photo)}}" 
                 style="height:30px; width:30px" class="rounded-circle me-2">
            <div>
                <h3 class="mb-0" style="font-size:15px">{{$comment->user->name}}</h3>
                <p class="text-muted" style="font-size:12px">{{$comment->user->username}}</p>
            </div>
        </div>

        <p class="mt-2">{{$comment->comment}}</p>

        <!-- Like + Replies -->
        <div class="d-flex justify-content-between mt-2">
            <div class="d-flex gap-2 align-items-center">
                <a href="/comment/like/{{$comment->id}}/{{$comment->image_id}}">
                    @if($comment->like_count === 0 || !in_array(auth()->user()->id, $comment->liked_user_ids))
                        <img src="{{asset('asset/heart.png')}}" style="width:20px; height:20px"/>
                    @else
                        <img src="{{asset('asset/heart2.png')}}" style="width:20px; height:20px"/>
                    @endif
                </a>
                <div class="fw-bold" style="font-size:15px">
                    {{ $comment->like_count > 1 
                       ? $comment->like_count.' likes'
                       : ($comment->like_count === 1 
                          ? '1 like' 
                          : 'like') }}
                </div>
            </div>

            <a href="/comment/details/{{$comment->id}}/{{$id}}" 
               class="d-flex gap-2 align-items-center text-decoration-none text-dark">
                <img src="{{asset('asset/comment.png')}}" style="width:20px; height:20px"/>
                <div class="fw-bold" style="font-size:15px">
                    {{ count($childComments->where('parent_id', $comment->id)) > 1 
                       ? count($childComments->where('parent_id', $comment->id)).' comments'
                       : (count($childComments->where('parent_id', $comment->id)) === 1 
                          ? '1 comment' 
                          : 'comment') }}
                </div>
            </a>
        </div>
    </div>
    @endforeach

</div>
@endsection

