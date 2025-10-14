@php
    $attributes=['class'=>'form-control','col-class'=>"col-md-6",'label'=>trans('testimonials.name'),'placeholder'=>trans('testimonials.name')];
@endphp
@include('form.input',['type'=>'text','name'=>'name','value'=> $row->name ?? null,'attributes'=>$attributes])
@php
    $attributes=['class'=>'form-control','col-class'=>"col-md-6",'label'=>trans('testimonials.job'),'placeholder'=>trans('testimonials.job')];
@endphp
@include('form.input',['type'=>'text','name'=>'job','value'=> $row->job ?? null,'attributes'=>$attributes])
@php
    $attributes=['class'=>'form-control','col-class'=>"col-md-6",'label'=>trans('testimonials.review'),'placeholder'=>trans('testimonials.review')];
@endphp
@include('form.input',['type'=>'text','name'=>'review','value'=> $row->review ?? null,'attributes'=>$attributes])

@php
    $attributes=['id'=>'image','class'=>'form-control','col-class'=>"col-md-6",'label'=>trans('testimonials.image') . ' (' . trans('testimonials.image dimensions') . ')', 'accept'=>'image/png, image/jpg, image/jpeg'];
@endphp
@include('form.file',['name'=>'image','value'=>$row->image ?? null,'attributes'=>$attributes ])

@php
    $attributes=['class'=>'form-control','col-class'=>"col-md-6",'label'=>trans('testimonials.is_active') .' *'];
@endphp
@include('form.boolean',['name'=>'status','value'=>$row->status ?? null,'attributes'=>$attributes])


