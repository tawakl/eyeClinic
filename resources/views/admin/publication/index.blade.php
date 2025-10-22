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
                    <h5 class="mb-0">{{ trans('publication.publication_list') }}</h5>
                    <div>
                        <a href="{{ route('admin.publication.create') }}"
                           class="btn btn-primary">{{ trans('publication.add_publication') }}</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0 w-99">
                            <thead class="thead-light">
                            <tr>
                                <th class="text-center">{{ trans('publication.title') }}</th>
                                <th class="text-center">{{ trans('publication.category') }}</th>
                                <th class="text-center">{{ trans('publication.published_year') }}</th>
                                <th class="text-center">{{ trans('publication.description') }}</th>
                                <th class="text-center">{{ trans('publication.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rows as $row)
                                <tr>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-xs font-weight-bold mb-0">{{ $row->title }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-xs mb-0">{{ $row->category ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-xs mb-0">{{ $row->published_year ?? '-' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-xs mb-0 text-truncate">{{ $row->description }}</p>
                                    </td>

                                    <td class="align-middle text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a class="btn btn-xs btn-info"
                                               href="{{ route('admin.publication.edit', $row->id) }}"
                                               title="{{ trans('publication.edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <a class="btn btn-xs btn-danger"
                                               href="#"
                                               data-bs-toggle="modal"
                                               data-bs-target="#delete_{{ $row->id }}"
                                               title="{{ trans('publication.delete') }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>

                                        <!-- Modal حذف -->
                                        <div class="modal fade" id="delete_{{ $row->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center">
                                                        <form method="POST" action="{{ route('admin.publication.destroy', $row->id) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <p class="mb-4">
                                                                {{ trans('app.Are you sure you want to delete this item?') }}
                                                            </p>
                                                            <div class="d-flex justify-content-center gap-3">
                                                                <button type="submit" class="btn btn-primary">
                                                                    {{ trans('app.confirm') }}
                                                                </button>
                                                                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">
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

                    <div class="mt-3 d-flex justify-content-center">
                        {{ $rows->links() }}
                    </div>
                </div>
            </div>
        @else
            <div class="card mt-1 pt-1">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('admin.publication.create') }}"
                           class="btn btn-primary">{{ trans('publication.add_publication') }}</a>
                    </div>
                </div>
            </div>
            @include('partials.noData')
        @endif
    </div>
@endsection
