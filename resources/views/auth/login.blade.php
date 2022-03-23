@extends('dashboard')
@section('content')
<main class="form-signin text-center">
  <form action="{{ route('login.handle') }}" method="POST">  
    @csrf  
    <h1 class="h3 mb-3 fw-normal">Login</h1>

    @if (Session::has('error'))
        <div class="text-danger mb-2">{{ Session::get('error') }}</div>
    @endif

    <div class="form-floating">
      <input type="text" class="form-control" name="login" placeholder="Email or Username" required autofocus>
      <label for="login">Email or Username</label>
    </div>
    <div class="form-floating">
      <input type="password" class="form-control" name="password" placeholder="Password" required>
      <label for="password">Password</label>
    </div>

    <div class="checkbox mb-3">
      <label>
        <input type="checkbox" name="remember" value="remember"> Remember me
      </label>
    </div>
    <button class="w-100 btn btn-lg btn-primary" type="submit">Login</button>
    <p class="mt-5 mb-3 text-muted">© 2022</p>
  </form>
</main>
@endsection