<!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset="utf-8">
    <title>User Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite('resources/css/general.css')
</head>
<body>
<header>
    <header>
        <img class="crownGraniteLogo" src="CrownGranite.png" alt="Crown Granite Logo">
        <select class="selectLanguage">
            <option value="en">En</option>
            <option value="fr">Fr</option>
        </select>
    </header>
</header>
<main>
    @yield('main')
</main>
</body>
</html>
