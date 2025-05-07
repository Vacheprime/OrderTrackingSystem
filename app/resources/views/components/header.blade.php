@props(["logout" => true, "language" => false])

<header>
    <img class="crownGraniteLogo" src="{{asset("images/logo.png")}}" alt="Crown Granite Logo">
    <div>
        @if($language)
            <select class="selectLanguage">
                <option value="en">En</option>
                <option value="fr">Fr</option>
            </select>
        @endif
        @if($logout)
            <a href="{{url('/logout')}}" class="regular-button">Logout</a>
        @endif
    </div>
</header>
