<header>
    <img class="crownGraniteLogo" src="{{asset("images/logo.png")}}" alt="Crown Granite Logo">
    <select class="selectLanguage">
        <option value="en">En</option>
        <option value="fr">Fr</option>
    </select>
    {{--@auth--}}
    <a href="{{url('/logout')}}" class="regular-button">Logout</a>
    {{--@endauth--}}
</header>