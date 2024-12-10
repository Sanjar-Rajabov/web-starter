<div>
    <div class="ru-form">
        <x-image-input name="{{ $name }}[ru]" label="{{ $label }} | RU" :value="$value['ru'] ?? ''"
                       :required="$required" :deletable="$deletable"/>
    </div>
    <div class="uz-form" style="display: none">
        <x-image-input name="{{ $name }}[uz]" label="{{ $label }} | UZ" :value="$value['uz'] ?? ''"
                       :required="$required" :deletable="$deletable"/>
    </div>
    <div class="en-form" style="display: none">
        <x-image-input name="{{ $name }}[en]" label="{{ $label }} | EN" :value="$value['en'] ?? ''"
                       :required="$required" :deletable="$deletable"/>
    </div>
</div>
