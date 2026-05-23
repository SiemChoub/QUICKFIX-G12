{{-- Pagination bar with a page-size selector.
     Usage: @include('booking._pagination', ['paginator' => $somePaginator]) --}}
@php
    $allowed = [5, 10, 20, 50, 100];
    $perPage = (int) request('per_page', 10);
    if (!in_array($perPage, $allowed)) { $perPage = 10; }
@endphp

@if ($paginator->total() > 0)
<div class="qf-pager">
    <form method="GET" class="qf-pager__perpage">
        {{-- Preserve any other query params (e.g. filters); reset to page 1 on change --}}
        @foreach (request()->except(['per_page', 'page']) as $key => $val)
            <input type="hidden" name="{{ $key }}" value="{{ $val }}">
        @endforeach
        <label for="perPageSelect">Show</label>
        <select id="perPageSelect" name="per_page" class="form-select form-select-sm" onchange="this.form.submit()">
            @foreach ($allowed as $opt)
                <option value="{{ $opt }}" {{ $perPage === $opt ? 'selected' : '' }}>{{ $opt }}</option>
            @endforeach
        </select>
        <span class="qf-pager__info">
            {{ $paginator->firstItem() ?? 0 }}–{{ $paginator->lastItem() ?? 0 }} of {{ $paginator->total() }}
        </span>
    </form>

    <div class="qf-pager__links">
        {{ $paginator->onEachSide(1)->links() }}
    </div>
</div>
@endif

<style>
    .qf-pager {
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 1rem; padding-top: 1rem; margin-top: .5rem;
        border-top: 1px solid #eef0f3;
    }
    .qf-pager__perpage { display: flex; align-items: center; gap: .5rem; margin: 0; }
    .qf-pager__perpage label { font-size: .82rem; color: #6b7280; margin: 0; font-weight: 600; }
    .qf-pager__perpage .form-select { width: auto; min-width: 72px; }
    .qf-pager__info { font-size: .8rem; color: #9aa1ab; margin-left: .25rem; }
    .qf-pager__links nav, .qf-pager__links .pagination { margin: 0; }
    /* Amber active page to match the QUICKFIX theme */
    .qf-pager__links .page-item.active .page-link {
        background-color: #f59e0b; border-color: #f59e0b; color: #1b1f24;
    }
    .qf-pager__links .page-link { color: #b45309; }
    .qf-pager__links .page-link:focus { box-shadow: 0 0 0 .2rem rgba(245, 158, 11, .25); }
    @media (max-width: 575px) { .qf-pager { justify-content: center; } }
</style>
