@php use App\DTO\FormListItem;use App\Enums\FieldTypesEnum;use App\Enums\ImageInputTypesEnum; use App\Enums\ImageSizeEnum; @endphp
@extends('admin.layouts.app')
@section('title', 'Главная')
@section('section.home', 'active')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                Главная
            </div>
            @include('admin.inc.lang-tab')
            <form action="{{ route('admin.section.update', 'home') }}" enctype="multipart/form-data"
                  method="post">
                @csrf
                <input type="hidden" name="page" value="{{ 'home' }}">
                <x-form-group-title title="Блок с баннером"/>
                <x-locale-textarea name="section-1[title]" label="Заголовок"
                                :value="$data['section-1']['title']"/>
                <x-image-input name="section-1[preview_image]" label="Изображение для мобильных устройств | Превью"
                               :value="$data['section-1']['preview_image']"
                               :type="ImageInputTypesEnum::Image"
                               :size="ImageSizeEnum::High"
                />
                <x-image-input name="section-1[media_file]" label="Баннер | Видео"
                               :value="$data['section-1']['media_file']"
                               :type="ImageInputTypesEnum::MediaFile"
                               :size="ImageSizeEnum::Max"
                />
                <x-form-group-title title="О компании"/>
                <x-locale-text-editor name="about[title]" label="Заголовок" :value="$data['about']['title']" :toolbar="[['bold']]"/>
                <x-locale-textarea name="about[description]" label="О компании" :value="$data['about']['description']" :required="true"/>
                <x-form-list name="about[items]"
                             :items="[
                                new FormListItem(FieldTypesEnum::ImageInput, 'icon', 'Иконка', required: false, size: ImageSizeEnum::Small),
                                new FormListItem(FieldTypesEnum::LocaleInput, 'title', 'Заголовок', required: true),
                                new FormListItem(FieldTypesEnum::LocaleTextarea, 'description', 'Описание', required: true)
                             ]"
                             :values="$data['about']['items']"
                             id="about_items"
                             :dynamic="false"
                />
                <x-form-group-title title="Форма"/>
                <x-locale-text-editor name="form[title]" label="Заголовок" :value="$data['form']['title']" :toolbar="[['bold']]"/>
                <x-locale-textarea name="form[description]" label="О компании" :value="$data['form']['description']" :required="true"/>
                @include('admin.inc.submit-btn')
            </form>
        </div>
    </div>
@endsection
@section('styles')
    @include('admin.inc.quill-styles')
@endsection

@section('script')
    @include('admin.inc.form')
    @include('admin.inc.form-list-fields')
    @include('admin.inc.quill-scripts')
@endsection
