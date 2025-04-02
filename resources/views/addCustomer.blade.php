@extends('layouts.admin.master')

@section('title', 'Gills Lab -2025 Add Customer Page')
@section('content')
<div class="content-wrapper">
            <div class="page-header">
              <h3 class="page-title">
                <span class="page-title-icon bg-gradient-primary text-white me-2">
                  <i class="mdi mdi-home"></i>
                </span> Add Customer
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
                              <input type="text" name="depname" id="depname" value="{{ old('depname') }}"  placeholder="Enter Client Name" class="form-control" />
                              @if ($errors->has('depname'))
                                  <div class="error text-danger">{{ $errors->first('depname') }}</div>
                              @endif
                            </div>
                           
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Client Address </label>
                            <div class="col-sm-9">
                              <textarea rows="" cols=""  name="depadd" id="depadd"  class="form-control">{{ old('depadd') }}</textarea>
                              @if ($errors->has('depadd'))
                                  <div class="error text-danger">{{ $errors->first('depadd') }}</div>
                              @endif
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
                              <option value="">Select State</option>
                                @foreach($states as $state)
                                <option value="{{$state->state_id}}" >{{$state->state_name}}</option>
                                @endforeach
                                <!-- <option>Female</option> -->
                              </select>
                              @if ($errors->has('state'))
                                  <div class="error text-danger">{{ $errors->first('state') }}</div>
                              @endif
                            </div>
                          </div>
                        </div>
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">City </label>
                            <div class="col-sm-9">
                            <select class="form-select" name="city" id="city">
                                <option value="" >Select City</option>
                            </select>
                            @if ($errors->has('city'))
                                  <div class="error text-danger">{{ $errors->first('city') }}</div>
                              @endif

                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="row">
                       <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Other City</label>
                            <div class="col-sm-9">
                              <input type="text" name="ancity" id="ancity" class="form-control" />
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Depositor Name </label>
                            <div class="col-sm-9">
                              <input type="text" name="depositor" id="depositor" value="{{ old('depositor') }}"  class="form-control" />
                              @if ($errors->has('depositor'))
                                  <div class="error text-danger">{{ $errors->first('depositor') }}</div>
                              @endif
                            </div>
                          </div>
                        </div>
                      
                      </div>
                     
                      <div class="row">
                        <!-- <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Supplier  <span class="text-danger">*</spna></label>
                            <div class="col-sm-9">
                              <input type="text" name="supplier" id="supplier" value="{{ old('supplier') }}" class="form-control" />
                              @if ($errors->has('supplier'))
                                  <div class="error text-danger">{{ $errors->first('supplier') }}</div>
                              @endif
                            </div>
                          </div>
                        </div> -->
                       
                      </div>
                      <div class="row">
                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">Mobile Number <span class="text-danger">*</spna></label>
                            <div class="col-sm-9">
                              <input type="text" name="mobile" id="mobile"  value="{{ old('mobile') }}" class="form-control" />
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
                              <input type="text" name="email" id="email" class="form-control" />
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
                              <input type="text" name="panno" id="panno" class="form-control" />
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">TAN Number :
                              </label>
                            <div class="col-sm-9">
                              <input type="text" name="tanno" id="tanno" class="form-control" />
                            </div>
                          </div>
                        </div>
                        
                      </div>

                      <div class="row">
                        <div class="col-md-12">
                          <div class="form-group row">
                            <label class="col-sm-3 col-form-label">GST Number :
                              </label>
                            <div class="col-sm-9">
                              <input type="text" name="gstno" id="gstno" class="form-control" />
                            </div>
                          </div>
                        </div>

                      </div>

                      <hr>

                      <div class="row">
                        <div class="col-md-6">
                        <h4 class="card-title">Diamond Jewellery:</h4>
                          <div class="form-group row">
                           <!-- value="0.01-0.28" -->

                           
                            <div class="col-sm-5">
                              <input type="text" name="carat1"  value="{{$rates[0]->caratwt}}" class="form-control" />
                            </div>
                            <div class="col-sm-4">
                              <input type="text" name="rate1" value="{{$rates[0]->rate}}" class="form-control" />
                            </div>
                            <div class="col-sm-3">
                            <label class="col-sm-12 col-form-label">{{$rates[0]->ext}}</label>
                            </div>
                          </div>


                          <div class="form-group row">
                           
                            <div class="col-sm-5">
                              <input type="text" name="carat2" value="{{$rates[1]->caratwt}}" class="form-control" />
                            </div>
                            <div class="col-sm-4">
                              <input type="text" name="rate2" value="{{$rates[1]->rate}}" class="form-control" />
                            </div>
                            <div class="col-sm-3">
                            <label class="col-sm-12 col-form-label">{{$rates[1]->ext}}</label>
                            </div>
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                        <h4 class="card-title">Solitare Diamond Jewellery:</h4>
                        <div class="form-group row">
                           
                           <div class="col-sm-5">
                             <input type="text" name="carat3" value="{{$rates[2]->caratwt}}" class="form-control" />
                           </div>
                           <div class="col-sm-4">
                             <input type="text" name="rate3"  value="{{$rates[2]->rate}}"  class="form-control" />
                           </div>
                           <div class="col-sm-3">
                           <label class="col-sm-12 col-form-label">{{$rates[2]->ext}}</label>
                           </div>
                         </div>
                        
                         <div class="form-group row">
                           
                           <div class="col-sm-5">
                             <input type="text" name="carat4" value="{{$rates[3]->caratwt}}" class="form-control" />
                           </div>
                           <div class="col-sm-4">
                             <input type="text" name="rate4" value="{{$rates[3]->rate}}" class="form-control" />
                           </div>
                           <div class="col-sm-3">
                           <label class="col-sm-12 col-form-label">{{$rates[3]->ext}}</label>
                           </div>
                         </div>

                      </div>

                      <hr>  
                      <div class="row">
                        <div class="col-md-6">
                        <h4 class="card-title">Diamond Grading:</h4>
                          <div class="form-group row">
                           
                            <div class="col-sm-5">
                              <input type="text" name="carat5" value="{{$rates[4]->caratwt}}" class="form-control" />
                            </div>
                            <div class="col-sm-4">
                              <input type="text" name="rate5" value="{{$rates[4]->rate}}" class="form-control" />
                            </div>
                            <div class="col-sm-3">
                            <label class="col-sm-12 col-form-label">{{$rates[4]->ext}}</label>
                            </div>
                          </div>


                          <div class="form-group row">
                           
                            <div class="col-sm-5">
                              <input type="text" name="carat6"  value="{{$rates[5]->caratwt}}" class="form-control" />
                            </div>
                            <div class="col-sm-4">
                              <input type="text" name="rate6"  value="{{$rates[5]->rate}}" class="form-control" />
                            </div>
                            <div class="col-sm-3">
                            <label class="col-sm-12 col-form-label">{{$rates[5]->ext}}</label>
                            </div>
                          </div>
                        </div>
                        
                        <div class="col-md-6">
                        <h4 class="card-title">Solitaire Diamond Grading: </h4>
                        <div class="form-group row">
                           
                           <div class="col-sm-5">
                             <input type="text" name="carat7" value="{{$rates[6]->caratwt}}" class="form-control" />
                           </div>
                           <div class="col-sm-4">
                             <input type="text" name="rate7" value="{{$rates[6]->rate}}" class="form-control" />
                           </div>
                           <div class="col-sm-3">
                           <label class="col-sm-12 col-form-label">{{$rates[6]->ext}}</label>
                           </div>
                         </div>
                        
                         <div class="form-group row">
                           
                           <div class="col-sm-5">
                             <input type="text" name="carat8" value="{{$rates[7]->caratwt}}" class="form-control" />
                           </div>
                           <div class="col-sm-4">
                             <input type="text" name="rate8" value="{{$rates[7]->rate}}"class="form-control" />
                           </div>
                           <div class="col-sm-3">
                           <label class="col-sm-12 col-form-label">{{$rates[7]->ext}}</label>
                           </div>
                         </div>

                      </div>
                       
                      <hr>
                      <div class="row">
                        <div class="col-md-6">
                        <h4 class="card-title">Gemstones-Loose&Studded:</h4>
                          <div class="form-group row">
                           
                            <div class="col-sm-5">
                              <input type="text" name="carat9" value="{{$rates[8]->caratwt}}" class="form-control" />
                            </div>
                            <div class="col-sm-4">
                              <input type="text" name="rate9" value="{{$rates[8]->rate}}" class="form-control" />
                              
                            </div>
                            <div class="col-sm-3">
                            <label class="col-sm-12 col-form-label">{{$rates[8]->ext}}</label>
                              <!-- <input type="text" value="p/pc" readonly class="form-control" /> -->
                            </div>
                          </div>


                          <div class="form-group row">
                           
                            <div class="col-sm-5">
                              <input type="text" name="carat10" value="{{$rates[9]->caratwt}}" class="form-control" />
                            </div>
                            <div class="col-sm-4">
                              <input type="text" name="rate10" value="{{$rates[9]->rate}}" class="form-control" />
                            </div>
                            <div class="col-sm-3">
                            <label class="col-sm-12 col-form-label">{{$rates[9]->ext}}</label>
                            </div>
                          </div>

                          <div class="form-group row">
                           
                            <div class="col-sm-5">
                              <input type="text" name="carat11" value="{{$rates[10]->caratwt}}" class="form-control" />
                            </div>
                            <div class="col-sm-4">
                              <input type="text" name="rate11" value="{{$rates[10]->rate}}" class="form-control" />
                            </div>
                            <div class="col-sm-3">
                            <label class="col-sm-12 col-form-label">{{$rates[10]->ext}}</label>
                            </div>
                          </div>

                          <div class="form-group row">
                           
                            <div class="col-sm-5">
                              <input type="text"  name="carat12" value="{{$rates[11]->caratwt}}" class="form-control" />
                            </div>
                            <div class="col-sm-4">
                              <input type="text" name="rate12" value="{{$rates[11]->rate}}" class="form-control" />
                            </div>
                            <div class="col-sm-3">
                            <label class="col-sm-12 col-form-label">{{$rates[11]->ext}}</label>
                            </div>
                          </div>

                        </div>
                        
                        <div class="col-md-6">
                          <h4 class="card-title">CVD Check: </h4>
                            <div class="form-group row">
                              
                                <div class="col-sm-5">
                                  <input type="text" name="carat14" value="{{$rates[12]->caratwt}}" class="form-control" />
                                </div>
                                <div class="col-sm-4">
                                  <input type="text"  name="rate14" value="{{$rates[12]->rate}}" class="form-control" />
                                </div>
                                <div class="col-sm-3">
                                <label class="col-sm-12 col-form-label">{{$rates[12]->ext}}</label>
                                </div>
                            </div>
                        
                              <div class="form-group row">
                                
                                <div class="col-sm-5">
                                  <input type="text" name="carat15" value="{{$rates[13]->caratwt}}" class="form-control" />
                                </div>
                                <div class="col-sm-4">
                                  <input type="text" name="rate15" value="{{$rates[13]->rate}}" class="form-control" />
                                </div>
                                <div class="col-sm-3">
                                 <label class="col-sm-12 col-form-label">{{$rates[13]->ext}}</label>
                                </div>
                              </div>


                              <div class="form-group row">
                                
                                <div class="col-sm-5">
                                  <input type="text" name="carat16" value="{{$rates[14]->caratwt}}" class="form-control" />
                                </div>
                                <div class="col-sm-4">
                                  <input type="text" name="rate16" value="{{$rates[14]->rate}}" class="form-control" />
                                </div>
                                <div class="col-sm-3">
                                 <label class="col-sm-12 col-form-label">{{$rates[14]->ext}}</label>
                                </div>
                              </div>

                              <hr>
                              <h4 class="card-title">Uncut Jewellery: </h4>
                            <div class="form-group row">
                              
                                <div class="col-sm-5">
                                  <input type="text" name="carat17" value="{{$rates[15]->caratwt}}" class="form-control" />
                                </div>
                                <div class="col-sm-4">
                                  <input type="text" name="rate17" value="{{$rates[15]->rate}}" class="form-control" />
                                </div>
                                <div class="col-sm-3">
                                <label class="col-sm-12 col-form-label">{{$rates[15]->ext}}</label>
                                </div>
                            </div>
                        
                              <div class="form-group row">
                                
                                <div class="col-sm-5">
                                  <input type="text" name="carat18" value="{{$rates[16]->caratwt}}" class="form-control" />
                                </div>
                                <div class="col-sm-4">
                                  <input type="text" name="rate18" value="{{$rates[16]->rate}}" class="form-control" />
                                </div>
                                <div class="col-sm-3">
                                <label class="col-sm-12 col-form-label">{{$rates[16]->ext}}</label>
                                </div>
                              </div>

                        </div>


                        <button class="btn btn-primary" type="submit">Create</button>
                        
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
</script>


@endsection          