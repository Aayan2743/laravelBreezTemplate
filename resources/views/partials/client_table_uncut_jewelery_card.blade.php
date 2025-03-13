<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th> S No </th>
                <th> Confiramation No</th>
                <th> Jobcard id </th>
                <th> Edit </th>
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
                <td>{{ $client->jobcardid }}</td>
                <td>{{ $client->image }}</td>

                <td><label class="badge badge-gradient-warning">
                    
             
                <a href="javascript:void(0);" data-bs-toggle="modal" data-id={{$client->jobcard_id}}
                    
                    data-jobcard_id={{$client->jobcard_id}}    
                    data-nol="{{$client->nol}}"    
                    data-dia="{{$client->dia}}"    
                    data-jobcardid={{$client->jobcardid}}    
                    data-confirmid={{$client->confirmid}}    
                    data-service= "{{ $client->service }}"   
                    data-dia= "{{ $client->dia }}"   
                    data-item="{{ html_entity_decode($client->item)}}"   
                    data-grwt={{$client->grwt}}   
                    data-estwt={{$client->estwt}}   
                    data-metal={{$client->metal}}   
                    data-calrity={{$client->calrity}}   
                    data-color={{$client->color}}   
                    data-cut={{$client->cut}}   
                    data-nol={{$client->nol}}   
                   
                  
                    data-image="{{ $client->image ?? '' }}"
                
                data-bs-target="#coBrandingModal2" style="text-decoration: none;">Edit</a></label></td>
               
                <td>
                    <label class="badge badge-gradient-danger">
                        <a href="javascript:void(0);" 
                        onclick="confirmDelete('{{ route('uncut_jewelery_job_card_delete', $client->jobcard_id ) }}')" 
                        style="text-decoration: none;">Delete</a>
                    </label>
                </td>

               
                <td>
                    <label class="badge badge-gradient-info">
                        <input type="checkbox" class="select-checkbox" name="jobcard_ids[]"  value="{{ $client->jobcard_id  }}" />
                    </label>
                </td>

            </tr>
            @endforeach
        @endif    
        </tbody>
    </table>

   
</div>
<div class="d-flex flex-wrap justify-content-end mt-3">
<button id="printSelected" class="btn btn-primary">Print Certificates</button>
</div>
<div class="d-flex flex-wrap justify-content-center mt-3">
    {{ $clientinformation->links('pagination::bootstrap-4') }}
</div>



<!-- model come here -->
<!-- Bootstrap Modal -->
<div class="modal fade" id="coBrandingModal2" tabindex="-1" aria-labelledby="coBrandingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="coBrandingModalLabel">Edit  Un Cut Jewelery Job Card</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updatejobcard_dimond" method="POST" action="{{route('update_uncut_jewelery_card')}}" enctype="multipart/form-data">
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
                        <input type="hidden" read class="form-control text-muted" id="jobcard_id" name="jobcard_id" readOnly  required placeholder="Enter Job Card Number">
                        <input type="text" read class="form-control" id="jobcardid" name="jobcardid" required placeholder="Enter Job Card Number">
                    </div>

                    <div class="mb-3">
                        <label for="confno" class="form-label">Confiramation number :</label>
                        <input type="text" class="form-control text-muted" id="confirmid" readOnly name="confirmid" required placeholder="Enter Confirmation No">
                    </div>

                    <div class="mb-3">
                        <label for="confno" class="form-label">Service Name:</label>
                        <input type="text" class="form-control text-muted" id="service" readOnly name="service" required placeholder="Enter Service">
                    </div>

                    <div class="mb-3">
                        <label for="confno" class="form-label">Min Purity:</label>
                        <input type="text" class="form-control text-muted" id="dia" readOnly name="dia" required placeholder="Enter Service">
                    </div>

                    
                    
                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Item Name :</label>
                        <select class="form-select" id="item"   name="item" required aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                @foreach($items as $item)
                             
                             <option value="{{ $item->item_name}}">{{ $item->item_name }}</option>
                             </option>
 
                               @endforeach
                               
                                </select>
                    </div> 
                      
                    <div class="mb-3">
                        <label for="confno" class="form-label">Gram Wt:</label>
                        <input type="text" class="form-control text-muted" id="grwt"  name="grwt" required placeholder="Enter grwt">
                    </div>

                    <div class="mb-3">
                        <label for="confno" class="form-label">Estwt Wt:</label>
                        <input type="text" class="form-control text-muted" id="estwt"  name="estwt" required placeholder="Enter estwt">
                    </div>

                    
                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Metal Name :</label>
                        <select class="form-select" id="metal"   name="metal" required aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                @foreach($metals as $item)
                             
                             <option value="{{ $item->metal_id}}">{{ $item->code }}</option>
                             </option>
 
                               @endforeach
                               
                                </select>
                    </div> 


                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Clarity Name :</label>
                        <select class="form-select" id="calrity"   name="calrity" required aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                @foreach($claritys as $item)
                             
                             <option value="{{$item->calrity_id}}">{{ $item->Clarity }}</option>
                             </option>
 
                               @endforeach
                               
                                </select>
                    </div> 


                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Color Name :</label>
                        <select class="form-select" id="color"   name="color" required aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                @foreach($colors as $item)
                             
                             <option value="{{ $item->color_id }}">{{ $item->color_code }}</option>
                             </option>
 
                               @endforeach
                               
                                </select>
                    </div> 



                  

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Cut Name :</label>
                        <select class="form-select" id="cut"   name="cut" required aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                @foreach($cuttables as $item)
                             
                             <option value="{{ $item->cut_id   }}">{{ $item->code }}</option>
                             </option>
 
                               @endforeach
                               
                                </select>
                    </div> 



                   

                   

                    <div class="mb-3">
                        <label for="gwt" class="form-label">Nol  :</label>
                        <input type="text" class="form-control" id="nol" name="nol"  placeholder="Enter Species">
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
        let url = "{{ route('print_uncut_jewelery_certificates') }}?ids=" + selectedIds.join(',');
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



        $('#coBrandingModal2').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var jobcard_id = button.data('jobcard_id'); // Button that triggered the modal
           // Button that triggered the modal
            var imageUrl = button.data('image'); 
            if (imageUrl) {
                    $('#imagePreview').attr('src', '/storage/uploads/' + imageUrl);
                } else {
                    $('#imagePreview').attr('src', 'https://via.placeholder.com/150'); // Default image
                }

                    
                    var jobcardid = button.data('jobcardid'); 
                    var confirmid = button.data('confirmid'); 
                    var service = button.data('service'); 
                     var item = button.data('item');    
                     var grwt = button.data('grwt');    
                     var estwt = button.data('estwt');    
                     var metal = button.data('metal');    
                     var calrity = button.data('calrity');    
                     var color = button.data('color');    
                     var cut = button.data('cut');    
                     var conc = button.data('conc');    
                     var conc1 = button.data('conc1');    
                     var nol = button.data('nol');    
                     var dia = button.data('dia');    


                     console.log(item);
                    

                // textbox all
                $('#jobcard_id').val(jobcard_id); 
                $('#jobcardid').val(jobcardid); 
                $('#confirmid').val(confirmid); 
                $('#service').val(service); 
                $('#dia').val(dia); 

                $('#grwt').val(grwt); 
                $('#estwt').val(estwt); 
                // $('#metal').val(metal); 
                // $('#cut').val(cut); 
                $('#conc').val(conc); 
                $('#conc1').val(conc1); 
                $('#nol').val(nol); 
                
                
                console.log("metal",metal);
                console.log("calrity",calrity);
                
                // select options
                $('#item').val(item).trigger('change');
                $('#cut').val(cut).trigger('change');
                $('#metal').val(metal).trigger('change');
                $('#calrity').val(calrity).trigger('change');
                $('#color').val(color).trigger('change');
                

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