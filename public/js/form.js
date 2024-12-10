const ALERT_TYPES = {
    success: 'success',
    danger: 'danger',
    warning: 'warning',
    info: 'info',
    primary: 'primary',
    secondary: 'secondary',
    dark: 'dark',
    light: 'light',
}

function formSubmitEvent(event) {
    event.preventDefault()

    checkRequiredInputs()

    clear()

    let form = event.currentTarget

    setLoaderByForm(form)

    let data = new FormData(form)

    let inputs = document.querySelectorAll('input[type=file]')

    for (let input of inputs) {
        if (!input.value) {
            data.set(input.name, input.hasAttribute('deleted') ? 'deleted' : '')
        }
    }

    fetch(form.action, {
        method: 'POST',
        body: data,
        headers: {
            'Accept': 'application/json'
        }
    }).then(async (res) => {
        if (res.redirected) {
            window.location.href = res.url
            return
        }
        let body = {}
        try {
            body = await res.json()
        } catch (error) {
            console.log(error)
        }

        if (body.data && body.data.redirected) {
            window.location.href = body.data.url
            return
        }

        if (res.ok) {
            console.log('everything is ok', res, body)

            success(body)
        } else {
            console.log('something went wrong', res, body)

            if (body.errors) {
                validationErrors(body)
            } else {
                somethingWentWrong(body)
            }
        }
    }).finally(() => {
        removeLoaderByForm(form)
    })
}

function submitButtonClickEvent(event) {
    checkRequiredInputs()
}

function dotToArrayString(str) {
    const parts = str.split('.');
    return parts[0] + parts.slice(1).map(part => `[${part}]`).join('');
}

function setLoaderByForm(form) {
    form.querySelector('button[type=submit]').setAttribute('disabled', 'true')
    form.querySelector('#loader').classList.remove('d-none')
}

function removeLoaderByForm(form) {
    form.querySelector('button[type=submit]').removeAttribute('disabled')
    form.querySelector('#loader').classList.add('d-none')
}

function clear() {
    document.querySelectorAll('.is-invalid').forEach(el => {
        el.classList.remove('is-invalid')
        el.nextElementSibling.innerHTML = ''
    })
    document.querySelector('#form-alert')?.remove()
}

function checkRequiredInputs() {
    let failed = false
    let inputs = [
        ...document.querySelectorAll('input[required]'),
        ...document.querySelectorAll('textarea[required]')
    ]

    for (let i = 0; i < inputs.length; i++) {
        if (!inputs[i].checkValidity()) {
            failed = true
            inputs[i].classList.add('is-invalid')
        }
    }

    if (failed) {
        validationErrors({errors: []})
    }
}

function validationErrors(body) {

    let list = []

    for (let error in body.errors) {
        // set error to every input
        let input = dotToArrayString(error)
        let el = document.getElementById(input)
        if (el) {
            el.classList.add('is-invalid')
        }

        for (let i in body.errors[error]) {
            list.push(`<li>${body.errors[error][i]}</li>`)
        }
    }
    let alert = `
            <i class="feather icon-alert-circle"></i> - Ошибка ввода данных!
            <br>
            Пожалуйста, проверьте все поля на всех языках, исправьте отмеченные красным поля и повторите попытку.
            ${list.length > 0 ? '<br><br>Ошибки:\n            <ul>:errors</ul>' : ''}
`
    alert = alert.replace(':errors', list.join(''))

    alertMessage(ALERT_TYPES.danger, alert)
}

function somethingWentWrong(body) {
    let error = body.message || JSON.stringify(body)
    let alert = `
            <i class="feather icon-alert-circle"></i> Что то пошло не так!
            <br>
            Проверьте введенные данные и попробуйте снова. Если это не поможет, обратитесь в поддержку.<br><br>
            Ошибка: ${error}
`

    alertMessage(ALERT_TYPES.danger, alert)
}

function success(body) {
    let alert = `
            <i class="feather icon-check-circle"></i> ${body.data}
        `

    alertMessage(ALERT_TYPES.success, alert)
}

function alertMessage(type, content) {
    if (Object.values(ALERT_TYPES).find(x => x === type) === undefined) {
        throw Error('Invalid error type. given type: ' + type + ', content: ' + content)
    }

    let element = document.createElement('div')
    element.classList.add('card', 'alert-' + type)
    element.id = 'form-alert'
    element.innerHTML = `
        <div class="card-body">
            ${content}
        </div>`
    document.querySelector('.content-body').prepend(element)
    window.scrollTo({top: 0, behavior: "smooth"});
}

function deleteImage(id, label) {
    id = id.replace('[', '\\[').replace(']', '\\]')
    let input = document.querySelector('#' + id)

    input.setAttribute('deleted', true)
    input.value = null
    document.querySelector('#' + id + '-label').textContent = label
    document.querySelector('#show-' + id).src = ''
}
