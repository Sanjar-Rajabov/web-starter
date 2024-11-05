@php use App\Enums\ImageInputTypesEnum; @endphp
<div class="form-group">
    <div class="custom-file">
        <input type="file" id="{{ $name }}" name="{{ $name }}" class="custom-file-input"
               @if ($type !== ImageInputTypesEnum::Any) accept="{{ ImageInputTypesEnum::getMimes($type) }}" @endif
               @if($required) required @endif>
        <label for="{{ $name }}" class="custom-file-label">{{ $label }} (Макс: {{ $size->getMB() }}MB|{{ $size->getResolution() }})</label>
    </div>
    <div class="text-center">
        <img src="{{ $value }}" alt="" width="150px" id="show-{{ $name }}">
    </div>
</div>
