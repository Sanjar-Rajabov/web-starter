<div>
    <div class="ru-form">
        <x-textarea name="{{ $name }}[ru]" label="{{ $label }} | RU" :value="$value['ru'] ?? ''" :required="$required"/>
    </div>
    <div class="uz-form" style="display: none">
        <x-textarea name="{{ $name }}[uz]" label="{{ $label }} | UZ" :value="$value['uz'] ?? ''" :required="$required"/>
    </div>
    <div class="en-form" style="display: none">
        <x-textarea name="{{ $name }}[en]" label="{{ $label }} | EN" :value="$value['en'] ?? ''" :required="$required"/>
    </div>
</div>
