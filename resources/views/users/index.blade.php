@extends('layouts.app', ['activePage' => 'user', 'titlePage' => __('Customer Management')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">Customer Listing</h4>            
          </div>
          <div class="card-body">

           <a class="btn btn-primary" href="{{route('user.create')}}"><span class="glyphicon glyphicon-plus"></span> Add New Customer</a>

                 @if (session('message'))
                  
                    <div class="col-sm-12">
                      <div class="alert alert-success">                        
                        <span>{{ session('message') }}</span>
                      </div>
                    </div>
                  
                @endif
                @if(Session::has("success"))
                    <div class="alert alert-success">
                        {{Session::get("success")}}
                    </div>
                @elseif(Session::has("failed")) 
                    {{Session::get("failed")}}
                @endif
                <div class="alert alert-success" style="display:none"></div>
            
            <div class="table-responsive">
              <table class="table table-bordered table-striped data-table">
                <thead class=" text-primary">
                  <th>SR.NO</th>
                  <th>Name</th> 
                  <th>Email</th>
                  <th>Mobile</th>
                  <th>DOB</th>                 
                  <th>Gender</th>
                  <th>Address</th>
                  <th>Country</th>
                  <th>State</th>
                  <th>City</th> 
                  <th>Profile Image</th>
                  <th>Document</th>                
                  <th>Created Date</th>                  
                  <th>Action</th>
                </thead>
                <tbody>
                  @if(isset($users) && !empty($users))
                    @foreach($users as $key => $value)
                    <tr>
                    <td>{{($key+1)}}</td>
                    <td>{{$value->name}}</td>
                    <td>{{$value->email}}</td>
                    <td>{{$value->mobile}}</td>                    
                    <td>{{Carbon\Carbon::parse($value->dob)->format('d-m-Y')}}</td>
                    <td>{{$value->gender}}</td>
                    <td>{{$value->address}}</td>
                    <td>{{$value->country}}</td>
                    <td>{{$value->state}}</td>
                    <td>{{$value->city}}</td>
                    <td><a href="{{storage('/uploads/profile/'.$value->profile_photo)}}" title="Download"> View Profile Picture</a></td>
                    <td><a href="{{url('/download/'.$value->id)}}" title="Download"> Download Document</a></td>
                    <td>{{Carbon\Carbon::parse($value->created_at)->format('d-m-Y')}}</td>
                    
                    <td>
                    <a href="{{ route('user.show',$value->id) }}" class="link" />Edit <i class="fa fa-preview"></i></a>                   
                    
                    <form action="{{ route('user.destroy',$value->id) }}" method="POST">   
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                  </form>

                  
                    </td>
                    </tr>
                    @endforeach
                  @endif
                </tbody>
              </table>
            </div>
            {{ $users->links() }}
          </div>
        </div>
      </div>      
  </div>
</div>
     
@endsection
@push('js')
<script type="text/javascript"> 
  $(document).ready(function() {

    $(document).on('change', '#status', function(e){
        var id = $('option:selected', this).attr('data-id');
        var status = $('option:selected', this).val();
        $.ajax({
            type: "POST",
            url: "{{ url('/admin/user-change-status') }}",
            data: {
                "id": id,
                "status": status,
                _token: '{{csrf_token()}}'
            },
            dataType: "JSON",
            success: function(response) {
              $('.alert').html('Status changed Successfully!');
              $('.alert').show();
              setTimeout(function() {
                $('.alert').hide();
              },5000);
               
            }
        });
    });
  });

</script>
@endpush