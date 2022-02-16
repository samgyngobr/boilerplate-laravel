
@extends('samgyngobr.scarlet.app')


@section('header')

  <i class="dec fas fa-cog"></i>

  <div class="d-flex gap-3">

    <a href="{{$skUrl . $url }}" class="pull-left d-flex align-items-center text-white mr-4">
      <i class="fas fa-chevron-left"></i>
    </a>

    <span>{{ __('scarlet.gallery') }} - {{$area->label ?? ''}}</span>

  </div>

@endsection


@section('content')

  @if (session('success'))
    <div class="alert alert-success">
      {{ session('success') }}
    </div>
  @endif

  @if (session('error'))
    <div class="alert alert-danger">
      {{ session('error') }}
    </div>
  @endif

  <div class="card elevation mb-4">

    <div class="card-header"> {{ __('scarlet.image') }} </div>

    <div class="card-body">
      <form action="" method="POST" enctype="multipart/form-data" >

        <div class="row">

          <div class="col-md-4">
            <input type="file" class="form-control" name="img" id="img" required >
          </div>

          <div class="col-md-4">
            <button type="submit" class="btn btn-success"> <i class="icon-ok"></i> {{ __('scarlet.send') }} </button>
          </div>

        </div>

      </form>
    </div>

  </div>

  <div class="row">

    @foreach ( $gallery as $img )

      <div class="col-md-2 mb-4" >
        <div class="card elevation">

          <img class="card-img-top" src="{{Config::get('app.sk_file_path_thumbs')}}{{$img->img}}" alt="{{ $img->legend ?? '' }}">

          <div class="card-body">
            <p class="card-text">

              {{$img->legend ?? ''}}

              <a class="pull-right text-danger" href="{{$skUrl . $url . '/gallery/' . $id . '/delete/' . $img->id}}">
                <i class="fas fa-trash"></i>
              </a>

              <?php /*
              <a class="pull-right text-info mr-2" href="#">
                <i class="fas fa-edit"></i>
              </a>
              */ ?>

            </p>
          </div>

        </div>
      </div>

    @endforeach

  </div>

@endsection
