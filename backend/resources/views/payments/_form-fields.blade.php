{{-- Shared payment form fields, used by both the Create and Edit modals on the index page.
     Wrap in a <form> and pass a unique $uid ('create' / 'edit').
     The Edit modal renders this empty and fills the values via JS from the card's data-* attributes. --}}
@php $uid = $uid ?? 'create'; @endphp

<div class="qpay-field-row">
    <div class="qpay-field">
        <label for="{{ $uid }}-amount">Amount / Rate ($)</label>
        <input id="{{ $uid }}-amount" type="number" step="0.01" min="0" name="amount"
               value="{{ old('amount') }}" placeholder="Enter amount per fix" required>
        @error('amount')<span class="qpay-field__error">{{ $message }}</span>@enderror
    </div>
    <div class="qpay-field">
        <label for="{{ $uid }}-datepay">Pay Date</label>
        <input id="{{ $uid }}-datepay" type="date" name="datepay" value="{{ old('datepay') }}">
        @error('datepay')<span class="qpay-field__error">{{ $message }}</span>@enderror
    </div>
    <div class="qpay-field">
        <label for="{{ $uid }}-dateline">Deadline</label>
        <input id="{{ $uid }}-dateline" type="date" name="dateline" value="{{ old('dateline') }}">
        @error('dateline')<span class="qpay-field__error">{{ $message }}</span>@enderror
    </div>
</div>

<div class="qpay-field">
    <label for="{{ $uid }}-description">Description</label>
    <textarea id="{{ $uid }}-description" name="description" rows="2" placeholder="Enter description">{{ old('description') }}</textarea>
    @error('description')<span class="qpay-field__error">{{ $message }}</span>@enderror
</div>
