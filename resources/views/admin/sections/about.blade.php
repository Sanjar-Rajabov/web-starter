@php use App\Enums\ImageInputTypesEnum; use App\Enums\ImageSizeEnum; @endphp
@extends('admin.layouts.app')
@section('title', 'О нас')
@section('section.about', 'active')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                О нас
            </div>
            @include('admin.inc.lang-tab')
            <div style="margin-top: 35px">
                <form action="{{ route('admin.section.update', $page) }}" enctype="multipart/form-data"
                      method="post">
                    @csrf
                    <input type="hidden" name="page" value="{{ $page }}">
                    <x-form-group-title title="Блок с баннером"/>
                    <x-image-input name="section-1[image]" label="Баннер"
                                   :value="$data['section-1']['image']"
                                   :type="ImageInputTypesEnum::Image"
                                   :size="ImageSizeEnum::Max"/>
                    <x-form-group-title title="Миссия компании"/>
                    <x-locale-text-editor name="mission[title]" label="Заголовок" :value="$data['mission']['title']" :toolbar="[['bold']]"/>
                    <x-form-group-title title="Кто мы?"/>
                    <x-locale-text-editor name="who-we-are[title]" label="Заголовок" :value="$data['who-we-are']['title']" :toolbar="[['bold']]"/>
                    <x-locale-textarea name="who-we-are[description]" label="О компании" :value="$data['who-we-are']['description']"/>
                    @include('admin.inc.submit-btn')
                </form>
            </div>
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
