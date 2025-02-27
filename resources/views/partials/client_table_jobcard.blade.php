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
                <th> Action -2 </th>
            </tr>
        </thead>
        <tbody>
        @if ($clientinformation->isEmpty())
                <tr>
                    <td colspan="5" class="text-center text-muted">No clients found.</td>
                </tr>
        @else   

            @foreach($clientinformation as $key=> $client)
            <tr>
                <td>{{ $key+1}}</td>
                <td>{{ $client->confirmid }}</td>
                <td>{{ $client->jobcardid }}</td>

                <td><label class="badge badge-gradient-warning">
                    
             
                <a href="javascript:void(0);" data-bs-toggle="modal" data-id={{$client->confirmid}} data-bs-target="#coBrandingModal" style="text-decoration: none;">Edit</a></label></td>
                <td><label class="badge badge-gradient-danger"><a href="javascript:void(0);" onclick="confirmDelete('')"  style="text-decoration: none;">Delete</a></label></td>
               
                <td><label class="badge badge-gradient-info"><a href="#" style="text-decoration: none;">Confirm Order </a></label></td>
            </tr>
            @endforeach
        @endif    
        </tbody>
    </table>
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
                <form id="coBrandingForm">
                    
                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Job card number :</label>
                        <input type="text" class="form-control" id="coBrandingText" placeholder="Enter Co-branding Name">
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Confiramation number :</label>
                        <input type="text" class="form-control" id="coBrandingText" placeholder="Enter Co-branding Name">
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Service :</label>
                        <select class="form-select" aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                                </select>
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Item :</label>
                        <select class="form-select" aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                                </select>
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Gross Weight :</label>
                        <input type="text" class="form-control" id="coBrandingText" placeholder="Enter Co-branding Name">
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Gross ESTET :</label>
                        <input type="text" class="form-control" id="coBrandingText" placeholder="Enter Co-branding Name">
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Metal :</label>
                        <select class="form-select" aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                                </select>
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Clarity :</label>
                        <select class="form-select" aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                                </select>
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Color :</label>
                        <select class="form-select" aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                                </select>
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Cut :</label>
                        <select class="form-select" aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                                </select>
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Big Certificate :</label>
                        <select class="form-select" aria-label="Default select example">
                                <option selected>Open this select menu</option>
                                <option value="1">One</option>
                                <option value="2">Two</option>
                                <option value="3">Three</option>
                                </select>
                    </div>

                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">No of Dimonds :</label>
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
            var button = $(event.relatedTarget);
            var id = button.data('id'); // Button that triggered the modal
          // Extract info from data-ds-name
                    console.log(id);
            // Set the value inside the modal's input field or text
            $('#coBrandingModalLabel').text('Edit Confirmation - ' +id); // If it's an input field
            $('#clientNameDisplay').text(id); // If displaying in a <span>
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