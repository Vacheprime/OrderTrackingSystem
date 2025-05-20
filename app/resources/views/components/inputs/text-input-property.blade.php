@props(['labelText' => "default", 'name' => "default", 'isLabel' => true, 'password' => false, 'readonly' => false, 'value' => "", "display" => true])

@php
    $displayStyle = "";
    if (!$display) {
        $displayStyle = "style=\"display: none;\"";
    }
@endphp

<p>{{var_dump($display)}}</p>
<div class="text-input-property-div" {{ $displayStyle }}>
    @if($isLabel)
        <label id="{{$name}}-label" for="{{$name}}-input">{{$labelText}}</label>
    @endif
    <input {{$readonly ? "readonly" : ""}} type="{{$password ? "password": "text"}}" id="{{$name}}-input"
           name="{{$name}}" placeholder="{{$labelText}}" value="{{ $value == "" ? old($name) : $value }}"/>
    @error("$name")
        <p class="error-input">{{$message}}</p>
    @enderror
</div>
