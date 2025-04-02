@extends('layouts.admin.master')

@section('title', 'Gills Lab -2025 Edit Customer Page')
@section('content')
<div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> Update Customer
              </h3>
              <nav aria-label="breadcrumb">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item active" aria-current="page">
                    <span></span><a href="{{route('customer.viewClients')}}" >View Customer</a> 
                  </li>

                  <li class="breadcrumb-item active" aria-current="page">
                    <span></span>Edit Customer 
                  </li>
                </ul>
              </nav>
            </div>
           

            <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Client Information Edit Form</h4>
                    <form class="form-sample" method="POST" action="{{ route('client.update', $clientinformation->client_id ?? '') }}" enctype="multipart/form-data">


                     @csrf   
                    <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Client Name <span class="text-danger">*</spna></label>
                            <div class="col-sm-9">
                            <input type="hidden" name="client_id" value="{{ $clientinformation->client_id ?? '' }}">
                              <input type="text" name="depname" id="depname" value="{{ $clientinformation->client_name}}"  placeholder="Enter Client Name" class="form-control" />
                              @if ($errors->has('depname'))
                                  <div class="error text-danger">{{ $errors->first('depname') }}</div>
                              @endif
                            </div>
                           
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Client Address</label>
                            <div class="col-sm-9">
                              <textarea rows="" cols="" name="depadd" id="depadd" class="form-control">{{ $clientinformation->address}}</textarea>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">State</label>
                            <div class="col-sm-9">
                              <select class="form-select" name="state" id="state">
                                <!-- @foreach($states as $state)
                                <option value={{$state->state_id}}>{{$state->state_name}}</option>
                                @endforeach
                                -->
                                <option value="">Select State</option>
                                @foreach($states as $state)
                                  <option value="{{ $state->state_id }}" 
                                      {{ isset($clientinformation) && $clientinformation->state == $state->state_id ? 'selected' : '' }}>
                                      {{ $state->state_name }}
                                  </option>
                                @endforeach
                              
                              </select>
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">City </label>
                            <div class="col-sm-9">
                            <select class="form-select" name="city" id="city">
                            <option value="">Select City</option>

                                    <!-- @foreach($cities as $cityy)
                                        <option value="{{ $cityy->id }}" {{ $clientinformation->city == $cityy->id ? 'selected' : '' }}>
                                            {{ $cityy->city_name }}
                                        </option>
                                    @endforeach   -->


                            </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                       <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Other City</label>
                            <div class="col-sm-9">
                              <input type="text" name="ancity" id="ancity" value="{{ $clientinformation->other_city}}"   class="form-control" />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Retailer</label>
                            <div class="col-sm-9">
                              <input type="text" name="retailer" id="retailer" value="{{ $clientinformation->retailer}}" class="form-control" />
                            </div>
                          </div>
                        </div>
                      </div>
                     
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Supplier  </label>
                            <div class="col-sm-9">
                              <input type="text" name="supplier" id="supplier" value="{{ $clientinformation->supplier}}" class="form-control" />
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Depositor Name</label>
                            <div class="col-sm-9">
                              <input type="text" name="depositor" id="depositor" value="{{ $clientinformation->depositorname}}" class="form-control" />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Mobile Number <span class="text-danger">*</spna></label>
                            <div class="col-sm-9">
                              <input type="text" name="mobile" id="mobile"   value="{{ $clientinformation->phonenumber}}"  class="form-control" />
                              @if ($errors->has('mobile'))
                                <div class="error text-danger">{{ $errors->first('mobile') }}</div>
                             @endif

                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Email ID</label>
                            <div class="col-sm-9">
                              <input type="text" name="email" id="email"  value="{{ $clientinformation->email}}"  class="form-control" />
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">PAN Number :
                              </label>
                            <div class="col-sm-9">
                              <input type="text" name="panno" id="panno" value="{{ $clientinformation->panno}}"  class="form-control" />
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">TAN Number :
                              </label>
                            <div class="col-sm-9">
                              <input type="text" name="tanno" id="tanno" value="{{ $clientinformation->tanno}}"  class="form-control" />
                            </div>
                          </div>
                        </div>
                        
                      </div>

                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">GST Number :
                              </label>
                            <div class="col-sm-9">
                              <input type="text" name="gstno" id="gstno" value="{{ $clientinformation->gstno}}"  class="form-control" />
                            </div>
                          </div>
                        </div>

                     
                        <div class="col-md-6">
                      <div class="form-group row">
                          <label for="formFile" class="col-sm-3 col-form-label">Upload Brand Logo:</label>
                          <div class="col-sm-9">
                              <div class="mb-3">
                                  <input class="form-control" type="file" id="formFile" name="formFile" accept="image/*" onchange="previewImage(event)">
                                  
                                  <!-- Display existing logo if available -->
                                  <img id="preview" 
                                      src="{{ asset('storage/' . $clientinformation->cobranding_logo ?? '') }}" 
                                      alt="Image Preview" 
                                      style="margin-top: 10px; max-width: 100px; height: auto; border: 1px solid #ddd; padding: 5px; {{ isset($clientinformation->cobranding_logo) ? '' : 'display: none;' }}">
                              </div>
                          </div>
                      </div>
                  </div>
                       



                      </div>

                      <hr>

                      <div class="row">
                        <div class="col-md-6">
                        <h4 class="card-title">Diamond Jewellery:</h4>
                          <div class="form-group row">
                           
                            <div class="col-sm-5">
                              <input type="text" name="carat1"  value="{{ $clientinformation->carat1}}"  class="form-control" />
                            </div>
                            <div class="col-sm-4">
                              <input type="text" name="rate1" value="{{ $clientinformation->dj1}}" class="form-control" />
                            </div>
                            <div class="col-sm-3">
                            <label class="col-sm-12 col-form-label">p/pc</label>
                            </div>
                          </div>


                          <div class="form-group row">
                           
                            <div class="col-sm-5">
                              <input type="text" name="carat2" value="{{ $clientinformation->carat2}}" class="form-control" />
                            </div>
                            <div class="col-sm-4">
                              <input type="text" name="rate2" value="{{ $clientinformation->dj2}}" class="form-control" />
                            </div>
                            <div class="col-sm-3">
                            <label class="col-sm-12 col-form-label">p/ct</label>
                            </div>
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                        <h4 class="card-title">Solitare Diamond Jewellery:</h4>
                        <div class="form-group row">
                           
                           <div class="col-sm-5">
                             <input type="text" name="carat3" value="{{ $clientinformation->carat3}}" class="form-control" />
                           </div>
                           <div class="col-sm-4">
                             <input type="text" name="rate3" value="{{ $clientinformation->sdj1}}" class="form-control" />
                           </div>
                           <div class="col-sm-3">
                           <label class="col-sm-12 col-form-label">p/pc</label>
                           </div>
                         </div>
                        
                         <div class="form-group row">
                           
                           <div class="col-sm-5">
                             <input type="text" name="carat4" value="{{ $clientinformation->carat4}}" class="form-control" />
                           </div>
                           <div class="col-sm-4">
                             <input type="text" name="rate4" value="{{ $clientinformation->sdj2}}" class="form-control" />
                           </div>
                           <div class="col-sm-3">
                           <label class="col-sm-12 col-form-label">p/ct</label>
                           </div>
                         </div>

                      </div>

                      <hr>  
                      <div class="row">
                        <div class="col-md-6">
                        <h4 class="card-title">Diamond Grading:</h4>
                          <div class="form-group row">
                           
                            <div class="col-sm-5">
                              <input type="text" name="carat5" value="{{ $clientinformation->carat5}}" class="form-control" />
                            </div>
                            <div class="col-sm-4">
                              <input type="text" name="rate5" value="{{ $clientinformation->dg1}}" class="form-control" />
                            </div>
                            <div class="col-sm-3">
                            <label class="col-sm-12 col-form-label">p/ct</label>
                            </div>
                          </div>


                          <div class="form-group row">
                           
                            <div class="col-sm-5">
                              <input type="text" name="carat6" value="{{ $clientinformation->carat6}}" class="form-control" />
                            </div>
                            <div class="col-sm-4">
                              <input type="text" name="rate6" value="{{ $clientinformation->dg2}}" class="form-control" />
                            </div>
                            <div class="col-sm-3">
                            <label class="col-sm-12 col-form-label">p/ct</label>
                            </div>
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                        <h4 class="card-title">Solitaire Diamond Grading: </h4>
                        <div class="form-group row">
                           
                           <div class="col-sm-5">
                             <input type="text" name="carat7" value="{{ $clientinformation->carat7}}"  class="form-control" />
                           </div>
                           <div class="col-sm-4">
                             <input type="text" name="rate7" value="{{ $clientinformation->sdg1}}"  class="form-control" />
                           </div>
                           <div class="col-sm-3">
                           <label class="col-sm-12 col-form-label">p/pc</label>
                           </div>
                         </div>
                        
                         <div class="form-group row">
                           
                           <div class="col-sm-5">
                             <input type="text" name="carat8" value="{{ $clientinformation->carat8}}" class="form-control" />
                           </div>
                           <div class="col-sm-4">
                             <input type="text" name="rate8" value="{{ $clientinformation->sdg2}}" class="form-control" />
                           </div>
                           <div class="col-sm-3">
                           <label class="col-sm-12 col-form-label">p/ct</label>
                           </div>
                         </div>

                      </div>
                       
                      <hr>
                      <div class="row">
                        <div class="col-md-6">
                        <h4 class="card-title">Gemstones-Loose&Studded:</h4>
                          <div class="form-group row">
                           
                            <div class="col-sm-5">
                              <input type="text" name="carat9" value="{{ $clientinformation->carat9}}" class="form-control" />
                            </div>
                            <div class="col-sm-4">
                              <input type="text" name="rate9" value="{{ $clientinformation->gls1}}"  class="form-control" />
                              
                            </div>
                            <div class="col-sm-3">
                            <label class="col-sm-12 col-form-label">p/pc</label>
                              <!-- <input type="text" value="p/pc" readonly class="form-control" /> -->
                            </div>
                          </div>


                          <div class="form-group row">
                           
                            <div class="col-sm-5">
                              <input type="text" name="carat10" value="{{ $clientinformation->carat10}}" class="form-control" />
                            </div>
                            <div class="col-sm-4">
                              <input type="text" name="rate10" value="{{ $clientinformation->gls2}}" class="form-control" />
                            </div>
                            <div class="col-sm-3">
                            <label class="col-sm-12 col-form-label">p/pc</label>
                            </div>
                          </div>

                          <div class="form-group row">
                           
                            <div class="col-sm-5">
                              <input type="text" name="carat11" value="{{ $clientinformation->carat11}}" class="form-control" />
                            </div>
                            <div class="col-sm-4">
                              <input type="text" name="rate11" value="{{ $clientinformation->gls3}}" class="form-control" />
                            </div>
                            <div class="col-sm-3">
                            <label class="col-sm-12 col-form-label">p/pc</label>
                            </div>
                          </div>

                          <div class="form-group row">
                           
                            <div class="col-sm-5">
                              <input type="text"  name="carat12" value="{{ $clientinformation->carat12}}" class="form-control" />
                            </div>
                            <div class="col-sm-4">
                              <input type="text" name="rate12" value="{{ $clientinformation->gls4}}" class="form-control" />
                            </div>
                            <div class="col-sm-3">
                            <label class="col-sm-12 col-form-label">p/ct</label>
                            </div>
                          </div>

                        </div>
                        
                        <div class="col-md-6">
                          <h4 class="card-title">CVD Check: </h4>
                            <div class="form-group row">
                              
                                <div class="col-sm-5">
                                  <input type="text" name="carat14" value="{{ $clientinformation->carat14}}" class="form-control" />
                                </div>
                                <div class="col-sm-4">
                                  <input type="text"  name="rate14" value="{{ $clientinformation->cvd2}}" class="form-control" />
                                </div>
                                <div class="col-sm-3">
                                <label class="col-sm-12 col-form-label">p/ct</label>
                                </div>
                            </div>
                        
                              <div class="form-group row">
                                
                                <div class="col-sm-5">
                                  <input type="text" name="carat15" value="{{ $clientinformation->carat15}}" class="form-control" />
                                </div>
                                <div class="col-sm-4">
                                  <input type="text" name="rate15" value="{{ $clientinformation->cvd3}}" class="form-control" />
                                </div>
                                <div class="col-sm-3">
                                 <label class="col-sm-12 col-form-label">p/pc</label>
                                </div>
                              </div>


                              <div class="form-group row">
                                
                                <div class="col-sm-5">
                                  <input type="text" name="carat16"  value="{{ $clientinformation->carat16}}"  class="form-control" />
                                </div>
                                <div class="col-sm-4">
                                  <input type="text" name="rate16"  value="{{ $clientinformation->cvd4}}"  class="form-control" />
                                </div>
                                <div class="col-sm-3">
                                 <label class="col-sm-12 col-form-label">p/pc</label>
                                </div>
                              </div>

                              <hr>
                              <h4 class="card-title">Uncut Jewellery: </h4>
                            <div class="form-group row">
                              
                                <div class="col-sm-5">
                                  <input type="text" name="carat17"  value="{{ $clientinformation->carat17}}"  class="form-control" />
                                </div>
                                <div class="col-sm-4">
                                  <input type="text" name="rate17" value="{{ $clientinformation->un1}}"  class="form-control" />
                                </div>
                                <div class="col-sm-3">
                                <label class="col-sm-12 col-form-label">p/pc</label>
                                </div>
                            </div>
                        
                              <div class="form-group row">
                                
                                <div class="col-sm-5">
                                  <input type="text" name="carat18"  value="{{ $clientinformation->carat18}}" class="form-control" />
                                </div>
                                <div class="col-sm-4">
                                  <input type="text" name="rate18"  value="{{ $clientinformation->un2}}" class="form-control" />
                                </div>
                                <div class="col-sm-3">
                                <label class="col-sm-12 col-form-label">p/pt</label>
                                </div>
                              </div>

                        </div>


                        <button class="btn btn-primary" type="submit">Save Changes</button>
                        
                    </form>
                  </div>
                </div>
              </div>

            <!-- <div class="row">
              <div class="col-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <h4 class="card-title">Recent Tickets</h4>
                    <div class="table-responsive">
                      <table class="table">
                        <thead>
                          <tr>
                            <th> Assignee </th>
                            <th> Subject </th>
                            <th> Status </th>
                            <th> Last Update </th>
                            <th> Tracking ID </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                              <img src="assets/images/faces/face1.jpg" class="me-2" alt="image"> David Grey
                            </td>
                            <td> Fund is not recieved </td>
                            <td>
                              <label class="badge badge-gradient-success">DONE</label>
                            </td>
                            <td> Dec 5, 2017 </td>
                            <td> WD-12345 </td>
                          </tr>
                          <tr>
                            <td>
                              <img src="assets/images/faces/face2.jpg" class="me-2" alt="image"> Stella Johnson
                            </td>
                            <td> High loading time </td>
                            <td>
                              <label class="badge badge-gradient-warning">PROGRESS</label>
                            </td>
                            <td> Dec 12, 2017 </td>
                            <td> WD-12346 </td>
                          </tr>
                          <tr>
                            <td>
                              <img src="assets/images/faces/face3.jpg" class="me-2" alt="image"> Marina Michel
                            </td>
                            <td> Website down for one week </td>
                            <td>
                              <label class="badge badge-gradient-info">ON HOLD</label>
                            </td>
                            <td> Dec 16, 2017 </td>
                            <td> WD-12347 </td>
                          </tr>
                          <tr>
                            <td>
                              <img src="assets/images/faces/face4.jpg" class="me-2" alt="image"> John Doe
                            </td>
                            <td> Loosing control on server </td>
                            <td>
                              <label class="badge badge-gradient-danger">REJECTED</label>
                            </td>
                            <td> Dec 3, 2017 </td>
                            <td> WD-12348 </td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->
           
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
        var selectedCity = "{{ $clientinformation->city ?? '' }}"; // Get selected city from Blade

        console.log("selected city",selectedCity);

        // Function to fetch cities based on state
        function fetchCities(stateId) {
            if (stateId) {
                $.ajax({
                    url: "{{ url('get-cities') }}/" + stateId, // Your API endpoint
                    type: "GET",
                    success: function (data) {

                      console.log(data);
                        $('#city').html('<option value="">Select City</option>');
                        $.each(data, function (key, value) {
                          // console.log("value",value.city_id)
                            var selected = (selectedCity == value.city_id) ? 'selected' : ''; 
                            $('#city').append('<option value="' + value.city_id + '" ' + selected + '>' + value.city_name + '</option>');
                        });
                    }
                });
            } else {
                $('#city').html('<option value="">Select City</option>');
            }
        }

        // On state change
        $('#state').change(function () {
            var stateId = $(this).val();
            fetchCities(stateId);
        });

        // Preload cities if editing
        if ($('#state').val() !== '') {
            fetchCities($('#state').val());
        }
    });

</script>

<script>
                                function previewImage(event) {
                                    const input = event.target;
                                    const preview = document.getElementById("preview");

                                    if (input.files && input.files[0]) {
                                        const reader = new FileReader();

                                        reader.onload = function(e) {
                                            preview.src = e.target.result;
                                            preview.style.display = "block";
                                        };

                                        reader.readAsDataURL(input.files[0]);
                                    } else {
                                        preview.style.display = "none";
                                    }
                                }
                          </script>


@endsection          