<!DOCTYPE html>
<html>

  <head>

    <title>Sk</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6"                         crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css"    integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />

    <style type="text/css">

        body { font-size: .875rem; }

        .sidebar { position: fixed; top: 0; bottom: 0; left: 0; z-index: 100; padding: 48px 0 0; box-shadow: inset -1px 0 0 rgba(0, 0, 0, .1); }
        @media (max-width: 767.98px) { .sidebar { top: 5rem; } }
        .sidebar-sticky { position: relative; top: 0; height: calc(100vh - 48px); padding-top: .5rem; overflow-x: hidden; overflow-y: auto; }
        .sidebar .nav-link { font-weight: 500; color: #333; }
        .sidebar .nav-link .feather { margin-right: 4px; color: #727272; }
        .sidebar .nav-link.active { color: #007bff; }
        .sidebar .nav-link:hover .feather,
        .sidebar .nav-link.active .feather { color: inherit; }
        .sidebar-heading { font-size: .75rem; text-transform: uppercase; }

        .sidebar .nav-link:not(.collapsed) .fa-caret-right { display: none; }
        .sidebar .nav-link.collapsed       .fa-caret-down  { display: none; }

        .sidebar .nav .flex-column { flex-wrap: nowrap; }
        .sidebar .nav .nav .nav-link { padding: 8px 15px 8px 35px; }

        .navbar-brand { padding-top: .75rem; padding-bottom: .75rem; font-size: 1rem; background-color: rgba(0, 0, 0, .25); box-shadow: inset -1px 0 0 rgba(0, 0, 0, .25); }
        .navbar .navbar-toggler { top: .25rem; right: 1rem; }
        .navbar .form-control { padding: .75rem 1rem; border-width: 0; border-radius: 0; }

        .form-control-dark { color: #fff; background-color: rgba(255, 255, 255, .1); border-color: rgba(255, 255, 255, .1); }
        .form-control-dark:focus { border-color: transparent; box-shadow: 0 0 0 3px rgba(255, 255, 255, .25); }

        header { overflow: hidden; position: relative; }
        header a, header a:hover { text-decoration: none; }
        header .h1 { font-size: 2rem; }
        header .h1 * { z-index: 9; }
        header .h1 > i.dec { z-index: 1; position: absolute; font-size: 300px !important; opacity: .1; top: -100px; bottom: -100px; left: 20px; }
        header .h1 i { font-size: 24px; }

        .elevation { box-shadow: 0 2px 1px -1px rgba(0,0,0,.2),0 1px 1px 0 rgba(0,0,0,.14),0 1px 3px 0 rgba(0,0,0,.12); }
        .card.elevation { border: none; }
        .card.elevation .card-header { border-bottom: 0; box-shadow: 0 1px 1px 0 rgba(0,0,0,.14); }
        .card .card-header { font-weight: bold; }
        .card .card-body.has-table { padding: 0; }
        .card .card-body.has-table .table { margin-bottom: 0; }
        .card .card-body.has-table .table thead.card-header { border-bottom: 0; box-shadow: none !important; background: none; }
        .card .card-body.has-table .table thead.card-header th { border: 0; background-color: rgba(0,0,0,.03); }
        .card .card-body.has-table .table thead.card-header th:first-child { border-radius: .25em 0 0 0; padding-left: 1.25em; }
        .card .card-body.has-table .table thead.card-header th:last-child { border-radius: 0 .25em 0 0; padding-right: 1.25em; }
        .card .card-body.has-table .table td:first-child { padding-left: 1.25em; }
        .card .card-body.has-table .table td:last-child { padding-right: 1.25em; }

        .pull-right { float: right; }

    </style>

  </head>


  <body>

    <header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">

      <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3" href="#">Company name</a>

      <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-toggle="collapse" data-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
          <a class="nav-link" href="#">Sign out</a>
        </li>
      </ul>

    </header>

    <div class="container-fluid">
      <div class="row">

        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
          <div class="position-sticky pt-3">

            <ul class="nav flex-column">

              <li class="nav-item">
                <a class="nav-link" href="#">
                  <i class="fas fa-home"></i>
                  Dashboard
                </a>
              </li>

              <li class="nav-item {{ substr( Route::currentRouteName(), 0, 7 ) == 'config.' ? 'active' : '' }} ">
                <a class="nav-link" href="{{$skUrl}}config">
                  <i class="fas fa-cog"></i>
                  Configuration
                </a>
              </li>

              <li class="nav-item {{ Route::currentRouteName() == 'sk-admin' || Route::currentRouteName() == 'sk-admin-new' ? 'active' : '' }}">

                <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample" >
                  <i class="fas fa-edit"></i>
                  Content
                  <span class="pull-right">
                    <i class="fas fa-caret-down"></i>
                    <i class="fas fa-caret-right"></i>
                  </span>
                </a>

                <ul class="nav flex-column {{ Route::currentRouteName() == 'sk-admin' || Route::currentRouteName() == 'sk-admin-new' ? '' : 'collapse' }} " id="collapseExample" >

                  @foreach ( $listEnabledAreas as $list)

                  <li class="nav-item">
                    <a class="nav-link" href="{{$skUrl}}{{$list->url}}">
                      {{$list->label}}
                    </a>
                  </li>

                  @endforeach

                </ul>

              </li>

            </ul>

          </div>
        </nav>

        <main role="main" class="col-md-9 ms-sm-auto col-lg-10 px-md-0">

          <header class="p-4 mb-4 border-bottom bg-secondary text-light">
            <h1 class="h1 d-flex justify-content-between pt-3">
              @yield('header')
            </h1>
          </header>

          <div class="px-4">
            @yield('content')
          </div>

        </main>

      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://cdn.ckeditor.com/ckeditor5/29.0.0/classic/ckeditor.js"></script>
    <script>
      if( document.querySelector('.ckeditor') )
      {
        ClassicEditor
          .create( document.querySelector( '.ckeditor' ) )
          .then( editor => {
            //console.log( editor );
          } )
          .catch( error => {
            console.error( error );
          } );
      }
    </script>

  </body>
</html>
