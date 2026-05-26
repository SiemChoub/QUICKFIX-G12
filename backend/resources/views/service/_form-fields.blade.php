{{-- Shared service form fields, used by both the Create and Edit modals on the index page.
     Wrap in a <form> and pass a unique $uid ('create' / 'edit') plus $categories.
     The Edit modal renders this empty and fills the values via JS from the row's data-* attributes. --}}
@php $uid = $uid ?? 'create'; @endphp

@include('partials.image-field', ['current' => null, 'name' => 'image', 'label' => 'Service image', 'uid' => $uid . '-image'])

<div class="qsvc-field">
    <label for="{{ $uid }}-name">Name</label>
    <input id="{{ $uid }}-name" type="text" name="name" value="{{ old('name') }}" placeholder="Enter service name" required>
    @error('name')<span class="qsvc-field__error">{{ $message }}</span>@enderror
</div>

<div class="qsvc-field">
    <label for="{{ $uid }}-description">Description</label>
    <textarea id="{{ $uid }}-description" name="description" rows="3" placeholder="Enter description">{{ old('description') }}</textarea>
    @error('description')<span class="qsvc-field__error">{{ $message }}</span>@enderror
</div>

<div class="qsvc-field-row">
    <div class="qsvc-field">
        <label for="{{ $uid }}-price">Price ($)</label>
        <input id="{{ $uid }}-price" type="number" step="0.01" min="0" name="price" value="{{ old('price') }}" placeholder="0.00">
        @error('price')<span class="qsvc-field__error">{{ $message }}</span>@enderror
    </div>
    <div class="qsvc-field">
        <label for="{{ $uid }}-category_id">Category</label>
        @if (count($categories) > 0)
            <select id="{{ $uid }}-category_id" name="category_id" required>
                <option value="">Select a category</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                @endforeach
            </select>
        @else
            <p class="qsvc-field__note">No categories yet — <a href="{{ route('admin.categories.create') }}">create one first</a>.</p>
        @endif
        @error('category_id')<span class="qsvc-field__error">{{ $message }}</span>@enderror
    </div>
</div>
