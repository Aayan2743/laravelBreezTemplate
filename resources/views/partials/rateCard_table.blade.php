<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th> S No </th>
                <th> Service Name </th>
               
               
                <th> Range </th>
                <th> weight </th>
                <th> Rate </th>
                <th> ext </th>
                <th> Edit </th>
            </tr>
        </thead>
        <tbody>
        @if ($rateCards->isEmpty())
                <tr>
                    <td colspan="5" class="text-center text-muted">No Data</td>
                </tr>
        @else   

            @foreach($rateCards as $key=> $client)
            <tr>
                <td>{{$key+1}}</td>
                <td>{{ $client->service_type_name ?? 'No Service Type' }}</td>
                <td>{{ $client->caratwt }}</td>
                <td>{{ $client->wt }}</td>
                <td>{{ $client->rate }}</td>
                <td>{{ $client->ext }}</td>
                 <td><label class="badge badge-gradient-warning"><a href="javascript:void(0);" 
                data-bs-toggle="modal" 
                data-ds-serviceID="{{$client->ratecard_id   }}" 
                 data-ds-serviceName="{{$client->service_type_name}}"
                 data-ds-caratwt="{{$client->caratwt}}"
                 data-ds-wt="{{$client->wt}}"
                 data-ds-rate="{{$client->rate}}"
                 data-ds-ext="{{$client->ext}}"
                 
                 
                   data-bs-target="#editRateCard" 
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
 <!-- coBrandingModal -->
<div class="modal fade" id="addNewService" tabindex="-1" aria-labelledby="coBrandingModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="coBrandingModalLabel"> </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               
                <form id="coBrandingForm" action="{{ route('listserviceStore') }}" method="POST" enctype="multipart/form-data">
                @csrf
                   

                   
                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Enter Service Name</label>
                        <input type="text" class="form-control" name="serviceName" id="serviceName" required placeholder="Enter Service Name">
                       
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
               
                <form id="coBrandingForm" action="{{ route('rateCardUpdate') }}" method="POST" enctype="multipart/form-data">
                @csrf
                   

                  
                    <div class="mb-3">
                        <label for="coBrandingText" class="form-label">Enter Service Name</label>
                        <input type="text" class="form-control text-muted" readonly name="serviceNameTxt" required id="serviceNameTxt" required placeholder="Enter Co-branding Name">
                        <input type="hidden" class="form-control" name="serviceIddata" id="serviceIddata" placeholder="Enter Co-branding Name">
                    </div>
                     
                    <div class="mb-3">
                        <label for="range" class="form-label">Enter Weight Range</label>
                        <input type="text" class="form-control" name="range" required id="range" required placeholder="Enter Range">
                       
                    </div>

                    <div class="mb-3">
                        <label for="range" class="form-label">Enter Weight </label>
                        <input type="text" class="form-control" name="weight" required id="weight" required placeholder="Enter weight">
                       
                    </div>

                    <div class="mb-3">
                        <label for="range" class="form-label">Enter Rate </label>
                        <input type="text" class="form-control" name="rate" required id="rate" required placeholder="Enter rate">
                       
                    </div>

                    <div class="mb-3">
                        <label for="range" class="form-label">Enter Ext </label>
                        <input type="text" class="form-control" name="ext" required id="ext" required placeholder="Enter ext">
                       
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
                
                let serviceName = button.getAttribute('data-ds-serviceName'); 
                let serviceID = button.getAttribute('data-ds-serviceID'); 
                let caratwt = button.getAttribute('data-ds-caratwt'); 
                let wt = button.getAttribute('data-ds-wt'); 
                let rate = button.getAttribute('data-ds-rate'); 
                let ext = button.getAttribute('data-ds-ext'); 


                // data-ds-caratwt="{{$client->caratwt}}"
                //  data-ds-wt="{{$client->wt}}"
                //  data-ds-rate="{{$client->rate}}"
                //  data-ds-ext="{{$client->ext}}"

                $('#serviceNameTxt').val(serviceName);
                $('#serviceIddata').val(serviceID);
                $('#range').val(caratwt);
                $('#weight').val(wt);
                $('#rate').val(rate);
                $('#ext').val(ext);
                
              

              

              

                
               
                
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