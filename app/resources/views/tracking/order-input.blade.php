<link rel="stylesheet" href="{{ asset('css/trackinginput.css') }}">
<link rel="stylesheet" href="{{ asset('css/clients.css') }}">

<x-tracking-layout title="Client Order Tracking">
    <div class="layout-container">
        <div id="track-content" class="content-container">
            <div class="main-content">
                <h2 data-i18n="trackOrder"></h2>
                <p data-i18n="inputMessage"></p>
                <form action="/tracking" method="POST">
                    @csrf
                    <div id="tracking-reference-div">
                        <x-text-input-property name="reference-number" :isLabel="false" :labelText="__('Reference Number')" />
                    </div>
                    <button class="regular-button" type="submit" data-i18n="trackOrder"></button>
                </form>
            </div>
        </div>
    </div>
</x-tracking-layout>
