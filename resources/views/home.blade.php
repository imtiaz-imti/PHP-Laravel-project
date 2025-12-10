@extends('layouts.app')
@section('title', 'Home Page')

@section('content')
<div class="container">

    <!-- Bootstrap Tabs -->
    <ul class="nav nav-tabs mb-3 flex-wrap" id="profileTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="images-tab" data-bs-toggle="tab" data-bs-target="#images" type="button" role="tab">
                Photos
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="followers-tab" data-bs-toggle="tab" data-bs-target="#followers" type="button" role="tab">
                {{'Followers '.'('.count($followers).')'}}
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="following-tab" data-bs-toggle="tab" data-bs-target="#following" type="button" role="tab">
                {{'Followings '.'('.count($followings).')'}}
            </button>
        </li>

        <li class="nav-item" role="presentation">
            <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab">
                Profile
            </button>
        </li>
    </ul>

    <!-- Tab Content -->
    <div class="tab-content" id="profileTabContent">

        <!-- Images Tab -->
        <div class="tab-pane fade show active" id="images" role="tabpanel">
            <div class="d-flex flex-wrap gap-2 p-3 justify-content-center">
                @if($images->isEmpty())
                    <div class="w-100 d-flex align-items-center justify-content-center" style="height: 200px;">
                        <p class="fs-3 text-center">Upload Photos</p>
                    </div>
                @else
                    @foreach($images as $image)
                        <a href="/image/details/{{$image->id}}" class="bg-primary text-white rounded shadow" style="width:120px; height:200px;">
                            <img src="{{ asset('storage/' . $image->image_path) }}" 
                                 alt="image" 
                                 class="w-100 h-100 object-fit-cover">
                        </a>
                    @endforeach
                @endif
            </div>
        </div>

        <!-- Followers Tab -->
        <div class="tab-pane fade" id="followers" role="tabpanel">
            <div class="d-flex flex-column gap-2 p-2">
                @if(!$followers->isEmpty())
                    @foreach($followers as $follower)
                        <a href="/profile/details/{{$follower->follower->id}}" class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center p-3 border rounded text-decoration-none">
                            <div class="d-flex align-items-center gap-2 mb-2 mb-md-0">
                                <img src="{{ $follower->follower->profile_photo ? asset('storage/' . $follower->follower->profile_photo) : asset('asset/user.png') }}" 
                                     alt="logo" class="rounded-circle" style="height:50px; width:50px;">
                                <div>
                                    <h5 class="mb-0 text-dark">{{$follower->follower->name}}</h5>
                                    <small class="text-muted">{{'@'.$follower->follower->username}}</small>
                                </div>
                            </div>
                            <form action="{{ route('user_unfollow_remove', $follower->id) }}" method="POST" class="text-end">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </a>
                    @endforeach
                @else
                    <div class="w-100 d-flex align-items-center justify-content-center" style="height: 200px;">
                        <p class="fs-3 text-center">No Followers</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Following Tab -->
        <div class="tab-pane fade" id="following" role="tabpanel">
            <div class="d-flex flex-column gap-2 p-2">
                @if(!$followings->isEmpty())
                    @foreach($followings as $following)
                        <a href="/profile/details/{{$following->following->id}}" class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center p-3 border rounded text-decoration-none">
                            <div class="d-flex align-items-center gap-2 mb-2 mb-md-0">
                                <img src="{{ $following->following->profile_photo ? asset('storage/' . $following->following->profile_photo) : asset('asset/user.png') }}" 
                                     alt="logo" class="rounded-circle" style="height:50px; width:50px;">
                                <div>
                                    <h5 class="mb-0 text-dark">{{$following->following->name}}</h5>
                                    <small class="text-muted">{{'@'.$following->following->username}}</small>
                                </div>
                            </div>
                            <form action="{{ route('user_unfollow_remove', $following->id) }}" method="POST" class="text-end">
                                @csrf
                                <button type="submit" class="btn btn-danger btn-sm">Unfollow</button>
                            </form>
                        </a>
                    @endforeach
                @else
                    <div class="w-100 d-flex align-items-center justify-content-center" style="height: 200px;">
                        <p class="fs-3 text-center">No Followings</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Profile Tab -->
        <div class="tab-pane fade" id="profile" role="tabpanel">
            <div class="container mt-4">

                <!-- Profile Header -->
                <form action="{{ route('save-details') }}" method="POST" enctype="multipart/form-data" class="nav-item me-2 mt-3">
                    @csrf
                    <div class="d-flex flex-column flex-md-row align-items-center p-3 bg-white shadow-sm rounded gap-3">

                        <!-- Profile Image (clickable) -->
                        <label for="profileInput">
                            <img src="{{ auth()->user()->profile_photo ? asset('storage/' . auth()->user()->profile_photo) : asset('asset/user.png') }}" 
                                 alt="profile" class="rounded-circle" style="height:50px; width:50px;">
                        </label>
                        <input name="profile_photo" type="file" id="profileInput" accept="image/*">
                        
                        <!-- Name + Username -->
                        <div class="d-flex flex-column">
                            <h4 class="mb-0">{{auth()->user()->name}}</h4>
                            <small class="text-muted">{{'@'.auth()->user()->username}}</small>
                        </div>
                    </div>

                    <!-- About Yourself -->
                    <div class="mt-4 p-3 bg-white shadow-sm rounded">
                        <h5>Bio</h5>
                        <textarea name="bio" class="form-control mt-2" rows="4" placeholder="Write something about yourself...">{{auth()->user()->bio}}</textarea>
                        @error('bio') <small style="color:red">{{ $message }}</small> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary mt-3">Save Details</button>
                </form>

                <!-- Upload Post Image -->
                <form action="{{ route('upload_image') }}" method="POST" enctype="multipart/form-data" class="mt-4 p-3 bg-white shadow-sm rounded">
                    @csrf
                    <h5>Upload an Image to the Site</h5>
                    <input name="upload_image" type="file" class="form-control mt-3" accept="image/*">
                    <div class="nav-item me-2 mt-3">
                        <button type="submit" class="btn btn-primary">Upload Image</button>
                    </div>
                    @error('upload_image') <small style="color:red">{{ $message }}</small> @enderror
                </form>  
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('button[data-bs-toggle="tab"]').forEach(function (tab) {
        tab.addEventListener('shown.bs.tab', function (e) {
            localStorage.setItem('activeTab', e.target.getAttribute('data-bs-target'));
        });
    });

    const activeTab = localStorage.getItem('activeTab');
    if (activeTab) {
        const tabTrigger = document.querySelector(`button[data-bs-target="${activeTab}"]`);
        if (tabTrigger) {
            new bootstrap.Tab(tabTrigger).show();
        }
    }
});
</script>

<style>
/* Responsive tweaks */
@media (max-width: 768px) {
    .tab-content > div {
        padding: 10px;
    }
    .tab-pane a {
        flex-direction: column;
        align-items: flex-start;
    }
    .tab-pane a img {
        margin-bottom: 5px;
    }
    .d-flex.flex-column.flex-md-row {
        flex-direction: column !important;
        align-items: flex-start !important;
    }
    form input.form-control {
        width: 100% !important;
    }
}
</style>

@endsection




