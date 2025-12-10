@extends('layouts.app')
@section('title', 'Comment Page')

@section('content')

<style>
/* ================================
   RESPONSIVE COMMENT PAGE STYLES
   ================================ */

/* Desktop */
.resp-box {
    width: 60%;
}

/* Tablets (992px and below) */
@media (max-width: 992px) {
    .resp-box {
        width: 75%;
    }
}

/* Large Mobile (768px and below) */
@media (max-width: 768px) {
    .resp-box {
        width: 90%;
    }

    .reply-row form input {
        width: 70% !important;
    }
}

/* Small Mobile (576px and below) */
@media (max-width: 576px) {
    .resp-box {
        width: 100%;
    }

    .reply-row img {
        height: 40px !important;
        width: 40px !important;
    }

    .reply-row form button {
        font-size: 14px;
        padding: 4px 10px;
    }

    .reply-row form input {
        width: 65% !important;
    }
}
</style>


<div class="container d-flex flex-column gap-3 align-items-center">

    <!-- Main Comment -->
    <div class="card shadow-sm p-4 mt-2 resp-box">
        <div class="text-start">

            <div class="d-flex">
                <img src="{{asset('storage/' . $comment[0]->user->profile_photo)}}" 
                     style="height:30px; width:30px" class="me-2 rounded-circle">

                <div>
                    <h3 class="mb-0" style="font-size:15px">{{$comment[0]->user->name}}</h3>
                    <p class="text-muted" style="font-size:12px">{{$comment[0]->user->username}}</p>
                </div>
            </div>

            <p class="mt-2">{{$comment[0]->comment}}</p>

            <div class="d-flex">
                <div class="d-flex gap-2 px-2 align-items-center">
                    <a href="/comment/like/{{$comment[0]->id}}/{{$comment[0]->image_id}}">
                        @if($comment[0]->like_count === 0 || !in_array(auth()->user()->id, $comment[0]->liked_user_ids))
                            <img src="{{asset('asset/heart.png')}}" style="width:20px; height:20px"/>
                        @else
                            <img src="{{asset('asset/heart2.png')}}" style="width:20px; height:20px"/>
                        @endif
                    </a>

                    <div class="fw-bold" style="font-size:15px">
                        {{ $comment[0]->like_count > 1 ? $comment[0]->like_count.' likes' :
                            ($comment[0]->like_count === 1 ? '1 like' : 'like') }}
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Reply Input -->
    <div class="d-flex justify-content-between mt-4 mb-3 resp-box reply-row">

        @if (auth()->user()->profile_photo)
            <img src="{{ asset('storage/' . auth()->user()->profile_photo) }}" 
                 style="height:50px; width:50px" class="rounded-circle me-2">
        @else
            <img src="{{ asset('asset/user.png') }}" 
                 style="height:50px; width:50px" class="rounded-circle me-2">
        @endif

        <form action="{{ route('user.comment',['imageID' => $id, 'commentID' => $comment[0]->id]) }}" 
              method="POST"
              class="d-flex gap-2"
              style="width:90%">
            @csrf
            <input name="comment" autocomplete="off" type="text" required
                   placeholder="reply" class="form-control" style="width:80%">
            <button class="btn btn-primary">reply</button>
        </form>
    </div>


    <!-- Child Comments List -->
    @foreach($childComments as $child)
    <div class="card shadow-sm p-4 mt-2 resp-box">
        <div class="text-start">

            <div class="d-flex">
                <img src="{{asset('storage/' . $child->user->profile_photo)}}" 
                     style="height:30px; width:30px" class="rounded-circle me-2">

                <div>
                    <h3 class="mb-0" style="font-size:15px">{{$child->user->name}}</h3>
                    <p class="text-muted" style="font-size:12px">{{$child->user->username}}</p>
                </div>
            </div>

            <p class="mt-2">{{$child->comment}}</p>

            <div class="d-flex">
                <div class="d-flex gap-2 px-2 align-items-center">
                    <a href="/comment/like/{{$child->id}}/{{$child->image_id}}">
                        @if($child->like_count === 0 || !in_array(auth()->user()->id, $child->liked_user_ids))
                            <img src="{{asset('asset/heart.png')}}" style="width:20px; height:20px"/>
                        @else
                            <img src="{{asset('asset/heart2.png')}}" style="width:20px; height:20px"/>
                        @endif
                    </a>

                    <div class="fw-bold" style="font-size:15px">
                        {{ $child->like_count > 1 ? $child->like_count.' likes' :
                           ($child->like_count === 1 ? '1 like' : 'like') }}
                    </div>
                </div>
            </div>

        </div>
    </div>
    @endforeach

</div>

@endsection

