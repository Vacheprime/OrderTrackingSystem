<?php
namespace resources\views;

class UserSettingsPage {
    public function render() {
        $user = ""; ### TODO: implement get logged in user in UserAccountPage
        $header = new Header(); ### TODO: implement header in UserAccountPage
        $sidebar = $user->isAdmin()? new SidebarAdmin() : new SidebarEmployee; ### TODO: implement sidebar in UserAccountPage

        $html = "
<!DOCTYPE html>
<html lang='en'>
<head>

</head>
<body>
$header->render();

<aside>
$sidebar->render()
</aside>

<main>
<div class='main-content'>
    <h2>Settings</h2>
    <div id='settings-scroll-div'>
        <div id='notification-div' class='settings-div'>
            <h3>Notification</h3>
            <hr/>
            <div id='notification-settings' class='settings-options-div'>
                <label>Allow Email Notifiaction?</label>
                <input id='notification-check' name='notification-check' type='checkbox'>
            </div>
        </div>
        <div id='notification-div' class='settings-div'>
            <h3>Appearance</h3>
            <hr/>
            <div id='notification-settings' class='settings-options-div'>
                <label>Allow Email Notifiaction?</label>
                <input id='notification-check' name='notification-check' type='checkbox'>
            </div>
        </div>
        <div id='notification-div' class='settings-div'>
            <h3>Help & Support</h3>
            <hr/>
            <div id='notification-settings' class='settings-options-div'>
                <label>Allow Email Notifiaction?</label>
                <input id='notification-check' name='notification-check' type='checkbox'>
            </div>
        </div>
        <div id='notification-div' class='settings-div'>
            <h3>Privacy & Security</h3>
            <hr/>
            <div id='notification-settings' class='settings-options-div'>
                <label>Allow Email Notifiaction?</label>
                <input id='notification-check' name='notification-check' type='checkbox'>
            </div>
        </div>
    </div>
</div>
</main>

</body>
</html>
        ";

        echo $html;
    }
}

?>