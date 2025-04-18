@props(['property' => "default", 'propertyName' => "default", 'label' => true])

<div class="property-div">
    @if($label)
    <label id="{{$propertyName}}-label" for="{{$propertyName}}-input">{{$property}}</label>
    @endif
    <input id="{{$propertyName}}-input" name="{{$propertyName}}-input" placeholder="{{$property}}"/>
</div>
