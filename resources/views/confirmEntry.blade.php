@extends('layouts.admin.master')

@section('title', 'Gills Lab -2025  Confirm Entry Customer Page')
@section('content')
<div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> Confirm Entry Customer
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
                    <h4 class="card-title">Client Information Entry Form</h4>
                    <form class="form-sample" method="POST" action="{{route('add_clientinformation')}}">
                     @csrf   
                    <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Client Name <span class="text-danger">*</spna></label>
                            <div class="col-sm-9">
                              <input type="text" name="depname" id="depname" value="{{ $customerDetails->client_name }}"  placeholder="Enter Client Name" class="form-control" />
                              @if ($errors->has('depname'))
                                  <div class="error text-danger">{{ $errors->first('depname') }}</div>
                              @endif
                            </div>
                           
                          </div>
                        </div>
                        

                     
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Select Logo</label>
                            <div class="col-sm-9">
                              <select class="form-select" name="state" id="state">
                                <option value="0">Select Logo</option>
                                @foreach($companyLogo as $logo)
                                <option value="{{ $logo->id }}" data-image="{{ asset('storage/' . $logo->logoname) }}">
                                      {{ $logo->logotext }}
                                  </option>

                                @endforeach
                                <!-- <option>Female</option> -->
                              </select>
                              <div class="d-flex justify-content-between">
                              <img id="logoPreviewLogo" src="" class="img-fluid mt-2 rounded-circle" style="max-width: 70px; display: none;">
                              <a href="{{route('cobranding_index',$customerDetails->client_id)}}" class="mt-2" >Add Co Branding</a>
                              </div>
                              
                            </div>
                          
                          </div>
                          
                        </div>

                        <div class="col-md-3">
                          <div class="form-group row">
                            <label class="col-sm-6 col-form-label">Depositor Name</label>
                            <div class="col-sm-6">
                              
                            <input type="text" name="DepositorName" class="form-control" />
                              
                            </div>
                          
                          </div>
                          
                        </div>


                        <div class="col-md-3">
                          <div class="form-group row">
                            <label class="col-sm-6 col-form-label">Receiver Name</label>
                            <div class="col-sm-6">
                              
                            <input type="text" name="ReceiverName" value="{{Auth()->user()->name}}" class="form-control" />
                              
                            </div>
                          
                          </div>
                          
                        </div>


                        <div class="col-md-3">
                          <div class="form-group row">
                            <label class="col-sm-6 col-form-label">Invoice Date</label>
                            <div class="col-sm-6">
                              
                            <input type="date" name="InvoiceDate" class="form-control" />
                              
                            </div>
                          
                          </div>
                          
                        </div>


                        <div class="col-md-3">
                          <div class="form-group row">
                            <label class="col-sm-6 col-form-label">Delivery Date</label>
                            <div class="col-sm-6">
                              
                            <input type="date" name="Deliverydate"  class="form-control" />
                              
                            </div>
                          
                          </div>
                          
                        </div>
                         
                        <hr>
                        <div class="col-md-12">
                        <h4 class="card-title">Confirm Entry for Service:</h4>
                          
                        <div id="dynamicRows">
                          <div class="form-group row">
                              <div class="col-sm-3">
                                  <label class="col-sm-12 col-form-label">Item</label>
                                  <select class="form-select" name="item[]" id="item">
                                  <option value="0">Select Item</option>
                                    <option value="Jewellery">Jewellery</option>
                                    <option value="Loose diamond">Loose diamond</option>
                                    <option value="Gem Stone">Gem Stone</option>
                                    <option value="CVD">CVD</option>
                 
                                  </select>
                              </div>

                              <div class="col-sm-2">
                                  <label class="col-sm-12 col-form-label">No. of Pieces</label>
                                  <input type="text" name="pieces[]" class="form-control" />
                              </div>

                              <div class="col-sm-2">
                                  <label class="col-sm-12 col-form-label">Weight</label>
                                  <input type="text" name="weight[]" class="form-control" />
                              </div>

                              <div class="col-sm-3">
                                  <label class="col-sm-12 col-form-label">Service</label>
                                  <select class="form-select" name="service[]" id="service">
                                      <option value="0">Select Service</option>
                                      @foreach($services as $service)
                                      <option value="{{$service->service_id}}">{{$service->service_name}}</option>
                                      @endforeach
                                  </select>
                              </div>

                              <div class="col-sm-2">
                                  <label class="col-sm-12 col-form-label">Add More</label>
                                  <button type="button" class="btn btn-primary" id="addMore">+</button>
                              </div>
                          </div>
                      </div>



                         
                    
                    
                       


                        <button class="btn btn-primary" type="submit">Create</button>
                        
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
<script>
  $(document).ready(function () {
    $('#state').on('change', function () {
        var stateId = $(this).val();
        var cityDropdown = $('#city');

        // Clear city dropdown
        cityDropdown.empty();
        cityDropdown.append('<option value="">Select City</option>');

        if (stateId) {
            $.ajax({
                url: "{{ route('get-cities') }}", // Route to fetch cities
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}", // CSRF token for security
                    state_id: stateId
                },
                success: function (cities) {
                    $.each(cities, function (key, city) {
                      console.log(city);
                        cityDropdown.append('<option value="' + city.city_id + '">' + city.city_name + '</option>');
                    });
                }
            });
        }
    });
});


$('#state').on('change', function() {
    var imageUrl = $(this).find(':selected').data('image');
  console.log("dkfjds", imageUrl)
    if (imageUrl) {
        $('#logoPreviewLogo').attr('src', imageUrl).show();
    } else {
        $('#logoPreviewLogo').hide();
    }
}); 


$(document).ready(function() {
    $('#addMore').click(function() {
        var newRow = `
        <div class="form-group row">
            <div class="col-sm-3">
                <select class="form-select" name="item[]">
                  <option value="0">Select Item</option>
                                   <option value="Jewellery">Jewellery</option>
                                    <option value="Loose diamond">Loose diamond</option>
                                    <option value="Gem Stone">Gem Stone</option>
                                    <option value="CVD">CVD</option>   

                </select>
            </div>

            <div class="col-sm-2">
                <input type="text" name="pieces[]" class="form-control" placeholder="No. of Pieces" />
            </div>

            <div class="col-sm-2">
                <input type="text" name="weight[]" class="form-control" placeholder="Weight" />
            </div>

            <div class="col-sm-3">
                <select class="form-select" name="service[]">
                 <option value="0">Select Service</option>
                    @foreach($services as $service)
                                      <option value="{{$service->service_id}}">{{$service->service_name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-sm-2">
                <button type="button" class="btn btn-danger removeRow">-</button>
            </div>
        </div>
        `;

        $('#dynamicRows').append(newRow);
    });

    // Remove row when clicking the remove button
    $(document).on('click', '.removeRow', function() {
        $(this).closest('.form-group.row').remove();
    });
});












</script>


@endsection          