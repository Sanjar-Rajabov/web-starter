@php use App\Enums\ImageInputTypesEnum;use App\Helpers\ArrayHelper; @endphp
<div class="form-group row">
    <div class="{{ $deletable ? 'col-11' : 'col-12' }}">
        <div class="custom-file">
            <input type="file" id="{{ $id }}" name="{{ $name }}" class="custom-file-input"
                   @if ($type !== ImageInputTypesEnum::Any) accept="{{ ImageInputTypesEnum::getMimes($type) }}" @endif
                   @if($required) required @endif>
            <label for="{{ $name }}" class="custom-file-label" id="{{ $id }}-label">{{ $label }}
                (Макс: {{ $size->getMB() }}
                MB|{{ $size->getResolution() }})</label>
        </div>
        <div class="text-center">
            <img src="{{ $value }}" alt="" width="150px" id="show-{{ $id }}">
        </div>
    </div>
    @if($deletable)
        <div class="col-1">
            <a href="javascript:void(0)" title="Удалить файл" class="btn btn-danger btn-icon"
               onclick="deleteImage('{{ $id }}', '{{ $label }} (Макс: {{ $size->getMB() }} MB|{{ $size->getResolution() }})')"
               id="remove-{{ $id }}"><i class="feather icon-image"></i></a>
        </div>
    @endif
</div>
