<script>
    const fields = {
        LocaleInput: `<x-locale-input name=":formName[:index][:fieldName]" label=":label"/>`,
        LocaleTextarea: `<x-locale-textarea name=":formName[:index][:fieldName]" label=":label"/>`,
        LocaleTextEditor: `<x-locale-text-editor name=":formName[:index][:fieldName]" label=":label"/>`,
        ImageInput: `<x-image-input name=":formName[:index][:fieldName]" label=":label"/>`,
        LocaleImage: `<x-locale-image name=":formName[:index][:fieldName]" label=":label"/>`,
        ImageInputDeletable: `<x-image-input name=":formName[:index][:fieldName]" label=":label" :deletable="true"/>`,
        LocaleImageDeletable: `<x-locale-image name=":formName[:index][:fieldName]" label=":label" :deletable="true"/>`,
        TextInput: `<x-input name=":formName[:index][:fieldName]" label=":label"/>`,
        Textarea: `<x-textarea name=":formName[:index][:fieldName]" label=":label"/>`,
        TextEditor: `<x-text-editor name=":formName[:index][:fieldName]" label=":label"/>`,
    }
</script>

<script src="{{ asset('app-assets/vendors/js/extensions/dragula.min.js') }}"></script>
<script src="{{ asset('app-assets/js/scripts/extensions/drag-drop.js') }}"></script>
