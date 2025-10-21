<?php

declare(strict_types=1);

namespace App\Modules\Booking\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Booking\Repository\BookingRepository;
use Illuminate\Support\Facades\Storage;

class BookingController extends Controller
{
    private string $module;
    private string $title;
    private BookingRepository $bookingRepo;

    public function __construct(BookingRepository $bookingRepo)
    {
        $this->module = 'booking';
        $this->title = trans('Booking.Booking');
        $this->bookingRepo = $bookingRepo;
    }

    public function index()
    {
        $data['page_title'] = trans('app.List') . ' ' . $this->title;
        $data['rows'] = $this->bookingRepo->all();

        return view('admin.' . $this->module . '.index', $data);
    }

    public function updateStatus(int $id, string $status)
    {
        $booking = $this->bookingRepo->findOrFail($id);
        $this->bookingRepo->updateStatus($booking, $status);
        flash(trans('booking.status_updated', ['status' => $status]))->success();
        return redirect()->route('admin.booking.index');
    }
    public function destroy(int $id)
    {
        $Booking = $this->bookingRepo->findOrFail($id);
        Storage::disk('public')->delete($Booking->image);
        $this->bookingRepo->delete($Booking);

        flash(trans('Booking.deleted successfully.'))->success();

        return redirect()->route('admin.Booking.index');
    }
}
