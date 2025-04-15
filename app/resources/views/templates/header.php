<?php

namespace resources\views\templates;

class Header {

function render() {
    echo '
    <header>
        <img class="crownGraniteLogo" src="CrownGranite.png" alt="Crown Granite Logo">
        <select class="selectLanguage">
            <option value="en">En</option>
            <option value="fr">Fr</option>
        </select>
        <button class="logoutButton" onclick="">Log out</button>
    </header>
';
}
}