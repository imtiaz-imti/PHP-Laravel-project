@extends('layouts.app')
@section('title', 'Sign-Up Page')

@php
    $hideNavbar = true;
@endphp

@section('content')
<div style="max-width : 100vw; height : 80vh" class="d-flex justify-content-center align-items-center">
<div class="container mt-5">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow-sm">
        <div class="card-body">
          <h3 class="text-center mb-4">Sign up</h3>

          <form action="{{ route('register.store') }}" method="POST">
            @csrf
            <!-- Name -->
            <div class="mb-3">
              <label class="form-label">Name</label>
              <input autocomplete="off" name="name" type="text" class="form-control" placeholder="Enter your name" required>
            </div>
            @error('name') <small style="color : red">{{ $message }}</small> @enderror

            <!-- Username -->
            <div class="mb-3">
              <label class="form-label">Username</label>
              <input autocomplete="off" name="username" type="text" class="form-control" placeholder="Choose a username" required>
            </div>
            @error('username') <small style="color : red">{{ $message }}</small> @enderror

            <!-- Email -->
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input autocomplete="off" name="email" type="email" class="form-control" placeholder="Enter your email" required>
            </div>
            @error('email') <small style="color : red">{{ $message }}</small> @enderror
            <!-- Password -->
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input autocomplete="off" name="password" type="password" class="form-control" placeholder="Create a password" required>
            </div>
            @error('password') <small style="color : red">{{ $message }}</small> @enderror

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100">Sign Up</button>
          </form>

        </div>
      </div>
    </div>
  </div>
 </div> 
</div>
@endsection