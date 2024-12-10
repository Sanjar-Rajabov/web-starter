@php use App\Enums\FieldTypesEnum; @endphp
<section id="draggable-cards">
    <div class="row row-container" id="{{ $id }}-container">
        @foreach($values as $value)
            <div class="col-6 row">
                <div class="col-11">
                    @foreach($items as $item)
                        @switch($item->type)
                            @case(FieldTypesEnum::LocaleInput)
                                <x-locale-input name="{{ $name }}[{{ $loop->parent->index }}][{{ $item->name }}]"
                                                label="{{ $item->label }}" :value="$value[$item->name] ?? null"
                                                :required="$item->required"/>
                                @break
                            @case(FieldTypesEnum::LocaleTextarea)
                                <x-locale-textarea name="{{ $name }}[{{ $loop->parent->index }}][{{ $item->name }}]"
                                                   label="{{ $item->label }}" :value="$value[$item->name] ?? null"
                                                   :required="$item->required"/>
                                @break
                            @case(FieldTypesEnum::LocaleTextEditor)
                                <x-locale-text-editor name="{{ $name }}[{{ $loop->parent->index }}][{{ $item->name }}]"
                                                      label="{{ $item->label }}" :value="$value[$item->name] ?? null"
                                                      :required="$item->required"/>
                                @break
                            @case(FieldTypesEnum::ImageInput)
                                <x-image-input name="{{ $name }}[{{ $loop->parent->index }}][{{ $item->name }}]"
                                               label="{{ $item->label }}" :value="$value[$item->name] ?? null"
                                               :required="$item->required" :deletable="$item->imageIsDeletable"
                                               :type="$item->imageType"
                                               :size="$item->size"/>
                                @break
                            @case(FieldTypesEnum::LocaleImage)
                                <x-locale-image name="{{ $name }}[{{ $loop->parent->index }}][{{ $item->name }}]"
                                                label="{{ $item->label }}" :value="$value[$item->name] ?? null"
                                                :required="$item->required" :deletable="$item->imageIsDeletable"
                                                :type="$item->imageType"
                                                :size="$item->size"/>
                                @break
                            @case(FieldTypesEnum::TextInput)
                                <x-input name="{{ $name }}[{{ $loop->parent->index }}][{{ $item->name }}]"
                                         label="{{ $item->label }}" :value="$value[$item->name] ?? null"
                                         :required="$item->required"/>
                                @break
                            @case(FieldTypesEnum::Textarea)
                                <x-textarea name="{{ $name }}[{{ $loop->parent->index }}][{{ $item->name }}]"
                                            label="{{ $item->label }}" :value="$value[$item->name] ?? null"
                                            :required="$item->required"/>
                            @case(FieldTypesEnum::TextEditor)
                                <x-text-editor name="{{ $name }}[{{ $loop->parent->index }}][{{ $item->name }}]"
                                               label="{{ $item->label }}" :value="$value[$item->name] ?? null"
                                               :required="$item->required"/>
                                @break
                        @endswitch
                    @endforeach
                    <input type="hidden" name="{{ $name }}[{{ $loop->index }}][new_position]" class="form-item-position"
                           value="{{ $loop->index }}"/>
                    <input type="hidden" name="{{ $name }}[{{ $loop->index }}][old_position]"
                           value="{{ $loop->index }}"/>
                </div>
                <div class="col-1">
                    <button type="button" @if(!$dynamic) disabled
                            @endif class="btn btn-icon btn-danger btn-{{ $id }}-remove">
                        <i class="feather icon-trash"></i>
                    </button>
                </div>
            </div>
        @endforeach
        @if($dynamic)
            <div class="col-6 form-group no-drag">
                <button type="button" class="btn btn-icon btn-primary btn-{{ $id }}-add">
                    <i class="feather icon-plus"></i>
                    Добавить
                </button>
            </div>
        @endif
    </div>
</section>
@if ($draggable)
    @push('css')
        <style>
            #draggable-cards .row div {
                cursor: -webkit-grab;
                cursor: grab;
            }

            .no-drag {
                cursor: default !important;
            }
        </style>
    @endpush
@endif
@push('scripts')
    <script>
        document.querySelectorAll('button.btn-{{ $id }}-remove').forEach(element => {
            element.addEventListener('click', (event) => {
                deleteItem(event, document.querySelector('#{{ $id }}-container'), '{{ $min }}')

            })
        })

        document.querySelector('button.btn-{{ $id }}-add').addEventListener('click', function (event) {
            let listContainer = document.querySelector('#{{ $id }}-container')

            let max = Number('{{ $max }}')

            if (max && listContainer.querySelectorAll('.col-6.row').length >= max) {
                event.preventDefault()
                return
            }

            let container = event.currentTarget.parentElement.parentElement
            let index = container.children.length - 1

            let html = document.createElement("div");

            html.classList.add('col-6')
            html.classList.add('row')

            let itemGroup = document.createElement('div')
            itemGroup.classList.add('col-11')
            itemGroup.classList.add('row')

            let items = {!! json_encode(array_map(fn($item) => $item->toArray(), $items)) !!};

            let content = ''
            for (let item of items) {
                content += fields[item.type].replace(/:formName/g, '{{ $name }}').replace(/:label/g, item.label).replace(/:fieldName/g, item.name).replace(/:index/g, index)
            }

            html.innerHTML = `
            <div class="col-11">${content}
            <input type="hidden" name="{{ $name }}[${index}][new_position]" class="form-item-position" value="${index}"/>
            <input type="hidden" name="{{ $name }}[${index}][old_position]" value="${index}"/></div>
            <div class="col-1">
                <button type="button" class="btn btn-icon btn-danger btn-{{ $id }}-remove">
                    <i class="feather icon-trash"></i>
                </button>
            </div>
            `

            html.querySelectorAll('button.btn-{{ $id }}-remove').forEach(element => {
                element.addEventListener('click', function (event) {
                    deleteItem(event, listContainer, '{{ $min }}')
                })
            })

            @if (collect($items)->where('type', FieldTypesEnum::ImageInput)->count() > 0)
            html.querySelector('.custom-file-input').addEventListener('change', function (event) {
                readURL(this, event.target.parentElement.parentElement.children[1].firstElementChild)
            })
            @endif

            container.insertBefore(html, container.lastElementChild)

            for (let item of items) {
                if (item.type === 'TextEditor') {
                    makeNewQuill(`{{ $name }}-${index}-${item.name}`, item.label)
                } else if (item.type === 'LocaleTextEditor') {
                    makeNewQuill(`{{ $name }}-${index}-${item.name}-ru`, item.label)
                    makeNewQuill(`{{ $name }}-${index}-${item.name}-uz`, item.label)
                    makeNewQuill(`{{ $name }}-${index}-${item.name}-en`, item.label)
                }
            }
        })


        @if ($draggable)
        $(document).ready(function () {
            let drake = dragula([document.getElementById('{{ $id }}-container')], {
                moves: function (el, container, handle) {
                    return !el.classList.contains('no-drag');
                }
            });

            drake.on('drop', function (el, target, source, sibling) {
                document.querySelectorAll('#{{ $id }}-container input.form-item-position').forEach((input, number) => {
                    input.value = number
                })
            })
        });
        @endif
    </script>
@endpush
