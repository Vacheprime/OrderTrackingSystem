<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css"/>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>

@props(['labelText' => "Fabrication Plan Image", 'name' => "default", 'isLabel' => true, 'value' => ""])

<div class="file-input-property-div">
    @if($isLabel)
        <label id="insertedImage-label" for="$name-input">{{$labelText}} :</label>
    @endif
    <input accept=".jpg,.png,.webp" type="file" id="{{$name.'-input'}}" name="{{$name.'-input'}}"
           placeholder="{{$labelText}}"/>
    <a id="fancybox-link" href="#" data-fancybox="gallery" hidden>
        <img alt="Fabrication Plan Image" id="{{$name.'-image'}}" class="insertedImage-image" hidden src="#">
    </a>
    @error("$name-input")
    <p class="error-input">{{$message}}</p>
    @enderror
</div>

<script>
    const fileInput = document.getElementById("{{$name.'-input'}}");
    const image = document.getElementById("{{$name.'-image'}}");
    const fancyboxLink = document.getElementById("fancybox-link");

    fileInput.addEventListener("change", (event) => {
        const files = event.target.files;
        let fr = new FileReader();
        fr.onload = () => {
            image.src = fr.result;
            fancyboxLink.href = fr.result;
            image.attributes.removeNamedItem("hidden");
            fancyboxLink.attributes.removeNamedItem("hidden");
        };
        fr.readAsDataURL(files[0]);
    });

    window.addEventListener("load", (event) => {
        const files = event.target.files;
        let fr = new FileReader();
        fr.onload = () => {
            image.src = fr.result;
            fancyboxLink.href = fr.result;
            image.attributes.removeNamedItem("hidden");
            fancyboxLink.attributes.removeNamedItem("hidden");
        };
        fr.readAsDataURL(files[0]);
    });
</script>
