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
                    <h5 class="mb-0">{{ trans('team.team_list') }}</h5>
                    <div>
                        <a href="{{ route('admin.team.create') }}"
                           class="btn btn-primary">{{ trans('team.add_team_member') }}</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0 w-99">
                            <thead class="thead-light">
                            <tr>
                                <th class="text-center">{{ trans('team.name') }}</th>
                                <th class="text-center">{{ trans('team.title') }}</th>
                                <th class="text-center">{{ trans('team.description') }}</th>
                                <th class="text-center">{{ trans('team.image') }}</th>
                                <th class="text-center">{{ trans('team.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rows as $row)
                                <tr>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-xs font-weight-bold mb-0">{{ $row->name ?? '' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-xs font-weight-bold mb-0">{{ $row->title ?? '' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <p class="text-xs font-weight-bold mb-0">{{ $row->description ?? '' }}</p>
                                    </td>
                                    <td class="align-middle text-center text-sm">
                                        <img src="{{ $row->image_url }}"
                                             alt="Image"
                                             style="width: 120px; height: 80px; object-fit: cover; border-radius: 6px; cursor: pointer;"
                                             class="img-thumbnail shadow-sm gallery-image"
                                             data-full="{{ $row->image_url }}">
                                    </td>


                                    <td class="align-middle text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a class="btn btn-xs btn-info"
                                               href="{{ route('admin.team.edit', $row->id) }}"
                                               data-bs-toggle="tooltip"
                                               data-bs-placement="bottom"
                                               title="{{ trans('team.edit') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <a class="btn btn-xs btn-danger"
                                               href="#"
                                               data-bs-toggle="modal"
                                               data-bs-target="#delete_image_{{$row->id}}"
                                               title="{{ trans('app.delete') }}">
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </div>

                                        <div class="modal fade" id="delete_image_{{$row->id}}" tabindex="-1"
                                             role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body text-center">
                                                        <form method="POST" action="{{ route('admin.team.destroy', $row->id) }}">
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
                     <div class="mt-3 d-flex justify-content-center">
                        {{ $rows->links() }}
                    </div>
                </div>
            </div>
        @else
            <div class="card mt-1 pt-1">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('admin.team.create') }}"
                           class="btn btn-primary">{{ trans('team.add_team_member') }}</a>
                    </div>
                </div>
            </div>
            @include('partials.noData')
        @endif
    </div>

    <!-- ✅ Modal لعرض الصورة -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-body text-center p-0">
                    <img id="modalImage" src="" class="img-fluid rounded" alt="Full Image">
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = new bootstrap.Modal(document.getElementById('imageModal'));
            const modalImage = document.getElementById('modalImage');

            document.querySelectorAll('.gallery-image').forEach(img => {
                img.addEventListener('click', () => {
                    modalImage.src = img.getAttribute('data-full');
                    modal.show();
                });
            });
        });
    </script>
@endpush
