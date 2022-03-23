<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>JAE-Shortener</title>

    @guest
    <style>
        html,
        body {
          height: 100%;
        }

        body {
          display: flex;
          align-items: center;
          padding-top: 40px;
          padding-bottom: 40px;
          background-color: #f5f5f5;
        }

        .form-signin, .form-signup {
          width: 100%;
          max-width: 330px;
          padding: 15px;
          margin: auto;
        }

        .form-signin .checkbox, .form-signup .checkbox {
          font-weight: 400;
        }

        .form-signin .form-floating:focus-within,
        .form-signup .form-floating:focus-within {
          z-index: 2;
        }

        .form-signin input[type="text"],
        .form-signup input[type="text"],
        .form-signup input[type="email"] {
          margin-bottom: -1px;
          border-bottom-right-radius: 0;
          border-bottom-left-radius: 0;
        }

        .form-signin input[type="password"],
        .form-signup input[type="password"] {
          margin-bottom: 10px;
          border-top-left-radius: 0;
          border-top-right-radius: 0;
        }

    </style>
    @endguest
  </head>
  <body>
    <nav class="navbar 
        @guest fixed-top @endguest
        @auth sticky-top @endauth
        navbar-light navbar-expand-lg mb-5"
        style="background-color: 
        @guest #e3f2fd; @endguest
        @auth #e3f2fdb3; @endauth
        ">
        <div class="container">
            <a class="navbar-brand mr-auto" href="/">JAE-Shortener</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @guest
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    </li>
                    @else
                    <li class="nav-item mt-2 text-primary">
                        {{ Auth::user()->name }}
                        
                    </li>
                    <li class="nav-item mt-2 ms-2">
                        @if (session('success'))
                            <div class="text-success">{{ session('success') }}</div>
                        @endif
                    </li>
                    <li class="nav-item mt-2 ms-2 text-muted">
                        |
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}">Logout</a>
                    </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    @yield('content')

    @auth   
    <div class="mx-auto text-center" style="width: 75%;">
        @if ($users->user_type === 0)
        <h3 class="mb-3">Shortener</h3>
        <form action="{{ route('shorten') }}" method="POST">
            @csrf
            <div class="input-group input-group-lg mb-3">
              <input type="text" name="dest" class="form-control" placeholder="URL to shorten" aria-describedby="shorten">
              <button class="btn btn-outline-secondary" type="submit" id="shorten">Shorten</button>
            </div>
        </form>                  
        @endif

        @if (Session::has('dbmsg'))
        <div class="alert alert-info" role="alert">
          {{ Session::get('dbmsg') }}
        </div>
        @endif 

        @if ($users->user_type === 1)
        <h3 class="mb-3">URL Management</h3>
          @if (Session::has('url'))
          <div class="alert alert-success" role="alert">
            {{ Session::get('url') }}
          </div>
          @endif 
          @if (Session::has('fail'))
          <div class="alert alert-danger" role="alert">
            {{ Session::get('fail') }}
          </div>
          @endif
        @endif
        <hr class="my-5">

        @if ($users->user_type === 1)
        <form class="row g-3 justify-content-center" action="{{ route('shorten.deletebyuser') }}" method="POST">
          @csrf
          <div class="col-auto">
            <button type="submit" class="btn btn-warning mb-3">Delete URLs by</button>
          </div>
          <div class="col-auto">
            <input type="text" class="form-control text-center" name="user" placeholder="User's fullname">
          </div>              
        </form>
        <div class="row mb-2">
          <a href="{{ route('shorten.clear') }}" class="btn btn-danger" role="button">Delete All URLs</a>
        </div>
        @endif


        <table class="table table-striped table-hover">
            @if ($users->user_type === 0)
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">Key</th>
                <th scope="col">Destination URL</th>
                <th scope="col">Shortened URL</th>
                <th scope="col">Visits</th>
              </tr>
            </thead>
            <tbody>
              @php
                $c1 = 1;

                // In the real world, this thing should be placed in controller
                $userUrls = $shortUrls->where('user_id', $users->id)->orderBy('id', 'desc')->take(50)->get();
              @endphp
              @foreach ($userUrls as $shortUrl)
              <tr>
                <th scope="row">{{ $c1 }}</th>
                <td>{{ $shortUrl->key }}</td>
                <td>{{ $shortUrl->dest }}</td>
                <td><a href="{{ $shortUrl->short }}">{{ $shortUrl->short }}</a></td>
                {{-- different port use below line
                <td><a href="{{ str_replace(env('APP_URL'), env('APP_URL') . ':8000', $shortUrl->short) }}">{{ $shortUrl->short }}</a></td> --}}
                <td>{{ $shortUrl->visit }}</td>
              </tr>
              @php
                $c1++;
              @endphp
              @endforeach              
            </tbody>
            @endif

            @if ($users->user_type === 1)            
            <thead>
              <tr>
                <th scope="col">#</th>
                <th scope="col">User</th>
                <th scope="col">Key</th>
                <th scope="col">Destination URL</th>
                <th scope="col">Shortened URL</th>
                <th scope="col">Visits</th>
                <th scope="col">Action</th>
              </tr>
            </thead>
            <tbody>
              @php
                $c2 = 1;

                // In the real world, this thing should be placed in controller
                $allShortUrls = $shortUrls->orderBy('id', 'desc')->take(200)->get();
              @endphp
              @foreach ($allShortUrls as $shortUrl)
              <tr>
                <th scope="row">{{ $c2 }}</th>
                <td>{{ $shortUrl->user->name }}</td>
                <td>{{ $shortUrl->key }}</td>
                <td>{{ $shortUrl->dest }}</td>
                <td><a href="{{ $shortUrl->short }}">{{ $shortUrl->short }}</a></td>
                {{-- for different port
                <td><a href="{{ str_replace(env('APP_URL'), env('APP_URL') . ':8000', $shortUrl->short) }}">{{ $shortUrl->short }}</a></td> --}}
                <td>{{ $shortUrl->visit }}</td>
                <td>
                  <a href="{{ route('shorten.delete', ['id' => $shortUrl->id]) }}" class="btn btn-outline-danger" role="button">Delete</a>
                </td>
              </tr>
              @php
                $c2++;
              @endphp
              @endforeach 
            </tbody>
            @endif
          </table>
    </div>
    @endauth

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  </body>
</html>