<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>User Profile</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <script src="{{ asset('js/sidebar.js') }}"></script>
    </head>
    <body>
        <x-header/>
        <div class="separate">
            <x-test_sidebar/>
            <main>
                <x-usersettingspage/>
        </main>
</div>
    </body>
</html>
