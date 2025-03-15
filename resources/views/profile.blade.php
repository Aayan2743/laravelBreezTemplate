@extends('layouts.admin.master')

@section('title', 'Gills Lab -2025 View Customer Page')
@section('content')
<div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> View User Profile
              </h3>
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                  </li>
                </ul>
              </nav>
            </div>
           

            <div class="col-12 grid-margin stretch-card">
                <div class="card">
                  <div class="card-body">
                  @php
                    $user=Auth()->user();
                    //dd($user->id);
                  @endphp



                    <form class="forms-sample"  action="{{ route('updateUpdate', $user->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('put')   
                    
                    <div class="form-group">
                        <label for="exampleInputName1">Name</label>
                        <input type="text" class="form-control" value="{{$user->name}}" id="uname" name="uname" placeholder="Name">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputEmail3">Email address</label>
                        <input type="email" class="form-control" value="{{$user->email}}"  id="email" name="email" placeholder="Email">
                      </div>
                      <div class="form-group">
                        <label for="exampleInputPassword4">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword4" id="password" name="password" placeholder="Password">
                      </div>
                      
                      <div class="form-group">
                          <label>File upload</label>
                          <input type="file" name="profile_image" class="file-upload-default">
                          <div class="input-group col-xs-12">
                              <input type="text" class="form-control file-upload-info" placeholder="Upload Image">
                              <span class="input-group-append">
                                  <button class="file-upload-browse btn btn-gradient-primary py-3" type="button">Upload</button>
                              </span>
                          </div>
                      </div>
                                        
                      <button type="submit" class="btn btn-gradient-primary me-2">Submit</button>
                      <button class="btn btn-light">Cancel</button>
                    </form>
                  </div>
                </div>
              </div>


         
            @if (session('success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Success',
            text: '{{ session("success") }}',
        });
    </script>
@endif

@if (session('error'))
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: '{{ session("error") }}',
        });
    </script>
@endif   
</div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('#search').on('keyup', function() {
        let search = $(this).val();

        $.ajax({
            url: "{{ route('clients.index') }}",
            type: "GET",
            data: { search: search },
            success: function(data) {
                $('#clientTable').html(data);
            }
        });
    });
});
</script>



@endsection          