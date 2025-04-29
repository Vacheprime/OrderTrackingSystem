@props(['labelText' => "default", 'name' => "default", 'isLabel' => true, 'password' => false, 'readonly' => false])

<div class="text-input-property-div">
    @if($isLabel)
        <label id="{{$name}}-label" for="{{$name}}-input">{{$labelText}}</label>
    @endif
    <input {{$readonly ? "readonly" : ""}} type="{{$password ? "password": "text"}}" id="{{$name}}-input"
           name="{{$name}}-input" placeholder="{{$labelText}}"/>
</div>
