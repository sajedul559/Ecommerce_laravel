@extends('admin.layouts.master')
@section('main_content')
    <div class="container-fluid">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">All Brand</h1>
            <button type="button"  class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm" data-toggle="modal" data-target="#addBanner"><i
                    class="fas fa-plus fa-sm text-white-50"></i> Add Banner</button>
                      

        </div>
        <table id="dataTable" class="table table-bordered">
            <thead>
              <tr class="text-center" style="background:rgb(35, 35, 245)">
                <th scope="col" class="text-white">#</th>
                <th scope="col" class="text-white">Title</th>
                <th scope="col" class="text-white">Status</th>
                <th scope="col" class="text-white">Slug</th>
                <th class="text-white" scope="col">Action</th>

              </tr>
            </thead>
            <tbody>
                @foreach ($brands as $brand )
                <tr class="text-center">
                    <td>{{$loop->index}}</td>
                    <td>{{$brand->title}}</td>
                    <td>
                        @if ($brand->status=='active')
                            <span class="badge badge-success">{{$brand->status}} </span>
                        @else
                        <span class="badge badge-warning">{{$brand->status}} </span>
                        @endif
                    </td>
                    <td>{{$brand->slug}}</td>
                    <td>
                        <a href="{{route('editBrand',$brand->id)}}"  class="btn btn-primary btn-sm mr-1 edit"><span class="fa fa-edit"></span></a>
                                          
                        <a href="{{route('deleteBrand',$brand->id)}}"   class="btn btn-danger btn-sm"><span class="fa fa-trash"></span></a>
                    </td>

                  </tr>
                @endforeach
             
              
            </tbody>
          </table>


    </div>    



 
  
  <!-- Brand ADD Modal -->
  <div class="modal fade" id="addBanner"  tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Add Brand</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form action="{{route('storeBrand')}}" method="POST">
                @csrf
                <div class="form-group">
                  <label for="exampleInputEmail1">Brand Title <span class="text-danger">*</span></label>
                  <input type="text" class="form-control" name="title" aria-describedby="emailHelp" placeholder="Enter Title" value="{{old('email')}}">
                  @error('title')
                   <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Status <span class="text-danger">*</span></label>
                  <select name="status" id="" class="form-control">
                      <option value="active">Active</option>
                      <option value="inactive">Inactive</option>
                  </select>
                  @error('status')
                      <span class="text-danger">{{$message}}</span>
                  @enderror
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Brand</button>
                  </div>
            </form>
        </div>
        
      </div>
    </div>
  </div>
   

    
@endsection

  <script>
    function brandDelete(id){
      alert(id);

    }
  </script>
    
