<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
    <div>
        <h4 class="fw-bold mb-0" style="color:#1f2937;">{{ $title }}</h4>
        <small class="text-muted">{{ $subtitle ?? '' }}</small>
    </div>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-warning">
        <i class='bx bx-arrow-back'></i> Back to dashboard
    </a>
</div>
