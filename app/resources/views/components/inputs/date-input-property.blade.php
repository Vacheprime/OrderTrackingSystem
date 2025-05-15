@props(['labelText' => "default", 'name' => "default", 'isLabel' => true, 'readonly' => false, 'value' => ""])

<div class="date-input-property-div">
    @if($isLabel)
        <label id="{{$name}}-label" for="{{$name}}-input">{{$labelText}}:</label>
    @endif
    <input {{$readonly ? "readonly" : ""}} type="date" id="{{$name}}-input" name="{{$name}}-input" value="{{ $value == "" ? old("$name-input") : $value }}"/>
    @error("$name")
    <p class="error-input">{{$message}}</p>
    @enderror
</div>

<script>
    document.querySelector("#{{$name}}-input").addEventListener("change", evt => {
        document.querySelector("#{{$name}}-input").value = evt.target.value;
    })
</script>
