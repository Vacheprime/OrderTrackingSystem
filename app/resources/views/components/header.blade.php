@props(["logout" => true])

<header>
    <img class="crownGraniteLogo" src="{{asset("images/logo.png")}}" alt="Crown Granite Logo">
    <select class="selectLanguage">
        <option value="en">En</option>
        <option value="fr">Fr</option>
    </select>
    @if($logout)
        <a href="{{url('/logout')}}" class="regular-button">Logout</a>
    @endif
</header>
