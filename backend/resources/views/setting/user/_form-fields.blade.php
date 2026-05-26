{{-- Shared user form fields, used by both the Create and Edit modals on the index page.
     Wrap in a <form> and pass: $uid ('create'/'edit'), $mode ('create'/'edit'), $roles.
     Create mode shows the password fields and requires a profile photo; edit mode omits both.
     The Edit modal renders this empty and fills values via JS from the row's data-* attributes. --}}
@php
    $uid  = $uid  ?? 'create';
    $mode = $mode ?? 'create';
    $genericAvatar = 'https://ui-avatars.com/api/?name=User&background=f59e0b&color=fff&bold=true';
@endphp

<div class="quser-form__avatar">
    <img id="{{ $uid }}-profile-preview" src="{{ $genericAvatar }}" alt="Profile photo"
         class="quser-form__avatar-img"
         onerror="this.onerror=null;this.src='{{ $genericAvatar }}'">
    <div class="quser-form__avatar-body">
        <label for="{{ $uid }}-profile">Profile photo</label>
        <input id="{{ $uid }}-profile" type="file" name="profile" accept="image/*"
               class="quser-form__file" data-preview="{{ $uid }}-profile-preview"
               @if($mode === 'create') required @endif>
        <p class="quser-form__hint">JPG or PNG, up to 2&nbsp;MB.@if($mode === 'edit') Leave empty to keep the current photo.@endif</p>
        @error('profile')<span class="quser-field__error">{{ $message }}</span>@enderror
    </div>
</div>

<div class="quser-field">
    <label for="{{ $uid }}-name">Name</label>
    <input id="{{ $uid }}-name" type="text" name="name" value="{{ old('name') }}" placeholder="Enter name" required>
    @error('name')<span class="quser-field__error">{{ $message }}</span>@enderror
</div>

<div class="quser-field">
    <label for="{{ $uid }}-email">Email</label>
    <input id="{{ $uid }}-email" type="email" name="email" value="{{ old('email') }}" placeholder="Enter email" required>
    @error('email')<span class="quser-field__error">{{ $message }}</span>@enderror
</div>

<div class="quser-field-row">
    <div class="quser-field">
        <label for="{{ $uid }}-phone">Phone</label>
        <input id="{{ $uid }}-phone" type="text" name="phone" value="{{ old('phone') }}" placeholder="Enter phone">
        @error('phone')<span class="quser-field__error">{{ $message }}</span>@enderror
    </div>
    <div class="quser-field">
        <label for="{{ $uid }}-address">Address</label>
        <input id="{{ $uid }}-address" type="text" name="address" value="{{ old('address') }}" placeholder="Enter address" @if($mode === 'create') required @endif>
        @error('address')<span class="quser-field__error">{{ $message }}</span>@enderror
    </div>
</div>

<div class="quser-field">
    <label for="{{ $uid }}-role">Role</label>
    <select id="{{ $uid }}-role" name="role" required>
        <option value="">Select a role</option>
        @foreach($roles as $role)
            <option value="{{ $role->name }}">{{ $role->name }}</option>
        @endforeach
    </select>
    @error('role')<span class="quser-field__error">{{ $message }}</span>@enderror
</div>

@if($mode === 'create')
<div class="quser-field-row">
    <div class="quser-field">
        <label for="{{ $uid }}-password">Password</label>
        <input id="{{ $uid }}-password" type="password" name="password" placeholder="Enter password" required>
        @error('password')<span class="quser-field__error">{{ $message }}</span>@enderror
    </div>
    <div class="quser-field">
        <label for="{{ $uid }}-password_confirmation">Confirm Password</label>
        <input id="{{ $uid }}-password_confirmation" type="password" name="password_confirmation" placeholder="Confirm password" required>
    </div>
</div>
<label class="quser-form__showpass">
    <input type="checkbox" onchange="
        const t = this.checked ? 'text' : 'password';
        document.getElementById('{{ $uid }}-password').type = t;
        document.getElementById('{{ $uid }}-password_confirmation').type = t;">
    Show password
</label>
@endif
