@extends('layouts.admin.master')

@section('title', 'Gills Lab -2025 Co-Branding Service List')
@section('content')
<div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> Invoice Charges
              </h3>
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                <!-- <li class="breadcrumb-item active" aria-current="page">
                    <span></span><a href="{{route('customer.viewClients')}}" >List Services </a> 
                  </li>


                  <li class="breadcrumb-item active" aria-current="page">
                    <span></span>List Services
                  </li> -->
                </ul>
              </nav>
            </div>
           

            <div class="col-12 grid-margin">
            <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                      <div class="d-flex justify-content-between"> 
                            <h4 class="card-title">Invoice Charges List </h4>
                            <button class="btn btn-primary" data-bs-toggle="modal" data-ds-name="#" data-ds-cid="#"  data-bs-target="#addNewService"> Add</button>
                      </div>
                  

                    <!-- <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" id="search" class="form-control" placeholder="Search Client Name or Supplier...">
                        </div>
                    </div> -->

                    <div id="clientTabl">
                    @include('partials.invoiceCharges_table')
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