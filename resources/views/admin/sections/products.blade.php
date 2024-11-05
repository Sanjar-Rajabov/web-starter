@extends('admin.layouts.app')
@section('title', 'Продукты')
@section('section.products', 'active')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                Продукты
            </div>
            @include('admin.inc.lang-tab')
            <form action="{{ route('admin.section.update', 'products') }}" enctype="multipart/form-data"
                  method="post">
                @csrf
                <input type="hidden" name="page" value="{{ 'products' }}">
                <x-form-group-title title="Первый блок"/>
                <x-locale-text-editor name="section-1[title]" label="Заголовок"
                                :value="$data['section-1']['title']" :toolbar="[['bold']]"/>
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
    @include('admin.inc.quill-scripts')
@endsection
