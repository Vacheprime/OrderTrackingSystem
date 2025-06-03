@props(['labelText' => "default", 'name' => "default", 'isLabel' => true, 'password' => false, 'readonly' => false, 'value' => "", 'display' => true, 'disabled' => false])

<div class="text-input-property-div" @if(!$display) style="display: none;" @endif>
    @if($isLabel)
        <label id="{{$name}}-label" for="{{$name}}-input">{{$labelText}}</label>
    @endif
    <input {{$readonly ? "readonly" : ""}} type="{{$password ? "password": "text"}}" id="{{$name}}-input"
           name="{{$name}}" placeholder="{{$labelText}}" @if($value != "" && !$password) value="{{ $value }}" @elseif(!$password) value="{{ old($name) }}" @endif {{ $disabled ? "disabled" : "" }}/>
    
    @error("$name")
        <p class="error-input">{{$message}}</p>
    @enderror
</div>
