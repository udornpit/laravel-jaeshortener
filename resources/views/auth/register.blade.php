@extends('dashboard')
@section('content')
<main class="form-signup text-center">
  <form action="{{ route('register.handle') }}" method="POST">
    @csrf    
    <h1 class="h3 mb-3 fw-normal">Register</h1>

    <div class="form-floating">
      <input type="text" class="form-control" name="name" placeholder="Name" required autofocus>
      <label for="name">Name</label>
    </div>
    <div class="form-floating">
      <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
      <label for="username">Username</label>
    </div>
    <div class="form-floating">
      <input type="email" class="form-control" name="email" placeholder="name@example.com" required autofocus>
      <label for="email">Email</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" name="password" placeholder="Password" required>
      <label for="password">Password</label>
    </div>

    <button class="w-100 btn btn-lg btn-primary" type="submit">Register</button>
    <p class="mt-5 mb-3 text-muted">© 2022</p>
  </form>
</main>
@endsection