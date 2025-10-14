@push('css')
    <link rel="stylesheet" type="text/css" href="/assets/css/select2.min.css">
@endpush
<div class="card mt-3 pt-3">
    <div class="card-header">
        <h5 class="mb-0">{{ __("promo_codes.filters") }}</h5>
    </div>
    <div class="card-body">
        {!! Form::open(['method' => 'get']) !!}
        <div class="row">
            @include('form.select',['name'=>'type','options'=>[
                  \App\Modules\PromoCodes\Enums\PromoCodesEnums::GENERAL_PROMO_CODE => trans('promo_codes.general_promo_code'),
                 \App\Modules\PromoCodes\Enums\PromoCodesEnums::FOR_SPECIFIC_COURSES =>trans('promo_codes.for_specific_courses')
             ], 'value'=> request()->get('type') ?? null ,'attributes'=>['id'=>'type','class'=>'form-control educational select2','col-class'=>"col-md-6",'label'=>trans('promo_codes.promo code use product type'),'placeholder'=>trans('promo_codes.promo code use product type')]])
            @include('form.select',['name'=>'is_active','options'=> [1=>trans('app.active'),0=>trans('app.not active')], 'value'=> request()->get('is_active') ?? null ,'attributes'=>['id'=>'is_active','class'=>'form-control educational select2','col-class'=>"col-md-6",'label'=>trans('promo_codes.Is active'),'placeholder'=>trans('promo_codes.Is active')]])

        </div>
        <div class="row">
            @include('form.input',['type'=>'date','id'=>'from','name'=>'from','value'=>request()->get('from') ?? null,
'attributes'=>['class'=>'form-control nowdatepicker','col-class'=>"col-md-6",'label'=>trans('promo_codes.valid from'),'placeholder'=>trans('promo_codes.valid from')]])
            @include('form.input',['type'=>'date','id'=>'to','name'=>'to','value'=>request()->get('to') ?? null,
'attributes'=>['class'=>'form-control nowdatepicker','col-class'=>"col-md-6",'label'=>trans('promo_codes.valid to'),'placeholder'=>trans('promo_codes.valid to')]])
        </div>


        <div class="col-md-12 form-group">
            <button class="btn btn-md btn-primary"><i class="mdi mdi-filter"></i> {{ trans('app.Search') }}
            </button>
            <a class="btn btn-md btn-danger" href="{{url()->current()}}" role="button"><i
                        class="mdi mdi-delete-circle"></i> {{ trans('app.reset') }}</a>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@push('js')
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script src="/assets/js/select2.full.min.js"></script>
    <script src="/assets/js/form-select2.min.js"></script>
@endpush
