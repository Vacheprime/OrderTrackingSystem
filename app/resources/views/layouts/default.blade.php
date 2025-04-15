<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>User Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @vite("resources/css/general.css")
</head>
<body>
    <header>
        <header>
            <img class="crownGraniteLogo" src="CrownGranite.png" alt="Crown Granite Logo">
            <select class="selectLanguage">
                <option value="en">En</option>
                <option value="fr">Fr</option>
            </select>
            <button class="logoutButton" onclick="">Log out</button>
        </header>
    </header>
    <aside>
        <div class="sidebar">
            <a href="">
                <img src="resources/views/images/Minimize.png" alt="minimizeIcon">
            </a>
            <hr class="separator">
            <ul>
                <li>
                    <div>
                        <img class="homeIcon" src="homeIcon.png" alt="Home icon">
                        <p>Home</p>
                    </div>
                </li>
                <li>
                    <div>
                        <img class="ordersIcon" src="ordersIcon.png" alt="Orders icon">
                        <p>Orders</p>
                    </div>
                </li>
                <li>
                    <div>
                        <img class="clientsIcon" src="clientsIcon.png" alt="Clients icon">
                        <p>Clients</p>
                    </div>
                </li>
                <li>
                    <div>
                        <img class="paymentsIcon" src="paymentsIcon.png" alt="Payments icon">
                        <p>Payments</p>
                    </div>
                </li>
                <li>
                    <div>
                        <img class="employeesIcon" src="employeesIcon.png" alt="Employees icon">
                        <p>Employees</p>
                    </div>
                </li>
            </ul>
            <hr class="separator">
            <div class="settings">
                <li>
                    <div>
                        <img class="settingsIcon" src="settingsIcon.png" alt="Settings icon">
                        <p>Settings</p>
                    </div>
                </li>
                <li>
                    <div>
                        <img class="AccountIcon" src="AccountIcon.png" alt="Account icon">
                        <p>Account</p>
                    </div>
                </li>
            </div>
        </div>
    </aside>
    <main>
        @yield("main")
    </main>
</body>
</html>
