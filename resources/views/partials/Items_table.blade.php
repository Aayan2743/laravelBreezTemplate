<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th> S No </th>
                <th> Item Name </th>
                <th> Item Code </th>
                <th> Edit </th>
                <th> Delete </th>
            </tr>
        </thead>
        <tbody>
        @if ($data->isEmpty())
                <tr>
                    <td colspan="5" class="text-center text-muted">No Data</td>
                </tr>
        @else   

            @foreach($data as $key=> $client)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{ $client->item_name ?? 'No Data' }}</td>
                <td>{{ $client->item_code ?? 'No Data' }}</td>
               
                 <td><label class="badge badge-gradient-warning"><a href="javascript:void(0);" 
                    data-bs-toggle="modal" 
                    data-item_id="{{$client->item_id}}" 
                    data-item_name="{{$client->item_name}}"
                    data-item_code="{{$client->item_code}}"
                    
                    
                 
                   data-bs-target="#editRateCard" 
                   style="text-decoration: none;">Edit </a></label></td>

                  
                   <td>
                    <label class="badge badge-gradient-danger">
                        <a href="javascript:void(0);" 
                        onclick="confirmDelete('{{ route('item_delete', $client->item_id ) }}')" 
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
               
                <form id="coBrandingForm" action="{{ route('store_item') }}" method="POST" >
                @csrf
                   

                   
                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Enter Item Name</label>
                        <input type="text" class="form-control" name="item_name" id="item_name" required placeholder="Enter Clarity Name">
                     
                       
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Enter Code</label>
                        <input type="text" class="form-control" name="item_code" id="item_code" required placeholder="Enter Item Code">
                     
                       
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
<div class="modal fade" id="editRateCard" tabindex="-1" aria-labelledby="editCobrandingLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCobrandingLabel"> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               
                <form id="coBrandingForm" action="{{ route('items.update') }}" method="POST">
                @csrf
                   

                  
                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Enter Item Name</label>
                        <input type="text" class="form-control"  name="item_name" required id="item_name" required placeholder="Enter Name">
                        <input type="hidden" class="form-control" name="item_id" readonly id="item_id" placeholder="Enter Co-branding Name">
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Enter Code</label>
                        <input type="text" class="form-control"  name="item_code" required id="item_code" required placeholder="Enter item_code">
                       
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


             document.getElementById('editRateCard').addEventListener('show.bs.modal', function(event) {
                let button = event.relatedTarget; // The button that triggered the modal
                
                let item_id = button.getAttribute('data-item_id'); 
                let item_name = button.getAttribute('data-item_name'); 
                let item_code = button.getAttribute('data-item_code'); 
                console.log("clarity",Clarity);


                $('#item_id').val(item_id);
                $('#item_name').val(item_name);
                $('#item_code').val(item_code);
             
                
              

              

              

                
               
                
                // Example: Set the image in the modal\
               
               
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