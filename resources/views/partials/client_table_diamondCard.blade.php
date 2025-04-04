@if (session()->has('totalRecords'))
    <div class="alert alert-success">
        <strong>Total Records:</strong> {{ session('totalRecords') }}<br>
        <strong>Inserted Records:</strong> {{ session('totalInserted') }}<br>
        <strong>Skipped Records:</strong> {{ session('totalSkipped') }}
    </div>
@endif


<form action="{{ route('upload_diamond_images') }}" method="POST" enctype="multipart/form-data">
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
                <td>{{ $client->djobcardid }}</td>
                <td>
                                <input type="file" class="form-control w-50" name="images[{{ $client->djobcard_id}}]" accept="image/*" required />
                                @if($client->image)
                                    <br>
                                    <img src="{{ asset('storage/uploads/' . $client->image) }}" width="100" height="80">
                                @endif
                            </td>


                <td><label class="badge badge-gradient-warning">
                    
             
                <a href="javascript:void(0);" data-bs-toggle="modal" data-id={{$client->djobcard_id }}
                    
                    data-djobcard_id={{$client->djobcard_id}}    
                    data-djobcardid={{$client->djobcardid}}    
                    data-confirmid={{$client->confirmid}}    
                    data-service= "{{ htmlentities($client->service) }}"   
                    data-nop={{$client->nop}}   
                    data-cut={{$client->cut}}   
                    data-carat={{$client->carat}}   
                    data-measure={{$client->measure}}   
                    data-clarity={{$client->clarity}}   
                    data-color={{$client->color}}   
                    data-florosense={{$client->florosense}}   
                    data-finish={{$client->finish}}   
                    data-tble={{$client->tble}}   
                    data-crown={{$client->crown}}   
                    data-pavilion={{$client->pavilion}}   
                    data-culet={{$client->culet}}   
                    data-girdle={{$client->girdle}}   
                    data-big_d={{$client->big_d}}   
                    
                    

                    data-image="{{ $client->image ?? '' }}"
                
                data-bs-target="#coBrandingModal1" style="text-decoration: none;">Edit</a></label></td>
               
                <td>
                    <label class="badge badge-gradient-danger">
                        <a href="javascript:void(0);" 
                        onclick="confirmDelete('{{ route('diamond_job_card_delete', $client->djobcard_id) }}')" 
                        style="text-decoration: none;">Delete</a>
                    </label>
                </td>

               
                <td>
                    <label class="badge badge-gradient-info">
                        <input type="checkbox" class="select-checkbox" name="jobcard_ids[]"  value="{{ $client->djobcard_id }}" />
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
                <form id="updatejobcard_dimond" method="POST" action="{{route('update_diamond_card')}}" enctype="multipart/form-data">
                    @csrf

                    @php
                        $services=\App\Models\service::get();
                        $servicetype1=\App\Models\servicetype::get();
                        $servicetype=\App\Models\servicetype::get();
                        $items=\App\Models\itemtables::get();
                        $metals=\App\Models\metals::get();
                        $claritys=\App\Models\claritys::get();
                        $colors=\App\Models\colourtables::get();
                        $cuttables=\App\Models\cuttables::get();
                      // dd($Metal);
                    @endphp
                    <div class="mb-3">
                        <label for="jbno" class="form-label">Diamond Job card number : :</label>
                        <input type="hidden" read class="form-control text-muted" id="djobcard_id1" name="djobcard_id1" readOnly  required placeholder="Enter Job Card Number">
                        <input type="text" read class="form-control" id="djobcardid" name="djobcardid" required placeholder="Enter Job Card Number">
                    </div>

                    <div class="mb-3">
                        <label for="confno" class="form-label">Confiramation number :</label>
                        <input type="text" class="form-control text-muted" id="confirmid" readOnly name="confirmid" required placeholder="Enter Confirmation No">
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Service Name :</label>
                        <select class="form-select" id="service"   name="service" required aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                @foreach($servicetype1 as $item)
                             
                             <option value="{{ $item->servicetypes_names  }}">{{ $item->servicetypes_names }}</option>
                             </option>
 
                               @endforeach
                               
                                </select>
                    </div> 
                    
                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Cut Name :</label>
                        <select class="form-select" id="cut"   name="cut" required aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                @foreach($cuttables as $item)
                             
                             <option value="{{ $item->cut_id  }}">{{ $item->cutname }}</option>
                             </option>
 
                               @endforeach
                               
                                </select>
                    </div> 

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Clarity Name :</label>
                        <select class="form-select" id="clarity"   name="clarity" required aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                @foreach($claritys as $item)
                             
                             <option value="{{ $item->calrity_id  }}">{{ $item->Clarity }}</option>
                             </option>
 
                               @endforeach
                               
                                </select>
                    </div> 

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Color Name :</label>
                        <select class="form-select" id="color"   name="color" required aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                @foreach($colors as $item)
                             
                             <option value="{{ $item->color_id  }}">{{ $item->color_code }}</option>
                             </option>
 
                               @endforeach
                               
                                </select>
                    </div> 



                    <div class="mb-3">
                        <label for="confno" class="form-label">Carat  :</label>
                        <input type="text" class="form-control text-muted" id="carat" name="carat"  required placeholder="Enter Service Name">
                    </div>

                    <div class="mb-3">
                        <label for="gwt" class="form-label">Nop  :</label>
                        <input type="text" class="form-control" id="nop" name="nop" required placeholder="Enter Species">
                    </div>

                    <div class="mb-3">
                        <label for="gwt" class="form-label">measure  :</label>
                        <input type="text" class="form-control" id="measure" name="measure" required placeholder="Enter Variety">
                    </div>

                    <div class="mb-3">
                        <label for="gwt" class="form-label">florosence  :</label>
                        <input type="text" class="form-control" id="florosense" name="florosense" required placeholder="Enter carat">
                    </div>

                    <div class="mb-3">
                        <label for="gwt" class="form-label">finish  :</label>
                        <input type="text" class="form-control" id="finish" name="finish" required placeholder="Enter measure">
                    </div>

                    <div class="mb-3">
                        <label for="gwt" class="form-label">table  :</label>
                        <input type="text" class="form-control" id="tble" name="tble" required placeholder="Enter transperancy">
                    </div>


                    <div class="mb-3">
                        <label for="gwt" class="form-label">crown   :</label>
                        <input type="text" class="form-control" id="crown" name="crown" required placeholder="Enter transperancy">
                    </div>

                    <div class="mb-3">
                        <label for="gwt" class="form-label">pavilion   :</label>
                        <input type="text" class="form-control" id="pavilion" name="pavilion" required placeholder="Enter transperancy">
                    </div>

                    <div class="mb-3">
                        <label for="gwt" class="form-label">culet    :</label>
                        <input type="text" class="form-control" id="culet" name="culet" required placeholder="Enter transperancy">
                    </div>

                    <div class="mb-3">
                        <label for="gwt" class="form-label">girdle    :</label>
                        <input type="text" class="form-control" id="girdle" name="girdle" required placeholder="Enter transperancy">
                    </div>

                    <div class="mb-3">
                        <label for="gwt" class="form-label">Certificate Type    :</label>
                        <input type="text" class="form-control" id="big_d" name="big_d" required placeholder="Enter transperancy">
                    </div>

<!-- transperancy -->
                  
                   

                   
                 

                   


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
        let url = "{{ route('print_diamond_certificates') }}?ids=" + selectedIds.join(',');
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
            var djobcard_id = button.data('djobcard_id'); // Button that triggered the modal
           // Button that triggered the modal
            var imageUrl = button.data('image'); 
            if (imageUrl) {
                    $('#imagePreview').attr('src', '/storage/uploads/' + imageUrl);
                } else {
                    $('#imagePreview').attr('src', 'https://via.placeholder.com/150'); // Default image
                }

                    
                    var confirmid = button.data('confirmid'); 
                    var djobcardid = button.data('djobcardid'); 
                    var service = button.data('service'); 
                     var nop = button.data('nop');    
                     var cut = button.data('cut');    
                     var carat = button.data('carat');    
                     var measure = button.data('measure');    
                     var clarity = button.data('clarity');    
                     var color = button.data('color');    
                     var florosense = button.data('florosense');    
                     var finish = button.data('finish');    
                     var tble = button.data('tble');    
                     var crown = button.data('crown');    
                     var pavilion = button.data('pavilion');    
                     var culet = button.data('culet');    
                     var girdle = button.data('girdle');    
                    var big_d = button.data('big_d');  
                    

                // textbox all
                $('#confirmid').val(confirmid); 
                $('#carat').val(carat); 
                $('#nop').val(nop); 
                $('#measure').val(measure); 
                $('#florosense').val(florosense); 
                $('#finish').val(finish); 
                $('#tble').val(tble); 
                $('#crown').val(crown); 
                $('#pavilion').val(pavilion); 
                $('#culet').val(culet); 
                $('#girdle').val(girdle); 
                $('#big_d').val(big_d); 
                $('#djobcard_id1').val(djobcard_id); 
                $('#djobcardid').val(djobcardid); 
                

                console.log("dfkjsdfj",djobcardid);
                // select options
                $('#service').val(service).trigger('change');
                $('#cut').val(cut).trigger('change');
                $('#clarity').val(clarity).trigger('change');
                $('#color').val(color).trigger('change');
            // Set the value inside the modal's input field or text
            // $('#coBrandingModalLabel').text('Edit Confirmation - ' +id); // If it's an input field
            // $('#clientNameDisplay').text(id); // If displaying in a <span>
            // $('#jbno').val(Jobcardid); 
            // $('#confno').val(id); 
            // // $('#serviceName').val(service); 
            // $('#species').val(species); 
            // $('#variety').val(variety); 
            // $('#carat').val(carat); 
            // $('#measure').val(measure); 
            // $('#transperancy').val(transperancy); 
            // // $('#gwt').val(gwt); 
            // // $('#estet').val(estwt); 
            // // $('#nol').val(nol); 
            // $('#uid').val(uid); 
            // // console.log("Available Options:", $("#metalSelect option").map(function() { return $(this).val(); }).get()); 
                        
            // $('#shape').val(shape).trigger('change');
            // $('#serviceid').val(service).trigger('change');
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