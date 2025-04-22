@props(["labelText" => "default", "name" => "default"])

<div class="select-input-property-div">
    @if($isLabel)
        <label id="{{$name}}-label" for="{{$name}}-select">{{$labelText}}</label>
    @endif
    <select id="{{$name}}-select" name="{{$name}}-select">
        {{$slot}}
    </select>
</div>
