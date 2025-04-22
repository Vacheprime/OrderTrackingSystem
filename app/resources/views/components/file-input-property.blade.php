@props(['labelText' => "default", 'name' => "default", 'isLabel' => true])



<div class="file-input-property-div">
    @if($isLabel)
        <label id="{{$name}}-label" for="{{$name}}-input">{{$labelText}}:</label>
    @endif
    <input onchange="" accept="images/*" type="file"  id="{{$name}}-input"
           name="{{$name}}-input" placeholder="{{$labelText}}"/>
    <img alt="Inserted Image" id="{{$name}}-image" hidden src="#">
</div>

<script>
    const fileInput = document.getElementById("{{$name}}-input")
    const image = document.getElementById("{{$name}}-image")

    fileInput.addEventListener('change', (event) => {
        const files = event.target.files;
        let fr = new FileReader();
        fr.onload = () => {
            image.src = fr.result;
            image.attributes.removeNamedItem('hidden');
        }
        fr.readAsDataURL(files[0]);
    })
</script>
