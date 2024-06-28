<x-app-layout>
<link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">    
<div class="container mt-5">
    <div class="d-flex justify-content-between -mt-5 mb-3">
        <div class=" mb-2 shadow">
            @can('Category create')
                <a href="{{ route('admin.categories.create') }}" class="btn btn-warning d-flex align-items-center">
                    <i class='bx bxs-plus-circle' style='font-size:30px'></i>
                    Create New
                </a>
            @endcan
        </div>
        <h4 class='shadow text-center p-2 border around-50'>CATEGORY MANAGEMNT</h4>
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
                    <th scope="col" class='text-center'>Category Name</th>
                    <th scope="col" class='text-center'>Description</th>
                    <th scope="col" class='text-center'>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example row, replace with dynamic content -->
                @can('Category access')
                @foreach ($categories as $category)
                <tr>
                    <td class='text-center' style=" width=:5px; text-overf: ellipsis;">{{ $category->name }}</td>
                    <td class='text-center' style=" width=:5px; text-overf: ellipsis;">{{ $category->description }}</td>
                    <td class="table-actions d-flex justify-content-around text-center">
                        <a class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#categoryDetailsModal"
                            data-category-image="https://i.pinimg.com/564x/ed/75/7f/ed757f7b67b716facd211f1733965417.jpg"
                            data-category-title="{{$category->name}}"
                            data-category-description="kkkkkkkkk"
                            data-category-stars="999">
                            Details
                        </a>
                        @can('Category edit')
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        @endcan
                        @can('Category delete')
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" class="d-inline">
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
    @can('Category access')
    <div class="text-right mt-6">
        {{ $categories->links() }}
    </div>
    @endcan
</div>

<!-- -----------category detail------ -->
<div class="modal fade" id="categoryDetailsModal" tabindex="-1" aria-labelledby="categoryDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="categoryDetailsModalLabel">Category detail</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <img src="" class="img-fluid rounded" alt="category Image" id="category-image">
                    </div>
                    <div class="col-md-6">
                        <h4 class="text-warning" id="category-title">Premium category</h4>
                        <p id="category-description">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ac diam at magna tempus volutpat.</p>
                        <p>Stars: <span id="category-stars"></span></p>
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
    document.getElementById('categoryDetailsModal').addEventListener('show.bs.modal', function (event) {
        // Get the button that triggered the modal
        var button = event.relatedTarget;

        // Update the modal content with the data attributes
        document.getElementById('category-image').src = button.dataset.categoryImage;
        document.getElementById('category-title').textContent = button.dataset.categoryTitle;
        document.getElementById('category-description').textContent = button.dataset.categoryDescription;
        document.getElementById('category-stars').textContent = button.dataset.categoryStars;
    });
</script>
</x-app-layout>