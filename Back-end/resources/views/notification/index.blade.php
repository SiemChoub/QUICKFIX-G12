
<div id="card-alert" class="cardd border-0">
    <div class="container h-25">
        <div class="row">
            <div class="col-md-12">
                <div id="notification-container" style="max-height: 400px; overflow-y: auto;">
                    @foreach ($notifications as $index => $notification)
                        <div class="alert border-0 alert-dark notification-card" id="notification-{{ $index }}"
                            role="alert" @if ($index >= 2) style="display: none;" @endif>
                            <div class="name d-flex justify-between">
                                <h3 class="font-weight">{{ $notification->role_id }}</h3>
                                <h5>now</h5>
                            </div>
                            <div class="notification d-flex justify-between">
                                <strong>Welcome! You have {{ $notification->text }}</strong>
                                <strong>
                                    <div class="btn btn-success">Confirm</div>
                                    <div id="reject-{{ $index }}" class="btn btn-warning reject-btn">Reject
                                    </div>
                                </strong>
                            </div>
                            <span class="time">5:30 PM</span>
                            <span class="icon"><i class="bx bx-calendar"></i></span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>


 