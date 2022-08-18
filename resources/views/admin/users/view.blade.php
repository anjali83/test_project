@extends('admin.layouts.app', ['activePage' => 'user', 'titlePage' => __('View CUstomer Details')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('View Customer Details') }}</h4>
              </div>
              <div class="card-body ">               
                <div class="row">                        
                  <label class="col-sm-2 col-form-label">{{ __('Customer Name') }}</label>
                  <div class="col-sm-7">
                    {{$user->name}}
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                  <div class="col-sm-7">
                    {{$user->email}}
                  </div>
                </div>               
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Mobile') }}</label>
                  <div class="col-sm-7">
                    {{$user->mobile}}
                  </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label">{{ __('Date Of Birth') }}</label>
                    <div class="col-sm-7">
                        {{Carbon\Carbon::parse($user->dob)->format('d-m-Y')}}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label">{{ __('Gender') }}</label>
                    <div class="col-sm-7">
                        {{$user->gender}}
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-2 col-form-label">{{ __('Address') }}</label>
                    <div class="col-sm-7">
                        {{$user->address}}
                    </div>
                </div>

                <div class="row">
                    <label class="col-sm-2 col-form-label">{{ __('Country') }}</label>
                    <div class="col-sm-7">
                        {{$user->country}}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label">{{ __('State') }}</label>
                    <div class="col-sm-7">
                        {{$user->state}}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label">{{ __('City') }}</label>
                    <div class="col-sm-7">
                        {{$user->city}}
                    </div>
                </div>
                
                <div class="row">     
                <label class="col-sm-2 col-form-label">Profile Picture: </label> 
                <div class="col-sm-7">
                @if($user->profile_photo)
                <a href="{{url('/admin/download/'.$user->id.'/profile')}}" title="Download"> Download Profile Picture</a>
                @else
                Not Uploaded
                @endif
                </div>
                </div>
                <div class="row">     
                <label class="col-sm-2 col-form-label">Document: </label> 
                <div class="col-sm-7">
                @if($user->document)
                <a href="{{url('/admin/download/'.$user->id.'/document')}}" title="Download"> Download Document</a>
                @else
                Not Uploaded
                @endif
                </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label">{{ __('Registered By') }}</label>
                    <div class="col-sm-7">
                        {{$user->registered_by}}
                    </div>
                </div>
                <div class="row">
                    <label class="col-sm-2 col-form-label">{{ __('Is Active?') }}</label>
                    <div class="col-sm-7">
                        {{$user->status}}
                    </div>
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