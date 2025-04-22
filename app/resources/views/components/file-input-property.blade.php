@props(['labelText' => "default", 'name' => "default", 'isLabel' => true])

<script>
    const fileInput = document.getElementById("{{$name}}-input")
    const image = document.getElementById("{{$name}}-image")

    fileInput.addEventListener('onchange', (event) => {
        const [file] = fileInput.files;
        if (file) {
            image.attributes.removeNamedItem("hidden")
            image.src = URL.createObjectURL(file);
        }
    })
</script>

<div class="file-input-property-div">
    @if($isLabel)
        <label id="{{$name}}-label" for="{{$name}}-input">{{$labelText}}:</label>
    @endif
    <input onchange="" accept="images/*" type="file"  id="{{$name}}-input"
           name="{{$name}}-input" placeholder="{{$labelText}}"/>
    <img alt="Inserted Image" id="{{$name}}-image" hidden src="#">
</div>
