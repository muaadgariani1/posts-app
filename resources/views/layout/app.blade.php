<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>posts app</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
  </head>
  <body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
      <a class="navbar-brand" href="{{ url('/') }}">POST-APP</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav me-auto">
              <li class="nav-item">
                  <a class="nav-link" href="{{ url('/') }}">Home</a>
              </li>
              @auth
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('dashboard') }}">Dashboard</a>
                  </li>
              @endauth
          </ul>

          <ul class="navbar-nav ms-auto">
              @guest
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('login') }}">Login</a>
                  </li>
                  <li class="nav-item">
                      <a class="nav-link" href="{{ route('register') }}">Register</a>
                  </li>
              @else
                  @can('view-admin-panel')
                      <li class="nav-item">
                          <a class="nav-link text-warning" href="{{ route('admin.dashboard') }}">Admin Panel</a>
                      </li>
                  @endcan

                  <li class="nav-item dropdown">
                      <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          {{ Auth::user()->name }}
                      </a>
                      <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                          <form method="POST" action="{{ route('logout') }}">
                              @csrf
                              <a class="dropdown-item" href="{{ route('logout') }}"
                                 onclick="event.preventDefault(); this.closest('form').submit();">
                                  Logout
                              </a>
                          </form>
                      </div>
                  </li>
              @endguest
          </ul>
      </div>
  </nav>
    <div class="container">
 <div class="row">
 @yield('content')
    </div>
</div>



 
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>