<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Admin\Concerns\ResolvesBookingDetail;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Bookin_immediately;
use App\Models\Bookin_deadline;
use App\Models\User;
use App\Models\Service;

class RequestController extends Controller
{
    use ResolvesBookingDetail;

    //
    public function index()
    {
        $perPage = (int) request('per_page', 20);
        if (!in_array($perPage, [5, 10, 20, 50, 100])) {
            $perPage = 20;
        }

        $user = User::all();
        $Bookin_immediately = Bookin_immediately::all();
        $Bookin_deadline = Bookin_deadline::all();
        $service = Service::all();
        $bookings = Booking::all();
        $requests = Booking::where('action', 'request')
            ->orderByDesc('id')
            ->paginate($perPage)
            ->withQueryString();

        return view('request.index', [
            'bookings'      => $bookings,
            'requests'      => $requests,
            'users'         => $user,
            'deadlines'     => $Bookin_deadline,
            'immediatelys'  => $Bookin_immediately,
            'services'      => $service,
        ]);
    }

    public function show(int $id)
    {
        return $this->showBookingDetail($id, [
            'back' => route('admin.requests.index'),
            'tab'  => 'Requests',
            'icon' => 'bx-receipt',
        ], 'Request access');
    }

    // public function destroy(Request $request)
    // {
    //     $booking = Booking::find($id);
    //     if($booking['type'] == 'immediately'){
    //         $bookin_immediately = Bookin_immediately::find($booking->booking_type_id);
    //         $bookin_immediately->delete();
    //     }else{
    //         $bookin_deadline = Bookin_deadline::find($booking->booking_type_id);
    //         $bookin_deadline->delete();
    //     }
    //     $booking->delete();
    //     return redirect('admin/requests')->with('showAlertDelete', true);
    // }
    public function destroy(int $id)
    {
        $booking = Booking::find($id);
        if($booking['type'] == 'immediately'){
            $bookin_immediately = Bookin_immediately::find($booking->booking_type_id);
            $bookin_immediately->delete();
        }else{
            $bookin_deadline = Bookin_deadline::find($booking->booking_type_id);
            $bookin_deadline->delete();
        }
        $booking->delete();
        return redirect()->back()->with('showAlertDelete', true);
    }
}
