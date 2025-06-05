@props(["labelText" => "default", "name" => "default", 'isLabel' => true, "value" => "", 'disabled' => false])

<div class="select-input-property-div" >
    @if($isLabel)
        <label id="{{$name}}-label" for="{{$name}}-select">{{$labelText}}:</label>
    @endif
    <select id="{{$name}}-select" name="{{$name}}-select" @disabled($disabled)>
        {{$slot}}
    </select>
    @error("$name-select")
        <p class="error-input">{{$message}}</p>
    @enderror
</div>
