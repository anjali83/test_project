@extends('layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">           
      <p>Welcome {{Auth::user()->name}} : Customer Dashboard : </p>
      </div>     
      
    </div>
  </div>
@endsection