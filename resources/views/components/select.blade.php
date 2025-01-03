<div class="form-group">
    <label for="type">{{ $label }}</label>
    <select name="{{ $name }}" id="{{ $id }}" class="form-control" @if($required) required @endif>
        @foreach($options as $option)
            <option value="{{ $option[$optionValue] }}"
                    @if ($value == $option[$optionValue]) selected @endif>{{ $option[$optionLabel] }}</option>
        @endforeach
    </select>
</div>
