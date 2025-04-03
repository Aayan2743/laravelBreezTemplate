@extends('layouts.admin.master')

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
                        <div class="col-md-6">
                       
                          <div class="form-group row">
                           <!-- value="0.01-0.28" -->
                           @if (session('success'))
                                <p style="color: green">{{ session('success') }}</p>
                            @endif
                           <div class="mb-3">
                           <h4 for="formFile" class="card-title">Diamond Jewellery Job Upload:</h4>
                            <!-- <label for="formFile" class="form-label">Default file input example</label> -->
                            <!-- <input class="form-control" type="file" id="formFile"> -->
                            <form action="{{ route('import') }}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                   <div class="d-flex">
                                        <input type="file" class="form-control" name="file" required>
                                        <button class="btn btn-primary" type="submit">Upload</button>
                                   </div>

                                  
                                </form>
                              <a href="{{route('download.file',['filename' => 'sample.xlsx'])}}">Download sample file</a>

                          </div>
                        
                         
                          </div>



                         

                      </div>

                     
                       
                      
                          
                          

                             
                            


                  
                        
                  
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
                      @include('partials.client_table_jobcard')
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