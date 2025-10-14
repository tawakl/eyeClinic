@if(isset($row))
    <div class="form-group">
        <label for="name" class="form-control-label">{{ trans('users.Type') }}</label> :
        <span style="font-size: 16px; font-weight: bold; color: black;">( {{ trans('users.' . $row->type) }} )</span>
    </div>
@else
    @include('form.select',['name'=>'type','options'=> $userType , $row->type ?? null ,'attributes'=>['id'=>'type','class'=>'form-control select2','col-class'=>"col-md-6",'label'=>trans('users.Type'),'placeholder'=>trans('users.Type')]])
@endif
@php
    $attributes=['class'=>'form-control','col-class'=>"col-md-6",'label'=>trans('users.First name'),'placeholder'=>trans('users.First name') ];
@endphp
@include('form.input',['type'=>'text','name'=>'first_name','value'=> $row->first_name ?? null,'attributes'=>$attributes, ])
@php
    $attributes=['class'=>'form-control','col-class'=>"col-md-6",'label'=>trans('users.Last name'),'placeholder'=>trans('users.Last name')];
@endphp
@include('form.input',['type'=>'text','name'=>'last_name','value'=> $row->last_name ?? null,'attributes'=>$attributes])
@php
    $attributes=['class'=>'form-control','col-class'=>"col-md-6",'label'=>trans('users.Email'),'placeholder'=>trans('users.Email')];
@endphp
@include('form.input',['type'=>'text','name'=>'email','value'=> $row->email ?? null,'attributes'=>$attributes])
@php
    $attributes=['class'=>'form-control','col-class'=>"col-md-6",'label'=>trans('users.Mobile'),'placeholder'=>trans('users.Mobile'),'id'=>'mobile','dir' => 'ltr'];
@endphp

@include('form.input',['type'=>'text','name'=>'mobile','value'=> $row->mobile ?? null,'attributes'=>$attributes])
@if(isset($row->id))
    @php
        $attributes=['class'=>'form-control','col-class'=>"col-md-6",'label'=>trans('users.Password'),'placeholder'=>trans('users.Password')];
    @endphp

    @include('form.password',['name'=>'password','attributes'=>$attributes])
    @php
        $attributes=['class'=>'form-control','col-class'=>"col-md-6",'label'=>trans('users.Password confirmation'),'placeholder'=>trans('users.Password confirmation')];
    @endphp

    @include('form.password',['name'=>'password_confirmation','attributes'=>$attributes])
@endif


@php
    $attributes=[
        'class'=>'form-control',
    'col-class'=>"col-md-6",
    'id'=>'profile_picture',
    'label'=>trans('users.Profile Picture') . ' (' . trans('users.image dimensions') . ')',
     'accept'=>'image/png, image/jpg, image/jpeg'
     ];
@endphp
@include('form.file',['name'=>'profile_picture','value'=>$row->profile_picture ?? null,'attributes'=>$attributes ])

@php
    $attributes=['class'=>'form-control','col-class'=>"col-md-6",'label'=>trans('users.Is active') .' *'];
@endphp
@include('form.boolean',['name'=>'is_active','value'=>$row->is_active ?? null,'attributes'=>$attributes])
@push('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script>
        const currentLang = window.location.pathname.includes('/en') ? 'en' : 'ar';

        const phoneInputField = document.querySelector("#mobile");
        const phoneInput = window.intlTelInput(phoneInputField, {
            onlyCountries: ["eg"],
            customContainer: "col-12",
            formatOnDisplay: true,
            nationalMode: false,
            autoPlaceholder: "aggressive",
            utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
            localizedCountries: currentLang === 'ar' ? { 'eg': 'مصر' } : { 'sa': 'Egypt' },
        });

        if (currentLang === 'ar') {
            phoneInputField.setAttribute("placeholder", "رقم التليفون");
            phoneInputField.style.direction = "rtl";
            document.querySelector(".iti").classList.add("rtl-mode");
        } else {
            phoneInputField.setAttribute("placeholder", "Phone Number");
            phoneInputField.style.direction = "ltr";
        }

        document.querySelector('form').addEventListener('submit', function (e) {
            const fullNumber = phoneInput.getNumber();
            phoneInputField.value = fullNumber;
        });
    </script>


@endpush

@push('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css">
    <style>
        .iti {
            position: relative;
        }

        .iti.rtl-mode .iti__flag-container {
            left: auto !important;
            right: 0 !important;
        }

        .iti.rtl-mode input {
            padding-left: 10px !important;
            padding-right: 50px !important;
            text-align: right;
        }
        .iti__arrow {
            margin: 4px;
        }
    </style>
@endpush

