{{-- Reusable image upload field with thumbnail preview.
     Usage: @include('partials.image-field', ['current' => $model->image, 'name' => 'image', 'label' => 'Image']) --}}
@php
    $name    = $name ?? 'image';
    $label   = $label ?? 'Image';
    $current = $current ?? null;
@endphp

<div class="qf-img-upload">
    <div class="qf-img-upload__thumb" id="qfThumb_{{ $name }}">
        @if ($current)
            <img src="{{ $current }}" alt="{{ $label }}">
        @else
            <i class='bx bx-image-add'></i>
        @endif
    </div>
    <div class="qf-img-upload__body">
        <label for="{{ $name }}" class="text-gray-700 font-medium text-sm">{{ $label }}</label>
        <input id="{{ $name }}" type="file" name="{{ $name }}" accept="image/*"
               class="qf-img-upload__input" data-thumb="qfThumb_{{ $name }}">
        <p class="qf-img-upload__hint">JPG or PNG, up to 2&nbsp;MB.@if ($current) Leave empty to keep the current image.@endif</p>
        @error($name)<span class="text-red-500 text-xs">{{ $message }}</span>@enderror
    </div>
</div>

<style>
    .qf-img-upload { display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem; }
    .qf-img-upload__thumb {
        width: 88px; height: 88px; border-radius: 12px; overflow: hidden;
        display: grid; place-items: center; background: #f3f4f6;
        border: 2px dashed #d1d5db; flex: 0 0 auto;
    }
    .qf-img-upload__thumb img { width: 100%; height: 100%; object-fit: cover; }
    .qf-img-upload__thumb i { font-size: 2rem; color: #9ca3af; }
    .qf-img-upload__body { display: flex; flex-direction: column; gap: .25rem; }
    .qf-img-upload__input { font-size: .85rem; color: #4b5563; }
    .qf-img-upload__input::file-selector-button {
        margin-right: .6rem; padding: .4rem .8rem; border: 0; border-radius: 8px;
        background: #ffc107; color: #1b1f24; font-weight: 600; font-size: .82rem; cursor: pointer;
        transition: filter .15s ease;
    }
    .qf-img-upload__input::file-selector-button:hover { filter: brightness(.95); }
    .qf-img-upload__hint { font-size: .72rem; color: #9ca3af; margin: 0; }
</style>

<script>
    (function () {
        document.querySelectorAll('input[type=file][data-thumb]').forEach(function (inp) {
            if (inp.dataset.bound) return;
            inp.dataset.bound = '1';
            inp.addEventListener('change', function (e) {
                const file = e.target.files[0];
                if (!file) return;
                const thumb = document.getElementById(inp.dataset.thumb);
                if (!thumb) return;
                let img = thumb.querySelector('img');
                if (!img) { thumb.innerHTML = ''; img = document.createElement('img'); thumb.appendChild(img); }
                img.src = URL.createObjectURL(file);
            });
        });
    })();
</script>
