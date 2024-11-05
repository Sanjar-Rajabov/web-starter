<div>
    <div class="ru-form">
        <x-text-editor name="{{ $name }}[ru]" label="{{ $label }} | RU" :value="$value['ru'] ?? ''"
                       :required="$required" id="{{ $id }}[ru]" :toolbar="$toolbar"/>
    </div>
    <div class="uz-form" style="display: none">
        <x-text-editor name="{{ $name }}[uz]" label="{{ $label }} | UZ" :value="$value['uz'] ?? ''"
                       :required="$required" id="{{ $id }}[uz]" :toolbar="$toolbar"/>
    </div>
    <div class="en-form" style="display: none">
        <x-text-editor name="{{ $name }}[en]" label="{{ $label }} | EN" :value="$value['en'] ?? ''"
                       :required="$required" id="{{ $id }}[en]" :toolbar="$toolbar"/>
    </div>
</div>
