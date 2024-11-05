<div class="form-label-group">
    <input type="hidden" name="{{ $name }}" id="{{ $id }}-input" value="{{ old($old, $value) }}">
    <label for="{{ $id }}">{{ $label }}</label>
    <div id="{{ $id }}">{!! old($old, $value) !!}</div>
</div>
@push('scripts')
    <script>
        makeNewQuill('{{ $id }}', '{{ $label }}', {!! json_encode($toolbar) !!});
    </script>
@endpush
