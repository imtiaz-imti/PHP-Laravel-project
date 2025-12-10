@extends('layouts.app')
@section('title', 'Sign-In Page')

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
          <h3 class="text-center mb-4">Sign in</h3>

          <form action="{{ route('login') }}" method="POST">
            @csrf
            <!-- Username -->
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input autocomplete="off" name="email" type="text" class="form-control" placeholder="email@gmail.com" required>
            </div>
            @error('email') <small style="color : red">{{ $message }}</small> @enderror

            <!-- Password -->
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input autocomplete="off" name="password" type="password" class="form-control" placeholder="password" required>
            </div>
            @error('password') <small style="color : red">{{ $message }}</small> @enderror

            <p>Don't have account <a href="/sign-up"> Sign Up</a></p>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-primary w-100">Sign In</button>
          </form>

        </div>
      </div>
    </div>
  </div>
 </div> 
</div>
@endsection
