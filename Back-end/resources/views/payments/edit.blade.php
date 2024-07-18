<x-app-layout>
    <div class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-200">
        <div class="container mx-auto px-4 mt-4 py-1 pb-16">
            <a href="{{ route('admin.payments.index') }}"
                class="btn btn-warning shadow d-flex align-items-center border -mt-3 mb-2 border-none w-20">
                <i class="bx bx-arrow-back me-2"></i>
                Back
            </a>
            <div class="bg-white shadow-md rounded my-6 p-4">
                <form method="POST" action="{{ route('admin.payments.update', $payment->id) }}" class="col">
                    @csrf
                    @method('put')
                    <div class=" w-100 d-flex gap-3">
                        <div class="mb-4 w-50">
                            <label for="price" class="block text-warning-700 font-medium mb-1">Price</label>
                            <input id="price" type="number" name="price"
                                value="{{ old('price', $payment->price) }}" placeholder="Enter price"
                                class="w-full border border-warning-300 rounded-md py-2 px-3 focus:outline-none focus:border-warning-500 focus:ring-1 focus:ring-warning-500" />
                        </div>
                        <div class="mb-4 w-50">
                            <label for="deadline" class="block text-warning-700 font-medium mb-1">Deadline</label>
                            <input id="deadline" type="date" name="deadline"
                                value="{{ old('deadline', $payment->deadline) }}" placeholder="Enter deadline"
                                class="w-full border border-warning-300 rounded-md py-2 px-3 focus:outline-none focus:border-warning-500 focus:ring-1 focus:ring-warning-500" />
                        </div>
                    </div>
                    <div>
                        <label for="description" class="block text-warning-700 font-medium mb-1">Description</label>
                        <textarea name="description" id="description" placeholder="Enter description"
                            class="w-full px-3 py-1 rounded-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-200 text-sm"
                            rows="3">{{ old('description', $payment->description) }}</textarea>
                    </div>
                    <div class="text-center mt-6 mb-6">
                        <button type="submit"
                            class="bg-warning shadow hover:bg-warning-600 font-medium py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-warning-500 focus:ring-opacity-50 transition-colors">
                            <svg class="w-4 h-4 mr-2 inline-block" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Include Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</x-app-layout>
