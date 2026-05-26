<x-app-layout>
  @include('partials._form-styles')

  <div class="qf-form-page">
    <div class="qf-form-head">
      <a href="{{ route('admin.categories.index') }}" class="qf-back-btn">
        <i class="bx bx-arrow-back"></i> Back
      </a>
      <h1 class="qf-form-head__title"><i class='bx bx-category'></i> Edit category</h1>
    </div>

    <form method="POST" action="{{ route('admin.categories.update', $category->id) }}" enctype="multipart/form-data" class="qf-card">
      @csrf
      @method('put')
      <div class="qf-fields">
        @include('partials.image-field', ['current' => $category->image, 'name' => 'image', 'label' => 'Category image'])

        <div class="qf-field">
          <label for="name" class="qf-label">Name</label>
          <input id="name" type="text" name="name" value="{{ old('name', $category->name) }}" placeholder="Enter category name" class="qf-input" required>
          @error('name')<span class="qf-field__error">{{ $message }}</span>@enderror
        </div>

        <div class="qf-field">
          <label for="description" class="qf-label">Description</label>
          <textarea id="description" name="description" rows="3" placeholder="Enter description" class="qf-input">{{ old('description', $category->description) }}</textarea>
          @error('description')<span class="qf-field__error">{{ $message }}</span>@enderror
        </div>
      </div>

      <div class="qf-form-actions">
        <button type="submit" class="qf-submit-btn">Save changes <i class='bx bx-right-arrow-alt'></i></button>
      </div>
    </form>
  </div>
</x-app-layout>
