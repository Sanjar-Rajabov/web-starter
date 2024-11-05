<div class="form-group">
    <fieldset>
        <div class="vs-checkbox-con vs-checkbox-primary">
            <input type="checkbox" name="{{ $name }}" @if(old($old, $checked)) checked @endif value="1">
            <input type="hidden" name="{{ $name }}" value="0">
            <span class="vs-checkbox">
                <span class="vs-checkbox--check">
                    <i class="vs-icon feather icon-check"></i>
                </span>
            </span>
            <span class="">{{ $label }}</span>
        </div>
    </fieldset>
</div>
