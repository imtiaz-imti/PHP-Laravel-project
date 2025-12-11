@extends('layouts.app')
@section('title', 'Profile Page')

@section('content')

<style>
@media (min-width: 640px) {
    .my-640-box {
        width: 70%;  /* Adjusted width on medium screens */
    }
}

@media (max-width: 639px) {
    .my-640-box {
        width: 100%; /* Full width on small screens */
    }
}

.uploaded-image {
    width: 120px;
    height: 200px;
    overflow: hidden;
    border-radius: 5px;
}

.uploaded-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

@media (max-width: 768px) {
    .d-flex.flex-wrap.gap-3.p-3 {
        justify-content: center; /* Center images on small screens */
    }
    .card .d-flex {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    .card .d-flex img {
        height: 50px;
        width: 50px;
    }
    .my-640-box {
        width: 100% !important;
    }
}
</style>

<div class="container py-5">

    <!-- Profile Section -->
    <div class="card shadow-sm p-4 mb-5">
        <div class="text-start">
            <div class="d-flex align-items-center">
                <img src="{{ asset('storage/' . $details[0]->profile_photo) }}" 
                     alt="User Image" class="me-2 rounded-circle" style="height: 50px; width: 50px;">
                <div>
                    <h3 class="mb-0">{{ $details[0]->name }}</h3>
                    <p class="text-muted">{{ '@'.$details[0]->username }}</p>
                </div>
            </div>
            <p class="my-640-box mt-3">{{ $details[0]->bio }}</p>
        </div>
    </div>

    <!-- Uploaded Images Section -->
    <h4 class="mt-5 mb-3 text-center text-md-start">Uploaded Images</h4>
    <div class="d-flex flex-wrap gap-3 p-3 justify-content-start justify-content-md-start">
        @if($images->isEmpty())
            <div class="w-100 d-flex align-items-center justify-content-center" style="height: 200px;">
                <p class="fs-5 text-center">No photos have been uploaded</p>
            </div>
        @else
            @foreach($images as $image)
                <a href="/image/details/{{ $image->id }}" class="uploaded-image shadow">
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="image">
                </a>
            @endforeach
        @endif
    </div>

</div>

@endsection

