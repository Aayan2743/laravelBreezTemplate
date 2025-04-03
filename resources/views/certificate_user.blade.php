@extends('layouts.admin.guest')

@section('title', 'Gills Lab -2025 UploadsPage')
@section('content')
<div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> Diamond Jewellery Job Upload:
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
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Uploads</h4>
                    
                    <div class="row">
                       

                      <hr>

                      <div class="row">
                      
                  
                      </div>
                </div>
            </div>

            <div class="col-12 grid-margin">
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Client Details</h4>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" id="search" class="form-control" placeholder="Search Confirmation Id or Job Card id..">
                        </div>
                    </div>

                    <div id="clientTable">
                   
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