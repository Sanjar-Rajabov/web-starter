<script src="{{ asset('js/form.js') }}"></script>
<script>
    $('#ru').on('click', function () {
        $('.ru-form').show()
        $('.en-form').hide()
        $('.uz-form').hide()
    })

    $('#uz').on('click', function () {
        $('.uz-form').show()
        $('.en-form').hide()
        $('.ru-form').hide()
    })

    $('#en').on('click', function () {
        $('.ru-form').hide()
        $('.en-form').show()
        $('.uz-form').hide()
    })

    document.querySelector('form').addEventListener('submit', formSubmitEvent)
    document.querySelector('form button[type="submit"]').addEventListener('click', submitButtonClickEvent)

    function deleteItem(event, listContainer, min = null) {
        let children = listContainer.querySelectorAll('.col-6.row')

        if (min && children.length <= min) {
            event.preventDefault()
            return
        }

        event.currentTarget.parentElement.parentElement.remove()
    }
</script>
