@extends('admin.layouts.app', ['activePage' => 'dashboard', 'titlePage' => __('Dashboard')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6">
          <div class="card card-stats">
            <div class="card-header card-header-warning card-header-icon">
              <div class="card-icon">
                <i class="material-icons">people</i>
              </div>
              <p class="card-category">Customers</p>
              <h3 class="card-title">{{$total_customers}}</h3>
            </div>
            <div class="card-footer">
              <div class="stats">               
                <a href="{{url('/admin/user')}}">View...</a>
              </div>
            </div>
          </div>
        </div>       
       
      </div>     
      
    </div>
  </div>
@endsection

@push('js')
  <script>
    $(document).ready(function() {
      // Javascript method's body can be found in assets/js/demos.js
      md.initDashboardPageCharts();
    });
  </script>
@endpush