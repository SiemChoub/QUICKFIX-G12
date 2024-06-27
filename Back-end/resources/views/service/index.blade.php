<x-app-layout>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">    
<div class="container mt-5">
    <div class="d-flex justify-content-between -mt-5 mb-3">
        <div class=" mb-2 shadow">
            @can('Service create')
                <a href="{{ route('admin.services.create') }}" class="btn btn-warning d-flex align-items-center">
                    <i class='bx bxs-plus-circle' style='font-size:30px'></i>
                    Create New
                </a>
            @endcan
        </div>
        <div class="w-60 bg-white rounded d-flex align-items-center shadow" style="height: 40px;">
            <div class="input-group h-100">
                <input type="text" class="form-control border-0 shadow-none h-100" placeholder="Search" aria-label="Search">
                <div class="input-group-append h-100">
                    <div class="btn bg-warning pt-2 h-100">
                        <i class='bx bx-search-alt'></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="bg-warning">
                <tr>
                    <th scope="col" class='text-center'>Service Name</th>
                    <th scope="col" class='text-center'>Description</th>
                    <th scrope='col' class='text-center'>Price</th>
                    <th scrope='col' class='text-center'>Category</th>
                    <th scope="col" class='text-center'>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example row, replace with dynamic content -->
                @can('Service access')
                @foreach ($services as $service)
                <tr>
                    <td class='text-center' style=" width=:5px; text-overf: ellipsis;">{{ $service->name }}</td>
                    <td class='text-center'>{{ $service->description }}</td>
                    <td class='text-center'>{{ $service->price }}$</td>
                    <td class='text-center'>Mazin fixer</td>
                    <td class="table-actions d-flex justify-content-around text-center">
                        <a class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#serviceDetailsModal"
                            data-service-image="https://i.pinimg.com/564x/ed/75/7f/ed757f7b67b716facd211f1733965417.jpg"
                            data-service-title="{{$service->name}}"
                            data-service-description="{{$service->description}}"
                            data-service-stars="999">
                            Details
                        </a>
                        @can('Service edit')
                            <a href="{{ route('admin.services.edit', $service->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        @endcan
                        @can('Service delete')
                            <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
                @endforeach
                @endcan
                <!-- Add more rows here -->
            </tbody>
        </table>
    </div>
    @can('Service access')
    <div class="text-right mt-6">
        {{ $services->links() }}
    </div>
    @endcan
</div>

<!-- -----------service detail------ -->
<div class="modal fade" id="serviceDetailsModal" tabindex="-1" aria-labelledby="serviceDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="serviceDetailsModalLabel">Service detail</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img src="" class="img-fluid rounded" alt="Service Image" id="service-image">
                    </div>
                    <div class="col-md-6">
                        <h4 class="text-warning" id="service-title">Premium Service</h4>
                        <p id="service-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ac diam at magna tempus volutpat.</p>
                        <p>Stars: <span id="service-stars"></span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap JS and Popper.js -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script>
    document.getElementById('serviceDetailsModal').addEventListener('show.bs.modal', function (event) {
        // Get the button that triggered the modal
        var button = event.relatedTarget;

        // Update the modal content with the data attributes
        document.getElementById('service-image').src = button.dataset.serviceImage;
        document.getElementById('service-title').textContent = button.dataset.serviceTitle;
        document.getElementById('service-description').textContent = button.dataset.serviceDescription;
        document.getElementById('service-stars').textContent = button.dataset.serviceStars;
    });
</script>
</x-app-layout>