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
                    <h5 class="mb-0">{{ trans('contact.Contacts_List') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0 w-99">
                            <thead class="thead-light">
                            <tr>
                                <th class="text-center">{{ trans('contact.visitor_name') }}</th>
                                <th class="text-center">{{ trans('contact.email') }}</th>
                                <th class="text-center">{{ trans('contact.mobile') }}</th>
                                <th class="text-center">{{ trans('contact.created on') }}</th>
                                <th class="text-center">{{ trans('contact.Actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rows as $row)
                                <tr class="text-center">
                                    <td>{{ $row->visitor_name }}</td>
                                    <td>{{ $row->email }}</td>
                                    <td dir="ltr">{{ $row->phone }}</td>
                                    <td>{{ $row->created_at }}</td>
                                    <td class="align-middle text-center pt-5">
                                        <div class="row">
                                            <div class="form-group">
                                                <a class="btn btn-xs btn-primary"
                                                   href="{{  route('admin.contact.get.view',$row->id) }}"
                                                   data-bs-toggle="tooltip" data-placement="top"
                                                   title="{{ trans('app.view') }}">
                                                    <i class="fa fa-eye"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
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
