@extends('admin.layouts.app', ['activePage' => 'state', 'titlePage' => __('State Management')])

@section('content')
<div class="content">
  <div class="container-fluid">
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header card-header-primary">
            <h4 class="card-title ">State Listing</h4>            
          </div>
          <div class="card-body">

           <a class="btn btn-primary" href="{{route('admin.state.create')}}"><span class="glyphicon glyphicon-plus"></span> Add New State</a>

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
                  <th>Country</th>                 
                  <th>Created Date</th>                  
                  <th>Action</th>
                </thead>
                <tbody>
                  @if(isset($list) && !empty($list))
                    @foreach($list as $key => $value)
                    <tr>
                    <td>{{($key+1)}}</td>
                    <td>{{$value->name}}</td>
                    <td>{{$value->country}}</td>
                    <td>{{Carbon\Carbon::parse($value->created_at)->format('d-m-Y')}}</td>
                    
                    <td>
                    <a href="{{ route('admin.state.edit',$value->id) }}" class="link" />Edit <i class="fa fa-pencil"></i></a>                   
                    
                    <form action="{{ route('admin.state.destroy',$value->id) }}" method="POST">   
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
            {{ $list->links() }}
          </div>
        </div>
      </div>      
  </div>
</div>
     
@endsection