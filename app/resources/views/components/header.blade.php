@props(['loggedin' => true])

<header>
    <img class="crownGraniteLogo" src="CrownGranite.png" alt="Crown Granite Logo">
    <select class="selectLanguage">
        <option value="en">En</option>
        <option value="fr">Fr</option>
    </select>
    @if($loggedin)
        <a href="{{url('/logout')}}" class="regular-button">Logout</a>
    @endif
</header>
