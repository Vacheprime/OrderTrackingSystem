<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.css"/>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>

@props(['labelText' => "Fabrication Plan Image", 'name' => "default", 'isLabel' => true])

<div class="file-input-property-div">
    @if($isLabel)
        <label id="insertedImage-label" for="insertedImage-input">{{$labelText}}:</label>
    @endif
    <input onchange="" accept=".jpg,.png,.heic,.webp" type="file" id="insertedImage-input" name="insertedImage-input"
           placeholder="{{$labelText}}"/>
    <a id="fancybox-link" href="#" data-fancybox="gallery" hidden>
        <img alt="Inserted Image" id="insertedImage-image" class="insertedImage-image" hidden src="#">
    </a>
    @error("$name")
    <p class="error-input">{{$message}}</p>
    @enderror
</div>

<script>
    const fileInput = document.getElementById("insertedImage-input");
    const image = document.getElementById("insertedImage-image");
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
</script>
