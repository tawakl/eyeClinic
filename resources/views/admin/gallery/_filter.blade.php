@push('css')
    <link rel="stylesheet" type="text/css" href="/assets/css/select2.min.css">
@endpush

<div class="card mt-3 pt-3">
    <div class="card-header">
        <h5 class="mb-0">{{ __("users.users_filters") }}</h5>
    </div>
    <div class="card-body">
        <form method="get">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label-behind">{{ __("users.first_name") }}</label>
                        <input type="text" class="form-control" name="first_name"
                               value="{{ old("first_name", request()->get("first_name")) }}"
                               placeholder="{{ __("users.first_name") }}" autocomplete="off">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label-behind">{{ __("users.last_name") }}</label>
                        <input type="text" autocomplete="off" name="last_name"
                               value="{{ old("last_name", request()->get("last_name")) }}"
                               placeholder="{{ __("users.last_name") }}" class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label-behind">{{ __('users.type') }}</label>
                        <select name="type" id="userTypeSelect" class="form-control select2" placeholder="{{ trans('users.type') }}">
                            <option value="">{{ trans('users.type') }}</option>
                            @foreach($user_types as $key => $value)
                                <option value="{{ $key }}" {{ request()->get('type') == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label-behind">{{ __("users.email") }}</label>
                        <input type="email" autocomplete="off" name="email"
                               value="{{ old("email", request()->get("email")) }}" placeholder="{{ __("users.email") }}"
                               class="form-control">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label-behind">{{ __("users.mobile") }}</label>
                        <input type="text" autocomplete="off" name="mobile"
                               value="{{ old("mobile", request()->get("mobile")) }}"
                               placeholder="{{ __("users.mobile") }}" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label-behind">{{ trans('users.status') }}</label>
                        <select name="active" id="is_active" class="form-control select2">
                            <option value="">{{ trans('users.status') }}</option>
                            <option value="0" {{ request()->get('active') == '0' ? 'selected' : '' }}>{{ trans('app.not active') }}</option>
                            <option value="1" {{ request()->get('active') == '1' ? 'selected' : '' }}>{{ trans('app.active') }}</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-12 form-group">
                <button class="btn btn-md btn-primary"><i class="mdi mdi-filter"></i> {{ trans('app.Search') }}</button>
                <a class="btn btn-md btn-danger" href="{{ url()->current() }}" role="button">
                    <i class="mdi mdi-delete-circle"></i> {{ trans('app.reset') }}
                </a>
            </div>
        </form>
    </div>
</div>

@push('js')
    <script src="/assets/js/select2.full.min.js"></script>
    <script src="/assets/js/form-select2.min.js"></script>
@endpush
