<?php

declare(strict_types = 1);

namespace App\Modules\Booking\Repository;

use App\Modules\Booking\Booking;

class BookingRepository
{
    private Booking $booking;

    public function __construct($booking = null)
    {
        if ($booking instanceof Booking) {
            $this->booking = $booking;
        } else {
            $this->booking = new Booking();
        }
    }

    public function all()
    {
        return $this->booking->orderByDesc('id')->paginate(10);
    }

    public function findOrFail(int $id): Booking
    {
        return $this->booking->findOrFail($id);
    }

    public function updateStatus(Booking $booking, string $status)
    {
        $booking->update(['status' => $status]);
    }

    public function delete(Booking $booking)
    {
        $booking->delete();
    }

    public function create($data): Booking
    {
        return $this->booking->create($data);
    }
}
