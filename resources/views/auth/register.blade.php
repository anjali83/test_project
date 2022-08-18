@extends('layouts.app', ['class' => 'off-canvas-sidebar', 'activePage' => 'register', 'title' => __('Customer Registration')])

@section('content')
<div class="container" style="height: auto;">
  <div class="row align-items-center">
    <div class="col-lg-4 col-md-6 col-sm-8 ml-auto mr-auto">
      <form class="form" method="POST" action="{{ route('register_action') }}" id="regForm" enctype="multipart/form-data">
        @csrf

        <div class="card card-login card-hidden mb-3">
          <div class="card-header card-header-primary text-center">
            <h4 class="card-title"><strong>{{ __('Register') }}</strong></h4>
            <div class="social-line">
              <a href="{{ url('login/facebook') }}" class="btn btn-just-icon btn-link btn-white">
                <i class="fa fa-facebook-square"></i>
              </a>             
              <a href="{{ url('login/google') }}" class="btn btn-just-icon btn-link btn-white">
                <i class="fa fa-google-plus"></i>
              </a>
            </div>
          </div>
          <div class="card-body ">           
            <div class="bmd-form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                      <i class="material-icons">face</i>
                  </span>
                </div>
                <input type="text" name="name" class="form-control" placeholder="{{ __('Name...') }}" value="{{ old('name') }}" required>
              </div>
              @if ($errors->has('name'))
                <div id="name-error" class="error text-danger pl-3" for="name" style="display: block;">
                  <strong>{{ $errors->first('name') }}</strong>
                </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('email') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">email</i>
                  </span>
                </div>
                <input type="email" name="email" class="form-control" placeholder="{{ __('Email...') }}" value="{{ old('email') }}" required>
              </div>
              @if ($errors->has('email'))
                <div id="email-error" class="error text-danger pl-3" for="email" style="display: block;">
                  <strong>{{ $errors->first('email') }}</strong>
                </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('password') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">lock_outline</i>
                  </span>
                </div>
                <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password...') }}" required>
              </div>
              @if ($errors->has('password'))
                <div id="password-error" class="error text-danger pl-3" for="password" style="display: block;">
                  <strong>{{ $errors->first('password') }}</strong>
                </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('password_confirmation') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">lock_outline</i>
                  </span>
                </div>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="{{ __('Confirm Password...') }}" required>
              </div>
              @if ($errors->has('password_confirmation'))
                <div id="password_confirmation-error" class="error text-danger pl-3" for="password_confirmation" style="display: block;">
                  <strong>{{ $errors->first('password_confirmation') }}</strong>
                </div>
              @endif
            </div>

            <div class="bmd-form-group{{ $errors->has('mobile') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">phone</i>
                  </span>
                </div>
                <input type="text" name="mobile" class="form-control" pattern="^\d{10}$" minlength=10  maxlength="10" placeholder="{{ __('Mobile...') }}" value="{{ old('mobile') }}" required>
              </div>
              @if ($errors->has('mobile'))
                <div id="mobile-error" class="error text-danger pl-3" for="mobile" style="display: block;">
                  <strong>{{ $errors->first('mobile') }}</strong>
                </div>
              @endif
            </div>

            <div class="bmd-form-group mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">calendar_today</i>
                  </span>
                </div>
                <input type="text" name="dob" id="dob" value="" placeholder="DOB..." class="datetimepicker form-control">                           
              </div>             
            </div>
            <div class="bmd-form-group mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">people</i>
                  </span>
                </div>
                <input type="radio" name="gender" value="Male" @checked(old('gender','Male')) class="form-control"> Male &nbsp;&nbsp;
                <input type="radio" name="gender" value="Female" @checked(old('gender','Female')) class="form-control"> Female                               
              </div>             
            </div>

            <div class="bmd-form-group{{ $errors->has('address') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">place</i>
                  </span>
                </div>
                <input type="text" name="address" class="form-control" placeholder="{{ __('Address...') }}" value="{{ old('address') }}" required>
              </div>
              @if ($errors->has('address'))
                <div id="address-error" class="error text-danger pl-3" for="address" style="display: block;">
                  <strong>{{ $errors->first('address') }}</strong>
                </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('country') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">place</i>
                  </span>
                </div>
                <select  name="country" id="country-dd" class="form-control">
                  <option value="0">Select Country</option>
                  @foreach ($countries as $data)
                  <option value="{{$data->id}}" @selected(old('country') == $data->id)>
                      {{$data->name}}
                  </option>
                  @endforeach
              </select>
              </div>
              @if ($errors->has('country'))
                <div id="country-error" class="error text-danger pl-3" for="country-dd" style="display: block;">
                  <strong>{{ $errors->first('country') }}</strong>
                </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('country') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">place</i>
                  </span>
                </div>
                <select name="state" id="state-dd" class="form-control">
                  <option value="0">Select State</option>
                </select>
              </div>
              @if ($errors->has('state'))
                <div id="state-error" class="error text-danger pl-3" for="state-dd" style="display: block;">
                  <strong>{{ $errors->first('state') }}</strong>
                </div>
              @endif
            </div>
            <div class="bmd-form-group{{ $errors->has('city') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    <i class="material-icons">place</i>
                  </span>
                </div>
                <select name="city" id="city-dd" class="form-control">
                </select>
              </div>
              @if ($errors->has('city'))
                <div id="city-error" class="error text-danger pl-3" for="city-dd" style="display: block;">
                  <strong>{{ $errors->first('city') }}</strong>
                </div>
              @endif
            </div>

            <div class="bmd-form-group{{ $errors->has('profile_photo') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    Upload Profile
                  </span>
                </div>
                <input type="file" name="profile_photo" accept=".jpg,.png" required>
              </div>
              @if ($errors->has('profile_photo'))
                <div id="profile_photo-error" class="error text-danger pl-3" for="profile_photo" style="display: block;">
                  <strong>{{ $errors->first('profile_photo') }}</strong>
                </div>
              @endif
            </div>

            <div class="bmd-form-group{{ $errors->has('document') ? ' has-danger' : '' }} mt-3">
              <div class="input-group">
                <div class="input-group-prepend">
                  <span class="input-group-text">
                    Upload Document
                  </span>
                </div>
                <input type="file" name="document" accept=".jpg,.png,.xls,.pdf" required>
              </div>
              @if ($errors->has('document'))
                <div id="document-error" class="error text-danger pl-3" for="document" style="display: block;">
                  <strong>{{ $errors->first('document') }}</strong>
                </div>
              @endif
            </div>
           
          </div>
          <div class="card-footer justify-content-center">
            <button type="submit" class="btn btn-primary btn-link btn-lg">{{ __('Create account') }}</button>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>
@endsection
@push('js')
 
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
<script src="{{ asset('material') }}/js/plugins/bootstrap-datetimepicker.min.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {
      
        var dt = new Date();
        var pastYear = dt.getFullYear() - 18;
        dt.setFullYear(pastYear);
      
        $('.datetimepicker').datetimepicker({
            format: 'DD-MM-YYYY', 
            defaultDate: dt,
            viewMode: 'years',            
            minDate: dt,
         });

         $('#country-dd').change(function () {
              
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
                  var state = "{{ old('state')}}";

                  $('#state-dd').html('<option value="0">Select State</option>');
                  $.each(result.states, function (key, value) {
                      if(state == value.id){
                          $("#state-dd").append('<option value="' + value
                          .id + '" selected>' + value.name + '</option>');
                      }else{
                          $("#state-dd").append('<option value="' + value
                          .id + '">' + value.name + '</option>');
                      }
                      
                  });
                  $('#city-dd').html('<option value="0">Select City</option>');
              }
          });
      }).change();

      $('#state-dd').on('change', function () {
          if(this.value){
              var idState = this.value;
          }else{
              var idState = "{{ old('state')}}";
          }
          
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
                  var city = "{{ old('city')}}";

                  $('#city-dd').html('<option value="">Select City</option>');
                  $.each(res.cities, function (key, value) {
                      if(city == value.id){
                          $("#city-dd").append('<option value="' + value
                              .id + '" selected>' + value.name + '</option>');
                      }else{
                          $("#city-dd").append('<option value="' + value
                              .id + '">' + value.name + '</option>');
                      }
                  });
              }
          });
      }).change();
       
            $("#regForm").validate({
                rules: {
                    name: {
                        required: true,
                        maxlength: 20,
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
                    address: {
                        required: true,
                        maxlength: 100
                    },
                    country_dd: "required",
                    state_dd: "required",
                    city_dd: "required",
                    profile_photo: "required",
                    document: "required",
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
                    email: {
                        required: "Email is required",
                        email: "Email must be a valid email address",
                        maxlength: "Email cannot be more than 50 characters",
                    },
                    mobile: {
                        required: "Phone number is required",
                        minlength: "Phone number must be of 10 digits"
                    },                 
                    address: {
                        required: "Address is required",
                        maxlength: "Address cannot not be more than 100 characters"
                    },
                    country_dd: "Password is required",
                    city_dd: "City is required",
                    state_dd: "State is required",                   
                    profile_photo: "Please Upload Your Profile Pic",
                    document: "Please Upload document",
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
