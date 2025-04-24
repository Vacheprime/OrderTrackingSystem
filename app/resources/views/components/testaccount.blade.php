    <div class="main-content">
        <div id="account-header" class="account-div">
        <div class="drop-down-details">
        <h2 class="account-heading">Employee Details</h2>
        <button><img src="{{asset('images/down.png')}}"/></button>
        </div>
        <hr/>
            <div id="account-header-content">
                <p class="account-header-p"><b>Full Name</b> Jonah Smith</p>
                <p class="account-header-p"><b>Employee ID</b> 0001</p>
                <p class="account-header-p"><b>Account Creation</b> 4/20/2025</p>
                <p class="account-header-p"><b>Department</b> Finance</p>
                <p class="account-header-p"><b>User Title</b> Accountant</p>
            </div>
        </div>

        <div id="account-details" class="account-div">
        <div class="drop-down-details">
            <h2 class="account-heading">Account Details</h2>
            <button><img src="{{asset('images/down.png')}}"/></button>
        </div>
            <hr/>
            <div id="account-details-content">
                <div id="first-name-div" class="account-input-div">
                    <label id="first-name-label" class="account-details-label" for="first-name-input"><b> Name</b></label>
                    <input id="first-name-input" class="account-details-input" type="text" name="first-name-input"
                           placeholder="james" readonly/>
                </div>
                <div id="last-name-div" class="account-input-div">
                    <label id="last-name-label" class="account-details-label" for="last-name-input"><b>Last Name</b></label>
                    <input id="last-name-input" class="account-details-input" type="text" name="last-name-input"
                           placeholder="Smith" readonly/>
                </div>
                <div id="dob-name-div" class="account-input-div">
                    <label id="dob-name-label" class="account-details-label" for="dob-name-input"><b>Date of Birth</b></label>
                    <input id="dob-name-input" class="account-details-input" type="text" name="dob-name-input"
                           placeholder="july" readonly/>
                </div>
                <div id="phone-name-div" class="account-input-div">
                    <label id="phone-name-label" class="account-details-label" for="phone-name-input"><b>Phone Number</b></label>
                    <input id="phone-name-input" class="account-details-input" type="text" name="phone-name-input"
                           placeholder="123-1234567" readonly/>
                </div>
                <div id="email-name-div" class="account-input-div">
                    <label id="email-name-label" class="account-details-label" for="email-name-input"><b>Email</b></label>
                    <input id="email-name-input" class="account-details-input" type="text" name="email-name-input"
                           placeholder="john@gmail.com" readonly/>
                </div>
                <div id="address-name-div" class="account-input-div">
                    <label id="address-name-label" class="account-details-label" for="address-name-input"><b>Address</b>
                    </label>
                    <input id="address-name-input" class="account-details-input" type="text" name="address-name-input"
                           placeholder="123 heaven" readonly/>
                </div>
            </div>
        </div>

        <div id="account-password" class="account-div">
        <div class="drop-down-details">
            <h2 class="account-heading">Password</h2>
        </div>
            <hr/>
            <div>
                <p class="account-div-description">In certain cases, you may be required to reset your password to ensure continued access and account security. </p>
                <div>
                    <div id="address-name-div" class="account-input-div">
                        <label id="password-name-label" class="account-details-label" for="password-name-input">Current
                            Password
                        </label>
                        <input id="password-name-input" class="account-details-input" type="password"
                               name="password-name-input" placeholder="●●●●●" readonly/>
                    </div>
                    <a href="/reset-password">
                        <button class="regular-button">Reset Password</button>
                    </a>
                </div>
            </div>
        </div>

        <div id="account-others" class="account-div">
        <div class="drop-down-details">
            <h2 class="account-heading">Modification Permission</h2>
        </div>
            <hr/>
            <p class="account-div-description">To update any information in your account, please submit a request through the system or contact your administrator.</p>
            <a href="/reset-password">
                        <button class="regular-button">Reset Modification</button>
                    </a>
        </div>
    </div>
