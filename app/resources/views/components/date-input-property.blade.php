@props(['labelText' => "default", 'name' => "default", 'isLabel' => true, 'readonly' => false])

<div class="date-input-property-div">
    @if($isLabel)
        <label id="{{$name}}-label" for="{{$name}}-input">{{$labelText}}:</label>
    @endif
    <input {{$readonly ? "readonly" : ""}} type="date" id="{{$name}}-input" name="{{$name}}-input"/>
</div>
