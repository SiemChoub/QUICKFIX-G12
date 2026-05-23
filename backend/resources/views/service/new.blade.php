<x-app-layout>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  @include('partials._form-styles')

  <div class="qf-form-page">
    <div class="qf-form-head">
      <a href="{{ route('admin.services.index') }}" class="qf-back-btn">
        <i class="bx bx-arrow-back"></i> Back
      </a>
      <h1 class="qf-form-head__title"><i class='bx bx-briefcase'></i> Create service</h1>
    </div>

    <form method="POST" action="{{ route('admin.services.store') }}" enctype="multipart/form-data" class="qf-card">
      @csrf
      <div class="qf-fields">
        @include('partials.image-field', ['current' => null, 'name' => 'image', 'label' => 'Service image'])

        <div class="qf-field">
          <label for="name" class="qf-label">Name</label>
          <input id="name" type="text" name="name" value="{{ old('name') }}" placeholder="Enter service name" class="qf-input" required>
          @error('name')<span class="qf-field__error">{{ $message }}</span>@enderror
        </div>

        <div class="qf-field">
          <label for="description" class="qf-label">Description</label>
          <textarea id="description" name="description" rows="3" placeholder="Enter description" class="qf-input">{{ old('description') }}</textarea>
          @error('description')<span class="qf-field__error">{{ $message }}</span>@enderror
        </div>

        <div class="qf-grid">
          <div class="qf-field">
            <label for="price" class="qf-label">Price</label>
            <input id="price" type="number" step="0.01" name="price" value="{{ old('price') }}" placeholder="0.00" class="qf-input">
            @error('price')<span class="qf-field__error">{{ $message }}</span>@enderror
          </div>

          <div class="qf-field">
            <label for="category_id" class="qf-label">Category</label>
            @if (count($categories) > 0)
              <select id="category_id" name="category_id" class="qf-input" required>
                <option value="">Select a category</option>
                @foreach ($categories as $category)
                  <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
              </select>
            @else
              <p class="text-sm text-gray-500 m-0">No categories yet — <a href="{{ route('admin.categories.create') }}" class="text-warning">create one first</a>.</p>
            @endif
            @error('category_id')<span class="qf-field__error">{{ $message }}</span>@enderror
          </div>
        </div>
      </div>

      <div class="qf-form-actions">
        <button type="submit" class="qf-submit-btn">Save service <i class='bx bx-right-arrow-alt'></i></button>
      </div>
    </form>
  </div>
</x-app-layout>
