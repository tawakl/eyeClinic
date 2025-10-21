@extends('layouts.admin_layout')

@push('title')
    {{ @$page_title }}
@endpush

@section('title', @$page_title)

@section('content')
    <div class="row">
        @if(!$rows->isEmpty())
            <div class="card mt-3 pt-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ trans('booking.booking_list') }}</h5>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0 w-99">
                            <thead class="thead-light">
                            <tr>
                                <th class="text-center">{{ trans('booking.name') }}</th>
                                <th class="text-center">{{ trans('booking.insurance_number') }}</th>
                                <th class="text-center">{{ trans('booking.mobile_number') }}</th>
                                <th class="text-center">{{ trans('booking.date') }}</th>
                                <th class="text-center">{{ trans('booking.time') }}</th>
                                <th class="text-center">{{ trans('booking.status') }}</th>
                                <th class="text-center">{{ trans('booking.actions') }}</th>
                            </tr>
                            </thead>

                            <tbody>
                            @foreach($rows as $row)
                                <tr>
                                    <td class="align-middle text-center">{{ $row->name }}</td>
                                    <td class="align-middle text-center">{{ $row->insurance_number }}</td>
                                    <td class="align-middle text-center">{{ $row->phone }}</td>
                                    <td class="align-middle text-center">{{ $row->formatted_date }}</td>
                                    <td class="align-middle text-center">{{ $row->formatted_time }}</td>

                                    <td class="align-middle text-center">
                                        <span class="badge
                                            {{ $row->status === 'confirmed' ? 'bg-success' : ($row->status === 'canceled' ? 'bg-danger' : 'bg-warning') }}">
                                            <i class="fa {{ $row->status === 'confirmed' ? 'fa-check' : ($row->status === 'canceled' ? 'fa-times' : 'fa-clock') }}"></i>
                                            {{ ucfirst($row->status) }}
                                        </span>
                                    </td>

                                    <td class="align-middle text-center">

                                        {{-- ✅ Confirm / Cancel Button --}}
                                        <div class="d-inline-block" data-bs-toggle="tooltip" data-bs-placement="top"
                                             title="{{ $row->status === 'confirmed' ? trans('app.cancel') : trans('app.confirm') }}">
                                            <a class="btn btn-sm {{ $row->status === 'confirmed' ? 'btn-secondary' : 'btn-success' }}"
                                               href="#"
                                               data-bs-toggle="modal"
                                               data-bs-target="#toggle_status_{{ $row->id }}">
                                                <i class="fa {{ $row->status === 'confirmed' ? 'fa-times' : 'fa-check' }}"></i>
                                            </a>
                                        </div>

                                        {{-- ✅ Toggle Status Modal --}}
                                        <div class="modal fade" id="toggle_status_{{ $row->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center">
                                                        <form method="POST"
                                                              action="{{ route('admin.booking.updateStatus', ['id' => $row->id, 'status' => $row->status === 'confirmed' ? 'canceled' : 'confirmed']) }}">
                                                            @csrf
                                                            <p class="mb-4">
                                                                {{ $row->status === 'confirmed'
                                                                    ? trans('booking.confirm_cancel')
                                                                    : trans('booking.confirm_approve') }}
                                                            </p>
                                                            <div class="d-flex justify-content-center gap-3">
                                                                <button type="submit" class="btn btn-primary">
                                                                    {{ trans('app.confirm') }}
                                                                </button>
                                                                <button type="button" class="btn btn-danger"
                                                                        data-bs-dismiss="modal">
                                                                    {{ trans('app.cancel') }}
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        {{-- ✅ Delete Button --}}
                                        <div class="d-inline-block" data-bs-toggle="tooltip" data-bs-placement="top"
                                             title="{{ trans('app.delete') }}">
                                            <a class="btn btn-sm btn-danger"
                                               href="#"
                                               data-bs-toggle="modal"
                                               data-bs-target="#delete_booking_{{$row->id}}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>

                                        {{-- ✅ Delete Modal --}}
                                        <div class="modal fade" id="delete_booking_{{$row->id}}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center">
                                                        <form method="POST" action="{{ route('admin.booking.destroy', $row->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <p class="mb-4">
                                                                {{ trans('app.Are you sure you want to delete this item?') }}
                                                            </p>
                                                            <div class="d-flex justify-content-center gap-3">
                                                                <button type="submit" class="btn btn-primary">
                                                                    {{ trans('app.confirm') }}
                                                                </button>
                                                                <button type="button" class="btn btn-danger"
                                                                        data-bs-dismiss="modal">
                                                                    {{ trans('app.cancel') }}
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- ✅ Pagination --}}
                    <div class="mt-3 d-flex justify-content-center">
                        {{ $rows->links() }}
                    </div>
                </div>
            </div>
        @else
            @include('partials.noData')
        @endif
    </div>
@endsection

@push('js')
    <script>
        // ✅ Enable Bootstrap Tooltips
        document.addEventListener('DOMContentLoaded', function () {
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
@endpush
