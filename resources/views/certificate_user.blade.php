@extends('layouts.admin.guest')

@section('title', 'Gills Lab -2025 UploadsPage')
@section('content')
<div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> Print Certificates
              </h3>
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Overview <i class="mdi mdi-alert-circle-outline icon-sm text-primary align-middle"></i>
                  </li>
                </ul>
              </nav>
            </div>
           

          

            <div class="col-12 grid-margin">
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Enter Job id</h4>

                    <div class="row mb-3">
                        <form method="post" action="{{route('user.certificate')}}">
                          @csrf
                            <div class="col-md-6">
                                <input type="text" id="search" class="form-control" name="jobid" placeholder="Enter Job Card id..">
                            </div>

                            <div class="col-md-6">
                                <button class="btn btn-primary" type="submit"> Search </button>
                            </div>
                        </form>
                     
                    </div>
                  

                  



                   

               
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
            url: "{{ route('viewdiamondjob') }}",
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