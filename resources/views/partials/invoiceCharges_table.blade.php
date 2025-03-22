<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th> S No </th>
                <th> Confirmation Number </th>
                <th> Service </th>
                <th> Price </th>
                <th> Extra Comment </th>
               
               
                <th> Edit </th>
                <th> Delete </th>
            </tr>
        </thead>
        <tbody>
        @if ($get_charges->isEmpty())
                <tr>
                    <td colspan="5" class="text-center text-muted">No Data</td>
                </tr>
        @else   

            @foreach($get_charges as $key=> $client)
          
          
            <tr>
                <td>{{$key+1}}</td>
                <td>{{ $client->confirmid }}</td>
                <td>{{ $client->serviceName->servicetypes_names }}</td>
                <td>{{ $client->price }}</td>
                <td>{{ $client->extra_comment }}</td>
              
               
               
                <td><label class="badge badge-gradient-warning"><a href="javascript:void(0);" 
                        data-bs-toggle="modal" 
                        data-ds-id="{{$client->id }}" 
                        data-ds-price="{{$client->price }}" 
                        data-ds-servicetypes_names="{{$client->serviceName->servicetypes_names}}"
                        data-ds-serviceId="{{$client->serviceName->servicetypes_id}}"
                        data-ds-extra_comment="{{$client->extra_comment}}"
                        
                 
                   data-bs-target="#editService" 
                   style="text-decoration: none;">Edit </a></label></td>
                
                   <td>
                    <label class="badge badge-gradient-danger">
                        <a href="javascript:void(0);" 
                        onclick="confirmDelete('{{ route('deleteExtraAmount', $client->id ) }}')" 
                        style="text-decoration: none;">Delete</a>
                    </label>
               

                   </td>
              
            </tr>
            @endforeach
        @endif    
        </tbody>
    </table>
</div>

<div class="d-flex flex-wrap justify-content-center mt-3">
   
</div>



<!-- model come here -->
<!-- Bootstrap Modal -->
 <!-- coBrandingModal -->
<div class="modal fade" id="addNewService" tabindex="-1" aria-labelledby="coBrandingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="coBrandingModalLabel"> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               
                <form id="coBrandingForm" action="{{ route('addExtraAmount') }}" method="POST" enctype="multipart/form-data">
                @csrf
                   

                   
                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Select Service</label>
                        <select class="form-select" name="Service" id="Service" required>
                        <option value="" selected>Select Service</option>
                            @foreach($servicetype as $type)
                                <option value="{{$type->servicetypes_id }}">{{$type->servicetypes_names}}</option>
                             @endforeach                               
                              </select>
                       
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Confirmation No</label>
                        <input type="text" id="confirmationNo" class="form-control" required value={{$confirmationNo}} name="confirmationNo" readonly />
                       
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Price </label>
                        <input type="number" id="Price" class="form-control" required  name="Price"  />
                       
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Comments </label>
                        <input type="text" id="comments" class="form-control" required  name="comments"  />
                       
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

<!-- editCobranding -->
<div class="modal fade" id="editService" tabindex="-1" aria-labelledby="editCobrandingLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCobrandingLabel"> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               
                <form id="coBrandingForm" action="{{ route('updateExtraAmount') }}" method="POST" >
                @csrf
                   

                  
                <div class="mb-3">
                        <label for="Service" class="form-label">Select Service Name</label>
                        
                        <select class="form-select" name="Services" id="Services" required>
                            <option value="" selected>Select Service</option>
                            @foreach($servicetype as $type)
                                <option value="{{ $type->servicetypes_id }}">
                                    {{ $type->servicetypes_names }}
                                </option>
                            @endforeach
                        </select>
                        



                        <input type="hidden" class="form-control" name="uid" id="uid">
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Confirmation No</label>
                        <input type="text" id="confirmationNo" class="form-control" required value={{$confirmationNo}} name="confirmationNo" readonly />
                       
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Price </label>
                        <input type="text" id="EPrice" class="form-control" required  name="EPrice"  />
                       
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Comments </label>
                        <input type="text" id="Ecomments" class="form-control" required  name="Ecomments"  />
                       
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
    $(document).ready(function () {
        $('#coBrandingModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var clientName = button.data('ds-name'); // Extract info from data-ds-name
            var clinetIds = button.data('ds-cid'); // Extract info from data-ds-name
              

            // Set the value inside the modal's input field or text
            $('#coBrandingModalLabel').text('Add Co-branding for - ' +clientName); // If it's an input field
            $('#clinetID').val(clinetIds); // If it's an input field
            $('#clientNameDisplay').text(clientName); // If displaying in a <span>
        });


             document.getElementById('editService').addEventListener('show.bs.modal', function(event) {
                let button = event.relatedTarget; // The button that triggered the modal
                
                let id = button.getAttribute('data-ds-id'); 
                let price = button.getAttribute('data-ds-price'); 
                let servicetypes_names = button.getAttribute('data-ds-servicetypes_names'); 
                let servicetypes_id = button.getAttribute('data-ds-serviceId'); 
                
                let extra_comment = button.getAttribute('data-ds-extra_comment'); 

                console.log(servicetypes_id );

                // Assigning values correctly
                $('#uid').val(id);
                $('#EPrice').val(price);  // ✅ Fix: Use `price` instead of `Price`
                $('#Ecomments').val(extra_comment); 
             
                $('#Services').val(servicetypes_id).trigger('change');
               
              

              

              

                
               
                
                // Example: Set the image in the modal\
               
               
            });


            document.addEventListener('DOMContentLoaded', function() {
    let serviceDropdown = document.getElementById('Service');
    let hiddenInput = document.getElementById('uid');

    // Set hidden input value on page load (for edit mode)
    let selectedOption = serviceDropdown.options[serviceDropdown.selectedIndex];
    if (selectedOption) {
        hiddenInput.value = selectedOption.getAttribute('data-servicename');
    }

    // Update hidden input when user selects a different service
    serviceDropdown.addEventListener('change', function() {
        let selectedOption = this.options[this.selectedIndex];
        hiddenInput.value = selectedOption.getAttribute('data-servicename');
    });
});


      

    });
</script>

<script>
    function previewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('imagePreview');
            output.src = reader.result;
            output.style.display = "block";
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    function EditpreviewImage(event) {
        var reader = new FileReader();
        reader.onload = function(){
            var output = document.getElementById('imagePreview1');
            output.src = reader.result;
            output.style.display = "block";
        };
        reader.readAsDataURL(event.target.files[0]);
    }
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

    function confirmDeleteCobranding(deleteUrl) {
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