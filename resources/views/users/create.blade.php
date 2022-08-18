@extends('admin.layouts.app', ['activePage' => 'user', 'titlePage' => __('Add New Admin User')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" id="userFrm" action="{{ route('user.store') }}" autocomplete="off" class="form-horizontal">
            @csrf          

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Add New Customer') }}</h4>
              </div>
              <div class="card-body ">
                @if (session('status'))
                  <div class="row">
                    <div class="col-sm-12">
                      <div class="alert alert-success">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <i class="material-icons">close</i>
                        </button>
                        <span>{{ session('status') }}</span>
                      </div>
                    </div>
                  </div>
                @endif
                <div class="row col-md-12">                        
                  <label class="col-sm-2 col-form-label">{{ __('Customer Name') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" placeholder="{{ __('Name') }}" value="{{ old('name') }}" required />
                      @if ($errors->has('name'))
                        <span id="name-error" class="error text-danger" for="input-name">{{ $errors->first('name') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="input-email" type="email" placeholder="{{ __('Email') }}" value="{{ old('email') }}" required />
                      @if ($errors->has('email'))
                        <span id="email-error" class="error text-danger" for="input-email">{{ $errors->first('email') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label" for="input-password">{{ __('Password') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="input-password" type="password" placeholder="{{ __('Password') }}" value="" required />
                      @if ($errors->has('password'))
                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('password') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Mobile') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('mobile') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" id="input-mobile" type="text" placeholder="{{ __('Mobile') }}" pattern="^\d{10}$" minlength=10  maxlength="10" value="{{ old('mobile') }}" required />
                      @if ($errors->has('mobile'))
                        <span id="email-error" class="error text-danger" for="input-mobile">{{ $errors->first('mobile') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row col-md-12">
                        <div class="col form-group">  
                        <label for="address1">Address 1<span class="text-danger">*</span></label>                      
                            <input type="text" name="address1" class="form-control" id="address1" placeholder="">
                        </div>
                        <div class="col form-group">   
                        <label for="address2">Address 2</label>                     
                            <input type="text" name="address2" class="form-control" id="address2" placeholder="">
                        </div>
                    </div>
                    <div class="row col-md-12">
                        <div class="form-group col">
                        <label for="country-dd">Country<span class="text-danger">*</span></label>
                            <select  name="country" id="country-dd" class="form-control">
                            <option value="0">Select Country</option>
                            @foreach ($countries as $data)
                            <option value="{{$data->id}}" @selected(old('country') == $data->id)>
                                {{$data->name}}
                            </option>
                            @endforeach
                        </select>
                        </div>
                        <div class="form-group col">
                        <label for="state-dd">State<span class="text-danger">*</span></label>
                            <select name="state" id="state-dd" class="form-control">
                            </select>
                        </div>
                        <div class="form-group col">
                        <label for="city-dd">City<span class="text-danger">*</span></label>
                        <select name="city" id="city-dd" class="form-control">
                        </select>
                        </div>
                        <div class="form-group col-md-2 ml-auto">
                        <label for="zip">Zip<span class="text-danger">*</span></label>
                        <input type="text" name="zip" id="zip" class="form-control" id="inputZip">
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
        $(document).ready(function () {  

            $('#country-dd').on('change', function () {
                var idCountry = this.value;
                $("#state-dd").html('');
                $.ajax({
                    url: "{{url('api/fetch-states')}}",
                    type: "POST",
                    data: {
                        country_id: idCountry,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (result) {
                        $('#state-dd').html('<option value="0">Select State</option>');
                        $.each(result.states, function (key, value) {
                            $("#state-dd").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                        $('#city-dd').html('<option value="">Select City</option>');
                    }
                });
            });
            $('#state-dd').on('change', function () {
                var idState = this.value;
                $("#city-dd").html('');
                $.ajax({
                    url: "{{url('api/fetch-cities')}}",
                    type: "POST",
                    data: {
                        state_id: idState,
                        _token: '{{csrf_token()}}'
                    },
                    dataType: 'json',
                    success: function (res) {
                        $('#city-dd').html('<option value="0">Select City</option>');
                        $.each(res.cities, function (key, value) {
                            $("#city-dd").append('<option value="' + value
                                .id + '">' + value.name + '</option>');
                        });
                    }
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $("#userFrm").validate({
                rules: {
                    fname: {
                        required: true,
                        maxlength: 20,
                    },
                    lname: {
                        required: true,
                        maxlength: 20,
                    },
                    password: {
                        required: true,
                        minlength: 8,
                    },
                    email: {
                        required: true,
                        email: true,
                        maxlength: 100
                    },
                    mobile: {
                        required: true,
                        minlength: 10,
                        maxlength: 10,
                        number: true
                    },
                    address1: {                       
                        maxlength: 50
                    },                   
                },
                messages: {
                  fname: {
                        required: "First name is required",
                        maxlength: "First name cannot be more than 20 characters"
                    },
                    lname: {
                        required: "Last name is required",
                        maxlength: "Last name cannot be more than 20 characters"
                    },
                    password: {
                        required: "Password is required",
                        maxlength: "Password cannot be less than 8 characters"
                    },
                    email: {
                        required: "Email is required",
                        email: "Email must be a valid email address",
                        maxlength: "Email cannot be more than 50 characters",
                    },
                    mobile: {
                        required: "Mobile number is required",
                        minlength: "Mobile number must be of 10 digits"
                    },                 
                    address1: {                        
                        maxlength: "Address cannot not be more than 50 characters"
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