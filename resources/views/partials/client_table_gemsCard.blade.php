@if (session()->has('totalRecords'))
    <div class="alert alert-success">
        <strong>Total Records:</strong> {{ session('totalRecords') }}<br>
        <strong>Inserted Records:</strong> {{ session('totalInserted') }}<br>
        <strong>Skipped Records:</strong> {{ session('totalSkipped') }}
    </div>
@endif


<form action="{{ route('upload_gem_images') }}" method="POST" enctype="multipart/form-data">
    @csrf

<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th> S No </th>
                <th> Confiramation No</th>
                <th> Jobcard id </th>
                <th> Upload Image </th>
                <th> Delete </th>
           
                <th> Action -1 </th>
                <th>
                <label class="badge badge-gradient-info">
                        <input type="checkbox" class="select-checkbox" id="selectAll"  />
                    </label>    
                
               </th>
            </tr>
        </thead>
        <tbody>
        @if ($clientinformation->isEmpty())
                <tr>
                    <td colspan="5" class="text-center text-muted">No Data found.</td>
                </tr>
        @else   

            @foreach($clientinformation as $key=> $client)
            <tr>
                <td>{{ $key+1}}</td>
                <td>{{ $client->confirmid }}</td>
                <td>{{ $client->gjobcardid }}</td>
                 
                

                            <!-- Image Upload Input -->
                            <td>
                                <input type="file" class="form-control w-50" name="images[{{ $client->gjobcard_id }}]" accept="image/*" required />
                                @if($client->image)
                                    <br>
                                    <img src="{{ asset('storage/uploads/' . $client->image) }}" width="100" height="80">
                                @endif
                            </td>



                <td><label class="badge badge-gradient-warning">
                    
             
                <a href="javascript:void(0);" data-bs-toggle="modal" data-id={{$client->confirmid}}
                    
                    data-uid={{$client->gjobcard_id}}    
                    data-Jobcardid={{$client->gjobcardid}}    
                    data-service= "{{ htmlentities($client->service) }}"   
                    data-species={{$client->species}}   
                    data-variety="{{htmlentities($client->variety)}}"   
                    data-item= "{{ htmlentities($client->item) }}"   
                    data-shape="{{$client->shape }}"   
                    data-carat="{{$client->carat }}"   
                    data-measure="{{$client->measure }}"   
                    data-transperancy="{{$client->transperancy }}"   
                    

                    data-image="{{ $client->image ?? '' }}"
                
                data-bs-target="#coBrandingModal1" style="text-decoration: none;">Edit</a></label></td>
               
                <td>
                    <label class="badge badge-gradient-danger">
                        <a href="javascript:void(0);" 
                        onclick="confirmDelete('{{ route('gemcard_job_card_delete', $client->gjobcard_id ) }}')" 
                        style="text-decoration: none;">Delete</a>
                    </label>
                </td>

               
                <td>
                    <label class="badge badge-gradient-info">
                        <input type="checkbox" class="select-checkbox" name="jobcard_ids[]"  value="{{ $client->gjobcard_id }}" />
                    </label>
                </td>

            </tr>
            @endforeach
        @endif    
        </tbody>
    </table>
    
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
<div class="modal fade" id="coBrandingModal1" tabindex="-1" aria-labelledby="coBrandingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="coBrandingModalLabel">Edit </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updatejobcard_dimond" method="POST" action="{{route('update_gems_card')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="jbno" class="form-label">Gem Job card number : :</label>
                        <input type="text" read class="form-control text-muted" id="jbno" name="jbno" readOnly  required placeholder="Enter Job Card Number">
                        <input type="hidden" read class="form-control" id="uid" name="uid" required placeholder="Enter Job Card Number">
                    </div>

                    <div class="mb-3">
                        <label for="confno" class="form-label">Confiramation number :</label>
                        <input type="text" class="form-control text-muted" id="confno" readOnly name="confno" required placeholder="Enter Confirmation No">
                    </div>


                    <div class="mb-3">
                        <label for="confno" class="form-label">Service Name :</label>
                        <input type="text" class="form-control text-muted" id="serviceName" name="serviceName" readOnly required placeholder="Enter Service Name">
                    </div>

                    <div class="mb-3">
                        <label for="gwt" class="form-label">Species  :</label>
                        <input type="text" class="form-control" id="species" name="species" required placeholder="Enter Species">
                    </div>

                    <div class="mb-3">
                        <label for="gwt" class="form-label">Variety :</label>
                        <input type="text" class="form-control" id="variety" name="variety" required placeholder="Enter Variety">
                    </div>

                    <div class="mb-3">
                        <label for="gwt" class="form-label">Carat :</label>
                        <input type="text" class="form-control" id="carat" name="carat" required placeholder="Enter carat">
                    </div>

                    <div class="mb-3">
                        <label for="gwt" class="form-label">Measure :</label>
                        <input type="text" class="form-control" id="measure" name="measure" required placeholder="Enter measure">
                    </div>

                    <div class="mb-3">
                        <label for="gwt" class="form-label">Transperancy :</label>
                        <input type="text" class="form-control" id="transperancy" name="transperancy" required placeholder="Enter transperancy">
                    </div>

<!-- transperancy -->
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
                        <label for="coBrandingText" class="form-label">Cut :</label>
                        <select class="form-select" id="shape"   name="shape" required aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                @foreach($cuttables as $item)
                             
                       
                          
                             <option value="{{ $item->cut_id  }}">{{ $item->code }}</option>
                             </option>
 
                               @endforeach
                               
                                </select>
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
        let url = "{{ route('print_gems_certificates') }}?ids=" + selectedIds.join(',');
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



        $('#coBrandingModal1').on('show.bs.modal', function (event) {
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
                     var service = button.data('service');    
                     var species = button.data('species');    
                     var variety = button.data('variety');    
                     var shape = button.data('shape');    
                     var carat = button.data('carat');    
                     var measure = button.data('measure');    
                     var transperancy = button.data('transperancy');    
                    var item = button.data('item');  
                    // var gwt = button.data('gwt');  
                    // var estwt = button.data('estwt');   
                    // var  metal =button.data('metal');    
                    // var calrity =button.data('calrity'); 
                    // var color = button.data('color');    
                    // var cut = button.data('cut');    
                    // var big_j = button.data('big_j');    
                    // var nol = button.data('nol');    
                    // var imageUrl = button.data('image');

                    console.log("uid:", uid);
                  
                    console.log("Service from button:", button.data('shape'));
            // Set the value inside the modal's input field or text
            $('#coBrandingModalLabel').text('Edit Confirmation - ' +id); // If it's an input field
            $('#clientNameDisplay').text(id); // If displaying in a <span>
            $('#jbno').val(Jobcardid); 
            $('#confno').val(id); 
            $('#serviceName').val(service); 
            $('#species').val(species); 
            $('#variety').val(variety); 
            $('#carat').val(carat); 
            $('#measure').val(measure); 
            $('#transperancy').val(transperancy); 
            // $('#gwt').val(gwt); 
            // $('#estet').val(estwt); 
            // $('#nol').val(nol); 
            $('#uid').val(uid); 
            // console.log("Available Options:", $("#metalSelect option").map(function() { return $(this).val(); }).get()); 
                        
            $('#shape').val(shape).trigger('change');
            // $('#serviceSelect').val(service1).trigger('change');
            // $('#itemSelect').val(item).trigger('change');
           
            // $('#metalSelect').val(metal).trigger('change'); 
            // $('#claritySelect').val(calrity).trigger('change'); 
            // $('#colorSelect').val(color).trigger('change'); 
            // $('#cutSelect').val(cut).trigger('change'); 
            // $('#bigSelect').val(big_j).trigger('change'); 

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