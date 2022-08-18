@extends('layouts.app', ['activePage' => 'country', 'titlePage' => __('Add New Country')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" id="countryFrm" action="{{ route('country.store') }}" autocomplete="off" class="form-horizontal">
            @csrf          

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Add New Country') }}</h4>                
              </div>
              <div class="card-body ">               
               
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Country Name') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" value="{{ old('name') }}" required />
                      @if ($errors->has('name'))
                        <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                      @endif
                    </div>
                  </div>
                </div>               
              </div>
              <div class="card-footer ml-auto mr-auto">
                <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
@push('js')
       <script>
        $(document).ready(function() {
            $("#countryFrm").validate({
                rules: {
                    name: {
                        required: true,
                    },                   
                },
                messages: {
                  name: {
                        required: "Country name is required",                        
                    },                    
                },
                highlight: function (element) {
                    $(element).parent().addClass('error')
                },
                unhighlight: function (element) {
                    $(element).parent().removeClass('error')
                }
            });
        });
    </script>
    @endpush