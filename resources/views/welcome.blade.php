<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>JAE-Shortener</title>
  </head>
  <body>
    <div class="px-4 py-5 my-5 text-center">
      <h1 class="display-5 fw-bold">JAE-Shortener</h1>
      <div class="col-lg-6 mx-auto">
        <p class="lead mb-4">A tiny/clean/limit version of Short URL application, is also a successor to JAE-ShortURL.</p>
        <div class="d-grid gap-2 d-sm-flex justify-content-sm-center">
          <a href="{{ route('login') }}" role="button" class="btn btn-primary btn-lg px-4 gap-3">Login</a>
          <a href="{{ route('register') }}" role="button" class="btn btn-outline-secondary btn-lg px-4">Register</a>
        </div>
      </div>
    </div>

    <div class="alert alert-info alert-dismissible mx-5 text-center fade show" role="alert">
      <strong>2022/03/21-23</strong> © Created by Udornpit Saengdee.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  </body>
</html>