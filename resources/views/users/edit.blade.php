@extends('admin.layouts.app', ['activePage' => 'user', 'titlePage' => __('Edit Admin User')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" id="userFrm" action="{{ route('admin.user.update',$details->id) }}" autocomplete="off" class="form-horizontal">
            @csrf
            @method('put')
            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Edit Admin User') }}</h4>
                <p class="card-category">{{ __('User information') }}</p>
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
                    <div class="col-xl-6 form-group">
                    <label for="fname">First name<span class="text-danger">*</span></label>
                    <input type="text" name="fname" id="fname" value="{{ old('fname',$details->fname) }}" class="form-control" placeholder="">
                    </div>
                    <div class="col-xl-6 form-group">
                    <label for="lname">Last name<span class="text-danger">*</span></label>
                    <input type="text" name="lname" id="lname" value="{{ old('lname',$details->lname) }}" class="form-control" placeholder="">
                    </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Email') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" id="input-email" type="email" placeholder="" value="{{ old('email',$details->email) }}" required />
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
                      <input class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" id="input-password" type="password" placeholder="{{ __('Password') }}" value=""  />
                      @if ($errors->has('password'))
                        <span id="password-error" class="error text-danger" for="input-password">{{ $errors->first('password') }}</span>
                      @endif
                      <span><em>Input Password If you want to change only.</em></span>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('Mobile') }}</label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('mobile') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('mobile') ? ' is-invalid' : '' }}" name="mobile" id="input-mobile" type="text" placeholder="" pattern="^\d{10}$" minlength=10  maxlength="10" value="{{ old('mobile',$details->mobile) }}" required />
                      @if ($errors->has('mobile'))
                        <span id="email-error" class="error text-danger" for="input-mobile">{{ $errors->first('mobile') }}</span>
                      @endif
                    </div>
                  </div>
                </div>
                <div class="row col-md-12">
                        <div class="col form-group">  
                        <label for="address1">Address 1<span class="text-danger">*</span></label>                      
                            <input type="text" name="address1" value="{{ old('address1',$details->address1) }}" class="form-control" id="address1" placeholder="">
                        </div>
                        <div class="col form-group">   
                        <label for="address2">Address 2</label>                     
                            <input type="text" name="address2" value="{{ old('address2',$details->address2) }}" class="form-control" id="address2" placeholder="">
                        </div>
                    </div>
                    <div class="row col-md-12">
                        <div class="form-group col">
                        <label for="country-dd">Country<span class="text-danger">*</span></label>
                            <select  name="country" id="country-dd" class="form-control">
                            <option value="0">Select Country</option>
                            @foreach ($countries as $data)
                            <option value="{{$data->id}}" @selected(old('country',$details->country) == $data->id)>
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
                        <input type="text" name="zip" id="zip" value="{{ old('zip',$details->zip) }}" class="form-control" id="inputZip">
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
                        var state = "{{ $details->state}}";

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
                        $('#city-dd').html('<option value="">Select City</option>');
                    }
                });
            }).change();

            $('#state-dd').on('change', function () {
                if(this.value){
                    var idState = this.value;
                }else{
                    var idState = "{{ $details->state}}";
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
                        var city = "{{ $details->city}}";

                        $('#city-dd').html('<option value="0">Select City</option>');
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
                    address2: {                       
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