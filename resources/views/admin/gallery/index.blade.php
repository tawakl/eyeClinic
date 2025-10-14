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
                    <h5 class="mb-0">{{ trans('gallery.gallery_list') }}</h5>
                    <div>
                        <a href="{{ route('admin.gallery.create') }}"
                           class="btn btn-primary">{{ trans('gallery.add_image') }}</a>
                    </div>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0 w-99">
                            <thead class="thead-light">
                            <tr>
                                <th class="text-center">{{ trans('gallery.image') }}</th>
                                <th class="text-center">{{ trans('gallery.caption') }}</th>
                                <th class="text-center">{{ trans('gallery.actions') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rows as $row)
                                <tr>
                                    <td class="align-middle text-center text-sm">
                                        <img src="{{ $row->image_url }}"
                                             alt="Image"
                                             style="width: 120px; height: 80px; object-fit: cover; border-radius: 6px; cursor: pointer;"
                                             class="img-thumbnail shadow-sm gallery-image"
                                             data-full="{{ $row->image_url }}">
                                    </td>

                                    <td class="align-middle text-center text-sm">
                                        <p class="text-xs font-weight-bold mb-0">{{ $row->caption ?? '-' }}</p>
                                    </td>

                                    <td class="align-middle text-center pt-5">
                                        <div class="d-flex justify-content-center">
                                            <a class="btn btn-xs btn-info me-2"
                                               href="{{ route('admin.gallery.edit', $row->id) }}"
                                               data-bs-toggle="tooltip" data-bs-placement="bottom"
                                               title="{{ trans('gallery.edit_image') }}">
                                                <i class="fas fa-edit"></i>
                                            </a>

                                            <form method="POST" action="{{ route('admin.gallery.destroy', $row->id) }}"
                                                  onsubmit="return confirm('{{ trans('gallery.confirm_delete') }}')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-xs btn-danger" type="submit"
                                                        data-bs-toggle="tooltip" data-bs-placement="bottom"
                                                        title="{{ trans('gallery.delete') }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- pagination (اختياري) --}}
                    {{-- <div class="mt-3 d-flex justify-content-center">
                        {{ $rows->links() }}
                    </div> --}}
                </div>
            </div>
        @else
            <div class="card mt-1 pt-1">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div>
                        <a href="{{ route('admin.gallery.create') }}"
                           class="btn btn-primary">{{ trans('gallery.add_image') }}</a>
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
