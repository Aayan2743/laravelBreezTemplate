<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th> Client Id </th>
                <th> Client Name </th>
                <th> Supplier </th>
                <th> Add Co-branding </th>
                <th> Delete </th>
                <th> Edit </th>
            </tr>
        </thead>
        <tbody>
        @if ($clientinformation->isEmpty())
                <tr>
                    <td colspan="5" class="text-center text-muted">No clients found.</td>
                </tr>
        @else   

            @foreach($clientinformation as $client)
            <tr>
                <td>{{ $client->client_id}}</td>
                <td>{{ $client->client_name }}</td>
                <td>{{ $client->supplier }}</td>
                <td><label class="badge badge-gradient-success"><a href="#" style="text-decoration: none;">Add Co-branding</a></label></td>
                <td><label class="badge badge-gradient-danger"><a href="javascript:void(0);" onclick="confirmDelete('{{ route('clients.deleteClientById', $client->client_id) }}')"  style="text-decoration: none;">Delete</a></label></td>
                <td><label class="badge badge-gradient-warning"><a href="{{route('clients.viewClientById',$client->client_id)}}" style="text-decoration: none;">Edit</a></label></td>
            </tr>
            @endforeach
        @endif    
        </tbody>
    </table>
</div>

<div class="d-flex flex-wrap justify-content-center mt-3">
    {{ $clientinformation->links('pagination::bootstrap-4') }}
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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