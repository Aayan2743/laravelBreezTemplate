<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th> Client Id </th>
                <th> 	Co Branding Text </th>
                <th> Logo </th>
                
                <th> Delete </th>
                <th> Edit </th>
            </tr>
        </thead>
        <tbody>
        @if ($cobranding->isEmpty())
                <tr>
                    <td colspan="5" class="text-center text-muted">No Co Branding Data Available for this client.</td>
                </tr>
        @else   

            @foreach($cobranding as $client)
            <tr>
                <td>{{ $client->client_id}}</td>
                <td>{{ $client->logotext }}</td>
                <td><img src="{{ asset('storage/'. $client->logoname) }}" /> </td>
               
                
                <td><label class="badge badge-gradient-danger"><a href="javascript:void(0);" onclick="confirmDeleteCobranding('{{ route('cobrandingDelete', $client->id) }}')"  style="text-decoration: none;">Delete</a></label></td>
                <td><label class="badge badge-gradient-warning"><a href="javascript:void(0);" 
                data-bs-toggle="modal" 
                data-ds-cobrandingId="{{$client->id}}" 
                 data-ds-cobrandingImage="{{$client->logoname}}"
                 
                   data-ds-cobrandingText="{{$client->logotext}}"  
                   data-bs-target="#editCobranding" 
                   style="text-decoration: none;">Edit </a></label></td>
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
<div class="modal fade" id="coBrandingModal" tabindex="-1" aria-labelledby="coBrandingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="coBrandingModalLabel"> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               
                <form id="coBrandingForm" action="{{ route('brandingStore') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="mb-3">
                        <label for="coBrandingImage" class="form-label">Upload Image</label>
                        <input type="file" class="form-control" name="coBrandingImage" id="coBrandingImage" required accept="image/*" onchange="previewImage(event)">
                    </div>

                    <div class="mb-3">
                       
                        <img id="imagePreview" src="#" class="form-control" style="display:none"  >
                    </div>
                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Enter Text</label>
                        <input type="text" class="form-control" name="coBrandingText" id="coBrandingText" required placeholder="Enter Co-branding Name">
                        <input type="hidden" class="form-control" name="clinetID" id="clinetID" placeholder="Enter Co-branding Name">
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

<div class="modal fade" id="editCobranding" tabindex="-1" aria-labelledby="editCobrandingLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCobrandingLabel"> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               
                <form id="coBrandingForm" action="{{ route('brandingupdate') }}" method="POST" enctype="multipart/form-data">
                @csrf
                    <div class="mb-3">
                        <label for="coBrandingImageEdit" class="form-label">Upload Image</label>
                        <input type="file" class="form-control" name="coBrandingImageEdit" id="coBrandingImageEdit"  accept="image/*" onchange="EditpreviewImage(event)">
                    </div>

                    <div class="mb-3">
                       
                        <img id="imagePreview1" src="#" class="form-control" style="display:non"  >
                    </div>
                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Enter Text</label>
                        <input type="text" class="form-control" name="coBrandingEditText" id="coBrandingEditText" required placeholder="Enter Co-branding Name">
                        <input type="hidden" class="form-control" name="clinetEditID" id="clinetEditID" placeholder="Enter Co-branding Name">
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


             document.getElementById('editCobranding').addEventListener('show.bs.modal', function(event) {
                let button = event.relatedTarget; // The button that triggered the modal
                
                let cobrandingText = button.getAttribute('data-ds-cobrandingText'); 
                let cobrandingImage = button.getAttribute('data-ds-cobrandingimage'); 
                let cobrandingId = button.getAttribute('data-ds-cobrandingId'); 

                $('#coBrandingEditText').val(cobrandingText);
                $('#clinetEditID').val(cobrandingId);
                
              

                console.log("Image Path:", cobrandingText); // Debugging to check value

                var imagePreview = document.getElementById('imagePreview1');

                if (cobrandingImage) {
                    imagePreview.src = "{{ asset('storage') }}/" + cobrandingImage;
                    imagePreview.style.display = "block"; // Show image when available
                } else {
                    imagePreview.src = "#"; // Reset image if no valid path
                    imagePreview.style.display = "none"; // Hide if no image
                }    


                
               
                
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