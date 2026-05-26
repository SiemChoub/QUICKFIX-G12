<?php

namespace App\Http\Controllers\Admin\Concerns;

use App\Models\Booking;
use App\Models\Bookin_immediately;
use App\Models\Bookin_deadline;
use App\Models\FixingProgress;
use App\Models\Service;
use App\Models\User;

/**
 * Resolves a single booking and every related record (customer, fixer,
 * the immediately/deadline detail row, service and progress entry) so the
 * three booking tabs (Requests / Progress / Done) can render one shared
 * full-page detail view instead of the old, mostly-empty popup modal.
 */
trait ResolvesBookingDetail
{
    /**
     * Build the booking detail page for a given Booking id.
     *
     * @param  int     $bookingId  The bookings.id (the same id the list rows pass).
     * @param  array   $context    Tab context: ['back' => url, 'tab' => label, 'icon' => boxicon].
     * @param  string  $permission Spatie permission required to view (e.g. 'Request access').
     */
    protected function showBookingDetail(int $bookingId, array $context, string $permission)
    {
        abort_unless(auth()->user()?->can($permission), 403);

        $booking = Booking::findOrFail($bookingId);

        $customer = User::find($booking->user_id);
        $fixer    = $booking->fixer_id ? User::find($booking->fixer_id) : null;

        $detail = $booking->type === 'immediately'
            ? Bookin_immediately::find($booking->booking_type_id)
            : Bookin_deadline::find($booking->booking_type_id);

        $service = ($detail && $detail->service_id)
            ? Service::find($detail->service_id)
            : null;

        $progress = FixingProgress::where('booking_id', $booking->id)->latest('id')->first();

        return view('booking.show', compact(
            'booking',
            'customer',
            'fixer',
            'detail',
            'service',
            'progress',
            'context'
        ));
    }
}
