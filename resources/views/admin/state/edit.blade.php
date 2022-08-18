@extends('admin.layouts.app', ['activePage' => 'state', 'titlePage' => __('Edit State')])

@section('content')
  <div class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
          <form method="post" id="stateFrm" action="{{ route('admin.state.update',$details->id) }}" autocomplete="off" class="form-horizontal">
            @csrf   
            @method('put')       

            <div class="card ">
              <div class="card-header card-header-primary">
                <h4 class="card-title">{{ __('Edit State') }}</h4>                
              </div>
              <div class="card-body ">   
                <div class="row col-md-12">
                  <label class="col-sm-2 col-form-label" for="country">{{ __('Select Country') }}<span class="text-danger">*</span></label>
                  <div class="form-group col">
                      <select  name="country_id" id="country" class="form-control">
                      <option value="0">Select Country</option>
                      @foreach ($countries as $value)
                      <option value="{{$value->id}}" @selected(old('country',$details->country_id) == $value->id)>
                          {{$value->name}}
                      </option>
                      @endforeach
                  </select>
                  </div>                 
              </div>            
               
                <div class="row">
                  <label class="col-sm-2 col-form-label">{{ __('State Name') }}<span class="text-danger">*</span></label>
                  <div class="col-sm-7">
                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                      <input class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" id="input-name" type="text" value="{{ old('name',$details->name) }}" required />
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
            $("#stateFrm").validate({
                rules: {
                    name: {
                        required: true,
                    },
                    country_id: {
                        required: true,
                    },                   
                },
                messages: {
                  name: {
                        required: "State name is required",                        
                    }, 
                    country_id: {
                      required: "Select Country name is required",                        
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