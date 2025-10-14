@extends('layouts.admin_layout')
@push('title')
    {{ @$page_title }}
@endpush
@section('title', @$page_title)
@section('content')
    <div class="row">
        @if(!$rows->isEmpty())
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">{{ $errors->first() }}</div>
            @endif
            <div class="card mt-3 pt-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ trans('testimonials.Ratings_List') }}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0 w-99">
                            <thead>
                            <tr>
                                <th class="text-center">{{ trans('testimonials.rating') }}</th>
                                <th class="text-center">{{ trans('testimonials.comment') }}</th>
                                <th class="text-center">{{ trans('testimonials.user') }}</th>
                                <th class="text-center">{{ trans('testimonials.actions') }}</th>

                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rows as $row)
                                <tr class="text-center">
                                    <td class="align-middle text-center">{{ $row->rating  ?? ''}}</td>
                                    <td class="align-middle text-center">{{ $row->comment ?? '' }}</td>
                                    <td class="align-middle text-center">{{ $row->user->name }}</td>
                                    <td class="align-middle text-center pt-5">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6 col-xs-6 form-group">

                                                @if (!$testimonialRepository->isRatingAlreadyTestimonial($row))
                                                    <form action="{{ route('admin.testimonials.addRating', $row) }}"
                                                          method="POST">
                                                        @csrf
                                                        @method('PATCH')
                                                        <button type="submit" class="btn btn-outline-success">
                                                            {{ trans('testimonials.add_as_testimonial') }}
                                                        </button>
                                                    </form>
                                                @else
                                                    <button class="btn btn-outline-secondary" disabled>
                                                        {{ trans('testimonials.already_added') }}
                                                    </button>
                                                @endif
                                            </div>
                                            <div class="col-md-3 col-sm-3 col-xs-3 form-group">
                                                <div class="form-group">
                                                    <a
                                                            class="btn btn-outline-danger"
                                                            href="#"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#delete_course_{{$row->id}}"
                                                            title="{{ trans('app.delete') }}">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>
                                                <div
                                                        class="modal fade"
                                                        id="delete_course_{{$row->id}}"
                                                        tabindex="-1"
                                                        role="dialog"
                                                        aria-labelledby="myModalLabel"
                                                        aria-hidden="true"
                                                >
                                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-body">
                                                                <form method="POST" class="d-inline"
                                                                      action="{{route('admin.testimonials.deleteRating' , $row->id)}}">
                                                                    {{ csrf_field() }}
                                                                    {{ method_field('DELETE') }}
                                                                    <div class="form-group" style="">
                                                                        <label>{{trans('app.Are you sure you want to delete this item?')}}
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-group" style="margin-top: 20px">
                                                                        <button type="submit"
                                                                                class="btn btn-primary">{{ trans('app.confirm') }}</button>
                                                                        <button type="button" class="btn btn-danger"
                                                                                data-bs-dismiss="modal">{{trans('app.cancel')}}</button>

                                                                    </div>

                                                                </form>
                                                            </div>
                                                        </div>
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
                    <div class="mt-3">
                        {{ $rows->links() }}
                    </div>
                </div>
            </div>
        @else
            <div class="card mt-3 pt-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ trans('testimonials.ratings_List') }}</h5>
                </div>
            </div>
            @include('partials.noData')
        @endif
    </div>
@endsection
