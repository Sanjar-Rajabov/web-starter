<div class="form-label-group">
    <input type="{{ $type->value }}" id="{{ $id }}" name="{{ $name }}" value="{{ old($old, $value) }}"
           class="form-control" placeholder="{{ $label }}" @if($required) required @endif>
    <label for="{{ $id }}">{{ $label }}</label>
</div>
