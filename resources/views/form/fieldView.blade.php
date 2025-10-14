<div class="row mg-t-20">
    <label class="col-sm-4">{{ @$attributes['label'] }}</label>
    <div class="col-sm-8 mg-t-10 mg-sm-t-0">
        @if(isset($attributes['type']))
            @if(@$attributes['type'] == 'image' )
                {!! viewImage(img:@$attributes['value'],type: App\Modules\BaseApp\Enums\S3Enums::SMALL, attributes:['width' => 90]) !!}
            @else
                {!! viewFile(@$attributes['value']) !!}
            @endif
        @else
            {{@$attributes['value']}}
        @endif
    </div>
</div>
