@extends('layouts.admin_layout')
@push('title')
    {{ @$page_title }}
@endpush
@section('title', @$page_title)
@section('content')
    <div class="row">
        @if(!$rows->isEmpty())
            <div class="card mt-3 pt-3">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0 w-99">
                            <thead>
                            <tr>
                                <th class="text-center">{{ trans('promo_codes.mobile_number') }}</th>
                                <th class="text-center">{{ trans('promo_codes.Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rows as $row)
                                <tr class="text-center">
                                    <td>{{ $row->mobile_number  ?? ''}}</td>
                                    <td>
                                        <div class="row">
                                            <div class="col-md-12 form-group">
                                                <form method="POST" class="" action="{{ route('admin.promoCodes.delete.mobile_number', [$promoCode->id, $row->mobile_number]) }}">
                                                    {{ csrf_field() }}
                                                    {{ method_field('DELETE') }}
                                                    <button type="submit" class="btn btn-xs btn-danger"
                                                            value="Delete Station"
                                                            data-confirm="{{trans('app.Are you sure you want to delete this item')}}?">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="pull-right">
                            {{ $rows->links() }}
                        </div>
                    </div>
                </div>
            </div>
        @else
            @include('partials.noData')
        @endif
    </div>

@endsection
