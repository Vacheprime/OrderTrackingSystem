<x-layout title="Settings">
    <h1 class="content-title">SETTINGS</h1>
    <div class="content-container">
        <div id="settings-content" class="main-content">
            <div id="settings-scroll-div">
                <div id="notification-div" class="settings-div">
                    <h3>Notification</h3>
                    <hr />
                    <div id="notification-settings" class="settings-options-div">
                        <label>Allow Email Notifications?</label>
                        <input id="notification-check" name="notification-check" type="checkbox">
                    </div>
                </div>
                <div id="notification-div" class="settings-div">
                    <h3>Appearance</h3>
                    <hr />
                    <div id="notification-settings" class="settings-options-div">
                        <label>Enable Dark mode</label>
                        <input id="notification-check" name="notification-check" type="checkbox">
                    </div>
                </div>
                <div id="notification-div" class="settings-div">
                    <h3>Help & Support</h3>
                    <hr />
                    <div id="notification-settings" class="settings-options-div">
                        <label>This is a help and support for questions or concerns</label>
                        <button type="button" class="regular-button" onclick="window.open('mailto:someone@example.com', '_blank')">Send Email</button>
                    </div>
                </div>
                <div id="notification-div" class="settings-div">
                    <h3>Privacy & Security</h3>
                    <hr />
                    <div id="notification-settings" class="settings-options-div">
                        <label>Trust this device</label>
                        <input id="notification-check" name="notification-check" type="checkbox">
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layout>