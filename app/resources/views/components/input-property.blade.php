@props(['property' => "default", 'propertyName' => "default", 'label' => true, 'password' => false])

<div class="property-div">
    @if($label)
    <label id="{{$propertyName}}-label" for="{{$propertyName}}-input">{{$property}}:</label>
    @endif
    <input type="{{$password ? "password": "text"}}" id="{{$propertyName}}-input" name="{{$propertyName}}-input" placeholder="{{$property}}"/>
</div>
