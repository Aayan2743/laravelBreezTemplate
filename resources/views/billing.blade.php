@extends('layouts.admin.master')

@section('title', 'Gills Lab -2025 View Customer Page')
@section('content')
<div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> View Billing & Invoice
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
                    <h4 class="card-title">Billing & Invoice</h4>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <input type="text" id="search" class="form-control" placeholder="Search Client Name or Confirmation ID or Depositor or Reciever...">
                        </div>
                    </div>

                    <form method="GET" action="{{ url()->current() }}">
                      <label for="perPage">Records per page:</label>
                      <select name="per_page" id="perPage" onchange="this.form.submit()">
                          <option value="5" {{ request('per_page') == 5 ? 'selected' : '' }}>5</option>
                          <option value="8" {{ request('per_page') == 8 ? 'selected' : '' }}>8</option>
                          <option value="15" {{ request('per_page') == 15 ? 'selected' : '' }}>15</option>
                          <option value="200" {{ request('per_page') == 200 ? 'selected' : '' }}>200</option>
                      </select>
                  </form>

                    <div id="clientTable">
                      @include('partials.billing_table')
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
<!-- <script>
$(document).ready(function() {
    $('#search').on('keyup', function() {
        let search = $(this).val();

        $.ajax({
            url: "{{ route('confirmEntrys.index') }}",
            type: "GET",
            data: { search: search },
            success: function(data) {
                $('#clientTable').html(data);
            }
        });
    });
});
</script> -->
<script>
$(document).ready(function() {
    // Capture the search input and per_page value
    $('#search').on('keyup', function() {
        let search = $(this).val();
        let perPage = $('#per_page').val() || 8; // Default to 8 if not set

        $.ajax({
            url: "{{ route('invoices.index') }}",
            type: "GET",
            data: { 
                search: search,
                per_page: perPage 
            },
            success: function(data) {
                $('#clientTable').html(data);
            }
        });
    });

    // Trigger search on per_page change
    $('#per_page').on('change', function() {
        let search = $('#search').val();
        let perPage = $(this).val();

        $.ajax({
            url: "{{ route('confirmEntrys.index') }}",
            type: "GET",
            data: { 
                search: search,
                per_page: perPage 
            },
            success: function(data) {
                $('#clientTable').html(data);
            }
        });
    });
});


</script>

@endsection          