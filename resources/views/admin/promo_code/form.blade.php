@php
    $attributes=[
        'class'=>'promo_code_type',
        'label'=>trans('promo_codes.promo code type'),
        'required'=>1,
        'disabled'=> isset($row->id),
        ];
      $options=[
          ['label'=>trans('promo_codes.general_promo_code'),'value'=>\App\Modules\PromoCodes\Enums\PromoCodesEnums::GENERAL_PROMO_CODE]
         ,['label'=>trans('promo_codes.for_specific_students'),'value'=>\App\Modules\PromoCodes\Enums\PromoCodesEnums::FOR_SPECIFIC_STUDENTS]
     ]
@endphp
@include('form.radio',['name'=>'promo_code_type',$attributes,$options])
<div id="mobile_numbers_div">
        <a style="text-decoration: underline ;color: #3a3ae9"
           href="{{url('promo-code-mobile-numbers-sample.xls')}}"> {{trans('promo_codes.sample_file')}}</a>
    @php
        $attributes=[
            'id'=>'mobile_numbers',
            'class'=>'form-control',
            'label'=>trans('promo_codes.mobile_numbers_file') ,
            'accept'=>"application/vnd.ms-excel",
            'disabled'=> isset($row->id)
             ];
    @endphp
    @include('form.file',['name'=>'mobile_numbers' ,'attributes'=>$attributes])
</div>
<div id="code_div">
    @php
        $attributes=[
            'class'=>'form-control',
            'label'=>trans('promo_codes.code'),
            'placeholder'=>trans('promo_codes.code'),
            'disabled'=> isset($row->id)
            ];
    @endphp
    @include('form.input',['type'=>'text','name'=>'code','value'=> $row->code ?? null,'attributes'=>$attributes])
</div>

@include('form.input',['type'=>'date','name'=>'from','value'=> $row->from ?? null,
'attributes'=>[
    'class'=>'form-control',
            'col-class'=>"col-md-6",
    'label'=>trans('promo_codes.valid from'),
    'placeholder'=>trans('promo_codes.valid from'),
    'required'=>'required',
     'disabled'=> isset($row->id)
    ]
    ])

@include('form.input',['type'=>'date','name'=>'to','value'=> $row->to ?? null,
'attributes'=>[
    'class'=>'form-control ',
            'col-class'=>"col-md-6",
    'label'=>trans('promo_codes.valid to'),
    'placeholder'=>trans('promo_codes.valid to'),
    'required'=>'required',
        'id'=>'promo_code_valid_to',
        'disabled'=> isset($row->id)
    ]])
<br>

@php
    $attributes=[
        'class'=>'promo_code_used_type',
        'label'=>trans('promo_codes.promo code use product type'),
        'required'=>1,
        'disabled'=> isset($row->id)
        ];
      $options=[
          ['label'=>trans('promo_codes.general_promo_code'),'value'=>\App\Modules\PromoCodes\Enums\PromoCodesEnums::GENERAL_PROMO_CODE]
         ,['label'=>trans('promo_codes.for_specific_courses'),'value'=>\App\Modules\PromoCodes\Enums\PromoCodesEnums::FOR_SPECIFIC_COURSES]
     ]
@endphp
@include('form.radio',['name'=>'promo_code_used_type',$attributes,$options])

<div id="courses_ids_div">
    @include('form.multiselect',['name'=>'courses_ids[]','error_name'=>'courses_ids','options'=> $courses ,'value'=> $row->courses ?? [] ,
'attributes'=>['id'=>'courses_ids','multiple'=>'multiple','class'=>'form-control select2','label'=>trans('promo_codes.courses'),'data-select2-id'=>"select2-data-courses_ids",'disabled'=> isset($row->id)]])
</div>
@php
    $attributes=[
        'class'=>'discount_type',
        'label'=>trans('promo_codes.discount type'),
        'required'=>1,
        'disabled'=> isset($row->id),
        ];
     $options=[
   ['label'=>trans('promo_codes.percentage'), 'value'=>\App\Modules\PromoCodes\Enums\PromoCodesEnums::PERCENTAGE],
             ['label'=>trans('promo_codes.fixed_amount'),'value'=>\App\Modules\PromoCodes\Enums\PromoCodesEnums::FiXED_AMOUNT,]
             ];
@endphp
@include('form.radio',['name'=>'discount_type',$attributes,$options])
@php
    $attributes=[
        'class'=>'form-control',
        'label'=>trans('promo_codes.value'),
        'placeholder'=>trans('promo_codes.value'),
        'required'=>1,
        'min'=>1,
        'disabled'=> isset($row->id)
        ];
@endphp
@include('form.input',['type'=>'number','name'=>'promo_code_value','value'=> $row->promo_code_value ?? null,'attributes'=>$attributes])


@php
    $attributes=[
        'class'=>'form-control',
                'col-class'=>"col-md-6",
        'label'=>trans('promo_codes.count per student'),
        'placeholder'=>trans('promo_codes.count per student'),
        'required'=>1,
        'min'=>1,
        'disabled'=> isset($row->id)
        ];
@endphp
@include('form.input',['type'=>'number','name'=>'count_per_student','value'=> $row->count_per_student ?? null,'attributes'=>$attributes])

@php
    $attributes=[
        'class'=>'form-control',
        'col-class'=>"col-md-6",
        'label'=>trans('promo_codes.count for all students'),
        'placeholder'=>trans('promo_codes.count for all students'),
        'required'=>1,
        'min'=>1,
        'disabled'=> isset($row->id)
        ];
@endphp
@include('form.input',['type'=>'number','name'=>'count_for_all_students','value'=> $row->count_for_all_students ?? null,'attributes'=>$attributes])
@php
    $attributes=[
        'class'=>'form-control',
        'col-class'=>"col-md-6",
        'label'=>trans('promo_codes.Is active'),
        'required'=>1,
        "id"=>'is_active',
        'disabled'=> isset($row->id) && $row->to < date('Y-m-d'),
];
@endphp
@include('form.boolean',['name'=>'is_active',$attributes])

@push('js')
    <script>
        let codeDiv = $('#code_div')
        let mobileNumbersDiv = $('#mobile_numbers_div')
        let coursesIdsDiv = $('#courses_ids_div')


        let promoCodeType = $('.promo_code_type')
        let promoCodeTypeSelected = $("input[type='radio'][name='promo_code_type']:checked");

        let promoCodeUsedType = $('.promo_code_used_type');
        let promoCodeUsedTypeSelected = $("input[type='radio'][name='promo_code_used_type']:checked");

        $(document).ready(function () {
            if (promoCodeTypeSelected.val() === '{{\App\Modules\PromoCodes\Enums\PromoCodesEnums::FOR_SPECIFIC_STUDENTS}}') {
                mobileNumbersDiv.show()
                codeDiv.hide()
            } else {
                codeDiv.show()
                mobileNumbersDiv.hide()
            }
            if (promoCodeUsedTypeSelected.val() === '{{\App\Modules\PromoCodes\Enums\PromoCodesEnums::FOR_SPECIFIC_COURSES}}') {
                coursesIdsDiv.show()
            } else {
                coursesIdsDiv.hide()
            }

        });
        promoCodeType.on('change', function (e) {
            let promoCodeUsedTypeSelected = $(this).val();
            if (promoCodeUsedTypeSelected === '{{\App\Modules\PromoCodes\Enums\PromoCodesEnums::FOR_SPECIFIC_STUDENTS}}') {
                mobileNumbersDiv.show()
                codeDiv.hide()
            } else {
                codeDiv.show()
                mobileNumbersDiv.hide()
            }
        });
        promoCodeUsedType.on('change', function (e) {
            let promoCodeUsedTypeSelected = $(this).val();
            if (promoCodeUsedTypeSelected === '{{\App\Modules\PromoCodes\Enums\PromoCodesEnums::FOR_SPECIFIC_COURSES}}') {
                coursesIdsDiv.show()
            } else {
                coursesIdsDiv.hide()
            }
        });
    </script>
@endpush
