<div class="form-label-group">
    <textarea id="{{ $id }}" name="{{ $name }}" class="form-control"
              placeholder="{{ $label }}" @if($required) required @endif>{{ old($old, $value) }}</textarea>
    <label for="{{ $id }}">{{ $label }}</label>
</div>
