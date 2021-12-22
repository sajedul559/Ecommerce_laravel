@extends('admin.layouts.master')
@section('main_content')
    <div class="container-fluid">
        <form action="{{route('updateBrand',$brand->id)}}" method="POST">
            @csrf
            <div class="form-group">
              <label for="exampleInputEmail1">Brand Title <span class="text-danger">*</span></label>
              <input type="text" class="form-control" name="title" aria-describedby="emailHelp" value="{{$brand->title}}">
              @error('title')
               <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
            <div class="form-group">
              <label for="exampleInputPassword1">Status <span class="text-danger">*</span></label>
              <select name="status" id="" class="form-control">
                <option value="active">{{$brand->status}}</option>

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

@endsection