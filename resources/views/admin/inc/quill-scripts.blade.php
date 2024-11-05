<script src="{{ asset('libs/quill/quill.js') }}"></script>
<script>
    function makeNewQuill(id, label, toolbar = []) {
        if (toolbar.length === 0) {
            toolbar = [
                [{'header': [1, 2, false]}],
                ['bold', 'italic', 'underline', 'strike', 'blockquote'],
                [{'list': 'ordered'}, {'list': 'bullet'}, {'indent': '-1'}, {'indent': '+1'}],
                ['link', 'image'],
                ['clean']
            ]
        }

        // console.log(toolbar)

        let quill = new Quill('#' + id, {
            modules: {
                toolbar: toolbar
            },
            placeholder: label,
            theme: 'snow'  // or 'bubble'
        });

        quill.on('text-change', function (delta, oldDelta, source) {
            document.getElementById(id + '-input').value = quill.root.innerHTML
        });
    }
</script>
