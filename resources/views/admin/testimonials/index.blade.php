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
                    <h5 class="mb-0">{{ trans('testimonials.testimonials_List') }}</h5>
                    <div>
                        <a href="{{ route('admin.testimonials.getRating') }}"
                           class="btn btn-danger">{{ trans('testimonials.listRating') }}</a>
                        @if($activeTestimonialsCount >= 7)
                            <button class="btn btn-success" disabled>{{ trans('app.Create') }}</button>
                            <p>{{trans('testimonials.Cannot add more than 7 active testimonials.')}}</p>
                        @else
                            <a href="{{ route('admin.testimonials.get.create') }}"
                               class="btn btn-success">{{ trans('app.Create') }}</a>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-items-center mb-0 w-99">
                            <thead>
                            <tr>
                                <th class="text-center">{{ trans('testimonials.name') }}</th>
                                <th class="text-center">{{ trans('testimonials.job') }}</th>
                                <th class="text-center">{{ trans('testimonials.review') }}</th>
                                <th class="text-center">{{ trans('testimonials.image') }}</th>
                                <th class="text-center">{{ trans('testimonials.status') }}</th>
                                <th class="text-center">{{ trans('testimonials.change_status') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($rows as $row)
                                <tr class="text-center">
                                    <td class="align-middle text-center pt-2">{{ $row->name  ?? ''}}</td>
                                    <td class="align-middle text-center pt-2">{{ $row->job ?? 'Trainee' }}</td>
                                    <td class="align-middle text-center pt-2">{{ $row->review ?? '' }}</td>
                                    <td class="align-middle text-center pt-2">
                                            <?php
                                            $source = null;
                                            if (isset($row->rating)) {
                                                $source = $row->rating?->user?->profile_picture;
                                            } else {
                                                $source = $row->image ?? null;
                                            }
                                            ?>
                                        @if(isset($source))
                                            <img width="200"
                                                 src="{{image(img:$source , type: App\Modules\BaseApp\Enums\S3Enums::SMALL)}}"
                                                 alt="Profile Picture">
                                        @endif

                                    </td>
                                    <td class="align-middle text-center pt-2">{{ $row->status ? trans('testimonials.Active') : trans('testimonials.Deactive') }}</td>
                                    <td class="align-middle text-center pt-5">
                                        <div class="row" style="text-align: center; margin-left: 4px;">
                                            <div class="col-md-12 col-sm-12 col-xs-12 form-group">
                                                <form action="{{ route('admin.testimonials.toggle-status', $row) }}"
                                                      method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <button type="submit"
                                                            class="btn {{ $row->status ?  'btn-outline-danger' : 'btn-outline-primary'}}">
                                                        {{ $row->status ? trans('testimonials.Deactivate')  : trans('testimonials.Activate')  }}
                                                    </button>
                                                </form>
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
            <div class="card mt-3 pt-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ trans('testimonials.testimonials_List') }}</h5>
                    <div>
                        <a href="{{ route('admin.testimonials.getRating') }}"
                           class="btn btn-danger">{{ trans('testimonials.listRating') }}</a>

                        <a href="{{ route('admin.testimonials.get.create') }}"
                           class="btn btn-success">{{ trans('app.Create') }}</a>
                    </div>
                </div>
            </div>
            @include('partials.noData')
        @endif
    </div>
@endsection
