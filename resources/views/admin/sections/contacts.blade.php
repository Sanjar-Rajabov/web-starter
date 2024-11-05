@php use App\DTO\FormListItem;use App\Enums\FieldTypesEnum; use App\Enums\ImageSizeEnum; @endphp
@extends('admin.layouts.app')
@section('title', 'Контакты')
@section('section.contacts', 'active')

@section('content')
    <div class="card">
        <div class="card-body">
            <div class="card-title">
                Контакты
            </div>
            @include('admin.inc.lang-tab')
            <div style="margin-top: 35px">
                <form action="{{ route('admin.section.update', $page) }}" enctype="multipart/form-data"
                      method="post">
                    @csrf
                    <input type="hidden" name="page" value="{{ $page }}">
                    <x-locale-textarea name="address" label="Адрес" :value="$data['address']"/>
                    <x-input name="phone" label="Номер телефона" :value="$data['phone']"/>
                    <x-input name="email" label="Email" :value="$data['email']"/>
                    <x-form-list name="socials" :items="[
                        new FormListItem(FieldTypesEnum::TextInput, 'link', 'Ссылка'),
                        new FormListItem(FieldTypesEnum::ImageInput, 'icon', 'Иконка', size: ImageSizeEnum::Small),
                    ]" :values="$data['socials']"/>
                    <div class="form-group">
                        <div id="map" style="height: 300px;"></div>
                        <input type="hidden" name="location[lat]" id="lat" value="{{ $data['location']['lat'] }}">
                        <input type="hidden" name="location[lng]" id="lng" value="{{ $data['location']['lng'] }}">
                    </div>
                    <x-form-group-title title="Форма"/>
                    <x-locale-text-editor name="form[title]" label="Заголовок" :value="$data['form']['title']" :toolbar="[['bold']]"/>

                    @include('admin.inc.submit-btn')
                </form>
            </div>
        </div>
    </div>
@endsection

@section('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
    @include('admin.inc.quill-styles')
@endsection

@section('script')
    @include('admin.inc.form')
    @include('admin.inc.form-list-fields')
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    <script>
        let coordinates = [{{ $data['location']['lat'] }}, {{ $data['location']['lng'] }}]
        const map = L.map('map').setView(coordinates, 13);

        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        let marker = L.marker(coordinates, {
            color: 'red',
            fillColor: '#f03',
            fillOpacity: 0.5,
            radius: 500
        }).addTo(map)

        map.on('click', function (e) {
            map.removeLayer(marker)
            marker = L.marker(e.latlng, {
                color: 'red',
                fillColor: '#f03',
                fillOpacity: 0.5,
                radius: 500
            }).addTo(map)
            document.getElementById('lat').value = e.latlng.lat
            document.getElementById('lng').value = e.latlng.lng
            console.log(e.latlng)
        })
    </script>
    @include('admin.inc.quill-scripts')
@endsection
