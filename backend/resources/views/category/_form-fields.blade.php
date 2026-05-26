{{-- Shared category form fields, used by both the Create and Edit modals on the index page.
     Wrap in a <form> and pass a unique $uid ('create' / 'edit').
     The Edit modal renders this empty and fills the values via JS from the row's data-* attributes. --}}
@php $uid = $uid ?? 'create'; @endphp

@include('partials.image-field', ['current' => null, 'name' => 'image', 'label' => 'Category image', 'uid' => $uid . '-image'])

<div class="qcat-field">
    <label for="{{ $uid }}-name">Name</label>
    <input id="{{ $uid }}-name" type="text" name="name" value="{{ old('name') }}" placeholder="Enter category name" required>
    @error('name')<span class="qcat-field__error">{{ $message }}</span>@enderror
</div>

<div class="qcat-field">
    <label for="{{ $uid }}-description">Description</label>
    <textarea id="{{ $uid }}-description" name="description" rows="3" placeholder="Enter description">{{ old('description') }}</textarea>
    @error('description')<span class="qcat-field__error">{{ $message }}</span>@enderror
</div>
