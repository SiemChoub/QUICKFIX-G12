{{-- Shared discount form fields, used by both the Create and Edit modals on the index page.
     Wrap in a <form> and pass a unique $uid ('create' / 'edit').
     The Edit modal renders this empty and fills the values via JS from the row's data-* attributes. --}}
@php $uid = $uid ?? 'create'; @endphp

<div class="qdisc-field">
    <label for="{{ $uid }}-discount">Discount (%)</label>
    <input id="{{ $uid }}-discount" type="number" name="discount" min="0" max="100"
           value="{{ old('discount') }}" placeholder="e.g. 25" required>
    @error('discount')<span class="qdisc-field__error">{{ $message }}</span>@enderror
</div>
<div class="qdisc-field">
    <label for="{{ $uid }}-description">Description</label>
    <textarea id="{{ $uid }}-description" name="description" rows="3"
              placeholder="Enter description">{{ old('description') }}</textarea>
    @error('description')<span class="qdisc-field__error">{{ $message }}</span>@enderror
</div>
<div class="qdisc-field-row">
    <div class="qdisc-field">
        <label for="{{ $uid }}-start_date">Start Date</label>
        <input id="{{ $uid }}-start_date" type="date" name="start_date" value="{{ old('start_date') }}">
        @error('start_date')<span class="qdisc-field__error">{{ $message }}</span>@enderror
    </div>
    <div class="qdisc-field">
        <label for="{{ $uid }}-end_date">End Date</label>
        <input id="{{ $uid }}-end_date" type="date" name="end_date" value="{{ old('end_date') }}">
        @error('end_date')<span class="qdisc-field__error">{{ $message }}</span>@enderror
    </div>
</div>
