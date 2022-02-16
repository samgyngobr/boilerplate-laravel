
@extends('samgyngobr.scarlet.app')


@section('header')

  <i class="dec fas fa-edit"></i>

  <span>{{ $area->label ?? '' }}</span>

  <a href="{{ $skUrl . $area->url . '/new' }}" class="pull-left d-flex align-items-center text-white ">
    <i class="fas fa-plus-circle"></i>
  </a>

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
    <div class="card-body has-table">
      <div class="table-responsive">

        <?= listGen( $config['data'], $config['fieldLabels'], $config['area'], $skUrl ); ?>

      </div>
    </div>
  </div>

@endsection
