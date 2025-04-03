
@if (session()->has('totalRecords'))
    <div class="alert alert-success">
        <strong>Total Records:</strong> {{ session('totalRecords') }}<br>
        <strong>Inserted Records:</strong> {{ session('totalInserted') }}<br>
        <strong>Skipped Records:</strong> {{ session('totalSkipped') }}
    </div>
@endif

<form action="{{ route('upload_images') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>S No</th>
                    <th>Confirmation No</th>
                    <th>Jobcard ID</th>
                    <th>Upload Image</th>
                    <th>Edit</th>
                    <th>Delete</th>
                 
                    <th>
                        <label class="badge badge-gradient-info">
                            <input type="checkbox" class="select-checkbox" id="selectAll" />
                        </label>
                    </th>
                </tr>
            </thead>
            <tbody>
                @if ($clientinformation->isEmpty())
                    <tr>
                        <td colspan="8" class="text-center text-muted">No clients found.</td>
                    </tr>
                @else
                    @foreach($clientinformation as $key => $client)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $client->confirmid }}</td>
                            <td>{{ $client->jobcardid }}</td>

                            <!-- Image Upload Input -->
                            <td>
                                <input type="file" class="form-control w-50" name="images[{{ $client->jobcard_id }}]" accept="image/*" />
                                @if($client->image)
                                    <br>
                                    <img src="{{ asset('storage/uploads/' . $client->image) }}" width="100" height="80">
                                @endif
                            </td>

                            <td>
                                <label class="badge badge-gradient-warning">
                                    <a href="javascript:void(0);" data-bs-toggle="modal" 
                                       data-id="{{ $client->confirmid }}" data-uid="{{ $client->jobcard_id }}"    
                                       data-jobcardid="{{ $client->jobcardid }}"    
                                       data-service="{{ htmlentities($client->service) }}"   
                                       data-item="{{ htmlentities($client->item) }}"   
                                       data-gwt="{{ $client->grwt }}"    
                                       data-estwt="{{ $client->estwt }}"    
                                       data-metal="{{ $client->metal }}"    
                                       data-calrity="{{ $client->calrity }}"    
                                       data-color="{{ $client->color }}"    
                                       data-cut="{{ $client->cut }}"    
                                       data-big_j="{{ $client->big_j }}"    
                                       data-nol="{{ $client->nol }}"    
                                       data-image="{{ $client->image ?? '' }}"
                                       data-bs-target="#coBrandingModal" style="text-decoration: none;">Edit</a>
                                </label>
                            </td>

                            <td>
                                <label class="badge badge-gradient-danger">
                                    <a href="javascript:void(0);" 
                                       onclick="confirmDelete('{{ route('delete_job_card', $client->jobcard_id) }}')" 
                                       style="text-decoration: none;">Delete</a>
                                </label>
                            </td>

                            <td>
                                <label class="badge badge-gradient-info">
                                    <input type="checkbox" class="select-checkbox" name="jobcard_ids[]" value="{{ $client->jobcard_id }}" />
                                </label>
                            </td>
                        </tr>
                    @endforeach
                @endif    
            </tbody>
        </table>
        
        <!-- Final Submit Button -->
        <button type="submit" class="btn btn-primary mt-3">Upload Images</button>
    </div>
</form>




<div class="d-flex flex-wrap justify-content-end mt-3">
<button id="printSelected" class="btn btn-primary">Print Certificates</button>
</div>
<div class="d-flex flex-wrap justify-content-center mt-3">
    {{ $clientinformation->links('pagination::bootstrap-4') }}
</div>



<!-- model come here -->
<!-- Bootstrap Modal -->
<div class="modal fade" id="coBrandingModal" tabindex="-1" aria-labelledby="coBrandingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="coBrandingModalLabel">Edit </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updatejobcard_dimond" method="POST" action="{{route('update_job_card')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="jbno" class="form-label">Job card number :</label>
                        <input type="text" read class="form-control" id="jbno" name="jbno" required placeholder="Enter Job Card Number">
                        <input type="hidden" read class="form-control" id="uid" name="uid" required placeholder="Enter Job Card Number">
                    </div>

                    <div class="mb-3">
                        <label for="confno" class="form-label">Confiramation number :</label>
                        <input type="text" class="form-control" id="confno" name="confno" required placeholder="Enter Confirmation No">
                    </div>


                    @php
                        $services=\App\Models\service::get();
                        $items=\App\Models\itemtables::get();
                        $metals=\App\Models\metals::get();
                        $claritys=\App\Models\claritys::get();
                        $colors=\App\Models\colourtables::get();
                        $cuttables=\App\Models\cuttables::get();
                      // dd($Metal);
                    @endphp
                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Service :</label>
                        <select class="form-select" id="serviceSelect"  name="serviceSelect" required aria-label="Default select example">
                        <option >Open this select menu</option>
                            @foreach($services as $service)
                             
                       
                          
                            <option value="{{ $service->service_name }}">{{ $service->service_name }}</option>
                            </option>

                              @endforeach
                                </select>
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Item :</label>
                        <select class="form-select" id="itemSelect"   name="itemSelect" required aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                @foreach($items as $item)
                             
                       
                          
                             <option value="{{ $item->item_name }}">{{ $item->item_name }}</option>
                             </option>
 
                               @endforeach
                               
                                </select>
                    </div>

                    <div class="mb-3">
                        <label for="gwt" class="form-label">Gross Weight :</label>
                        <input type="text" class="form-control" id="gwt" name="gwt" required placeholder="Enter Gram Weight">
                    </div>

                    <div class="mb-3">
                        <label for="estet" class="form-label">Gross ESTET :</label>
                        <input type="text" class="form-control" id="estet" name="estet" required placeholder="Enter estet">
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Metal :</label>
                        <select class="form-select"  id="metalSelect" name="metalSelect" required aria-label="Default select example">
                                <option selected>Open this select menu</option>
                              @foreach($metals as $metal)
                              
                                <option value="{{ $metal->metal_id }}">{{ $metal->metal_name }}</option>
                              @endforeach
                                </select>
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Clarity :</label>
                        <select class="form-select" id="claritySelect"  name="claritySelect" required aria-label="Default select example">
                                <option selected>Open this select menu</option>

                                @foreach($claritys as $clarity)
                                      <option value="{{$clarity->calrity_id }}">{{$clarity->Clarity}}</option>
                                @endforeach
                                </select>
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Color :</label>
                        <select class="form-select" id="colorSelect"  name="colorSelect" required aria-label="Default select example">
                                <option selected>Open this select menu</option>
                              @foreach($colors as $colors)
                                <option value="{{$colors->color_id }}">{{$colors->color_code}}</option>
                              @endforeach
                                </select>
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Cut :</label>
                        <select class="form-select" id="cutSelect" name="cutSelect"  required aria-label="Default select example">
                                <option selected>Open this select menu</option>
                              
                              @foreach($cuttables as $cuttable)
                                <option value="{{$cuttable->cut_id }}">{{$cuttable->cutname}}</option>
                              @endforeach
                                </select>
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Big Certificate :</label>
                        <select class="form-select" id="bigSelect" name="bigSelect" required aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                <option value="0">Small</option>
                                <option value="1">Big</option>
                              
                                </select>
                    </div>

                    <div class="mb-3">
                        <label for="nol" class="form-label">No of Dimonds :</label>
                        <input type="text" class="form-control" name="nol" required id="nol" placeholder="Enter No of Dimonds">
                    </div>


                    <div class="mb-3">
                        <label for="imagePrev" class="form-label">Uploaded Image :</label>
                        
                        <img id="imagePreview" src="#" alt="Preview" style="max-width: 100px; display: non;"/>
                      
                     



                        <input type="file" class="form-control" name="imagePrev"  id="imagePrev" placeholder="Enter No of Dimonds">
                    </div>


                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- model close here -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>


    document.getElementById("imagePrev").addEventListener("change", function(event) {
    var file = event.target.files[0];

    if (file) {
        var reader = new FileReader();

        reader.onload = function(e) {
            var imgPreview = document.getElementById("imagePreview");
            imgPreview.src = e.target.result;
            imgPreview.style.display = "block"; // Show image
        };

        reader.readAsDataURL(file);
    }
});





    $(document).ready(function () {

        $('#printSelected').on('click', function () {
        let selectedIds = [];
        $('.select-checkbox:checked').each(function () {
            selectedIds.push($(this).val());
        });

        if (selectedIds.length === 0) {
            alert("Please select at least one job card to print.");
            return;
        }

        // Redirect to certificate print route with selected IDs
        let url = "{{ route('print_certificates') }}?ids=" + selectedIds.join(',');
        window.open(url, '_blank'); // Open in a new tab
    });



        $('#imagePrev').change(function(event) {
            let reader = new FileReader();

            reader.onload = function() {
                $('#imagePreview').attr('src', reader.result);
            };

            if (event.target.files.length > 0) {
                reader.readAsDataURL(event.target.files[0]); // Read new file
            }
        });


        $('#selectAll').on('click', function () {
            $('.select-checkbox').prop('checked', this.checked);
        });

        // Uncheck "Select All" if any checkbox is unchecked
        $('.select-checkbox').on('click', function () {
            if ($('.select-checkbox:checked').length === $('.select-checkbox').length) {
                $('#selectAll').prop('checked', true);
            } else {
                $('#selectAll').prop('checked', false);
            }
        });



        $('#coBrandingModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var id = button.data('id'); // Button that triggered the modal
            var imageUrl = button.data('image'); 
            if (imageUrl) {
                    $('#imagePreview').attr('src', '/storage/uploads/' + imageUrl);
                } else {
                    $('#imagePreview').attr('src', 'https://via.placeholder.com/150'); // Default image
                }

            var service1 = button.attr('data-service');
                    var Jobcardid = button.data('jobcardid'); 
                    var uid = button.data('uid'); 
                    // var service = button.data('service');    
                    var item = button.data('item');  
                    var gwt = button.data('gwt');  
                    var estwt = button.data('estwt');   
                    var  metal =button.data('metal');    
                    var calrity =button.data('calrity'); 
                    var color = button.data('color');    
                    var cut = button.data('cut');    
                    var big_j = button.data('big_j');    
                    var nol = button.data('nol');    
                    var imageUrl = button.data('image');

                    console.log("uid:", uid);
                  
                    console.log("Service from button:", button.data('service'));
            // Set the value inside the modal's input field or text
            $('#coBrandingModalLabel').text('Edit Confirmation - ' +id); // If it's an input field
            $('#clientNameDisplay').text(id); // If displaying in a <span>
            $('#jbno').val(Jobcardid); 
            $('#confno').val(id); 
            $('#gwt').val(gwt); 
            $('#estet').val(estwt); 
            $('#nol').val(nol); 
            $('#uid').val(uid); 
            // console.log("Available Options:", $("#metalSelect option").map(function() { return $(this).val(); }).get()); 
                        
            $('#serviceSelect').val(service1).trigger('change');
            $('#itemSelect').val(item).trigger('change');
           
            $('#metalSelect').val(metal).trigger('change'); 
            $('#claritySelect').val(calrity).trigger('change'); 
            $('#colorSelect').val(color).trigger('change'); 
            $('#cutSelect').val(cut).trigger('change'); 
            $('#bigSelect').val(big_j).trigger('change'); 

        });
    });
</script>




<script>
    function confirmDelete(deleteUrl) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = deleteUrl;
            }
        });
    }
</script>