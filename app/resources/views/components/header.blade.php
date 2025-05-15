@props(["logout" => true, "language" => false])

<header>
    <img class="crownGraniteLogo" src="{{asset("images/logo.png")}}" alt="Crown Granite Logo">
    <div>
        @if($language)
            <select class="selectLanguage" onchange="switchLanguage(this)">
                <option value="en" {{ session('lang', 'en') === 'en' ? 'selected' : '' }}>En</option>
                <option value="fr" {{ session('lang', 'en') === 'fr' ? 'selected' : '' }}>Fr</option>
            </select>
        @endif
        @if($logout)
            <form id="logout-form" action="/logout" method="POST">
                @csrf
                <button type="submit" class="regular-button">Logout</button>
            </form>
        @endif
    </div>
</header>

<script>
    function switchLanguage(dropdown) {
        const lang = dropdown.value;
        const url = new URL(window.location.href);
        url.searchParams.set('lang', lang);
        window.location.href = url.toString();
    }
</script>