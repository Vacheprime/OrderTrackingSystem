@props(['labelText' => "default", 'name' => "default", 'isLabel' => true, 'readonly' => false, 'value' => ""])

<div class="area-input-property-div">
    @if($isLabel)
        <label id="{{$name}}-label" for="{{$name}}-input">{{$labelText}}</label>
    @endif
    <textarea {{$readonly ? "readonly" : ""}} id="{{$name}}-input"
              name="{{$name}}" placeholder="{{$labelText}}">{{ $value == "" ? old($name) : $value }}</textarea>
    @error("$name")
    <p class="error-input">{{$message}}</p>
    @enderror
</div>
