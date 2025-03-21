<div class="table-responsive">


    <table class="table">
        <thead>
            <tr>
                <th> S No  </th>
                <th> Date </th>
                <th> Confirmation ID </th>
                <th> Clientname</th>
                <th> Received Name</th>
                <th> Invoice</th>
                <th> Invoice With Logo </th>
                <th> Extra Charges </th>
                <th> Get Memo </th>
                <th> Download File </th>
            </tr>
        </thead>
        <tbody>
        @if ($confirmentrysdetails->isEmpty())
                <tr>
                    <td colspan="5" class="text-center text-muted">No Confirmations found.</td>
                </tr>
        @else   

            @foreach($confirmentrysdetails as $key=>$client)
            <tr>
                <td>{{  $key+1}}</td>
                <td>{{ $client->recievedate}}</td>
                <td>{{ $client->confirmationid }}</td>
                <td>{{ $client->client_name }}</td>
             
                <td>{{ $client->reciever }}</td>
                <td><label class="badge badge-gradient-danger"><a href="{{route('getReport.id',$client->confirmationid)}}"   style="text-decoration: none;">Invoice {{$client->confirmationid}}</a></label></td>
                <td><label class="badge badge-gradient-danger"><a href="javascript:void(0);"   style="text-decoration: none;">Invoice With Logo</a></label></td>
                <td><label class="badge badge-gradient-danger"><a href="javascript:void(0);"   style="text-decoration: none;">Add Extra Charges</a></label></td>
                <td><label class="badge badge-gradient-danger"><a href="javascript:void(0);"   style="text-decoration: none;">Cash Memo</a></label></td>
                <td><label class="badge badge-gradient-danger"><a href="javascript:void(0);"   style="text-decoration: none;">Download</a></label></td>
               
                
            </tr>
            @endforeach
        @endif    
        </tbody>
    </table>
</div>

<div class="d-flex flex-wrap justify-content-center mt-3">
    {{ $confirmentrysdetails->links('pagination::bootstrap-4') }}
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
                <form id="coBrandingForm">
                    <div class="mb-3">
                        <label for="coBrandingImage" class="form-label">Upload Image</label>
                        <input type="file" class="form-control" id="coBrandingImage" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Enter Text</label>
                        <input type="text" class="form-control" id="coBrandingText" placeholder="Enter Co-branding Name">
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
                
            // Set the value inside the modal's input field or text
            $('#coBrandingModalLabel').text('Add Co-branding for - ' +clientName); // If it's an input field
            $('#clientNameDisplay').text(clientName); // If displaying in a <span>
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