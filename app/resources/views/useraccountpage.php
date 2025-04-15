<?php

namespace resources\views;

class UserAccountPage {
    private function resetPassword() {
        echo "password reset"; #
    }

    private function requestModification() {
        echo "request modification";
    }

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


<div id='account-header' class='account-div'>
    <img/>
    <div id='account-header-content'>
        <p class='account-header-p'><b>Full Name:</b> $user->getFirstName() $user->getLastName()</p>
        <p class='account-header-p'><b>Employee ID:</b> $user->getEmployeeId()</p>
        <p class='account-header-p'><b>Account Creation:</b> $user->getHireDate()</p>
        <p class='account-header-p'><b>Department:</b> $user->getDepartment()</p>
        <p class='account-header-p'><b>User Title:</b> $user->getPosition()</p>
    </div>
</div>

<div id='account-details' class='account-div'>
    <h2 class='account-heading'>Account Details</h2>
    <div id='account-details-content'>
        <div id='first-name-div' class=\"account-input-div\">
            <label id='first-name-label' class='account-details-label' for='first-name-input'>First Name</label>
            <input id='first-name-input' class='account-details-input' name='first-name-input' placeholder=\"$user->getFirstName()\" readonly/>
        </div>
        <div id='last-name-div' class=\"account-input-div\">
            <label id='last-name-label' class='account-details-label' for='last-name-input'>First Name</label>
            <input id='last-name-input' class='account-details-input' name='last-name-input' placeholder=\"$user->getLastName()\" readonly/>
        </div>
        <div id='dob-name-div' class=\"account-input-div\">
            <label id='dob-name-label' class='account-details-label' for='dob-name-input'>First Name</label>
            <input id='dob-name-input' class='account-details-input' name='dob-name-input' placeholder=\"$user->getBirthDate()\" readonly/>
        </div>
        <div id='phone-name-div' class=\"account-input-div\">
            <label id='phone-name-label' class='account-details-label' for='phone-name-input'>First Name</label>
            <input id='phone-name-input' class='account-details-input' name='phone-name-input' placeholder=\"$user->getPhoneNumber()\" readonly/>
        </div>
        <div id='email-name-div' class=\"account-input-div\">
            <label id='email-name-label' class='account-details-label' for='email-name-input'>First Name</label>
            <input id='email-name-input' class='account-details-input' name='email-name-input' placeholder=\"$user->getEmail()\"  readonly/>
        </div>
        <div id='address-name-div' class=\"account-input-div\">
            <label id='address-name-label' class='account-details-label' for='address-name-input'>First Name</label>
            <input id='address-name-input' class='account-details-input' name='address-name-input' placeholder=\"$user->getAddress()\" readonly/>
        </div>
    </div>
</div>
    
<div id='account-password' class='account-div'>
    <h2 class='account-heading'>Passsword</h2>
    <div>
        <p class='account-div-description'></p>
        <div>
            <div id='address-name-div' class=\"account-input-div\">
                <label id='password-name-label' class='account-details-label' for='password-name-input'>First Name</label>
                <input id='password-name-input' class='account-details-input' name='password-name-input' placeholder=\"$user->getPassword()\" readonly/>
            </div>
            <button class='regular-button' onclick='resetPassword()'>Reset Password</button>
        </div>
    </div>
</div>

<div id='account-others' class='account-div'>
    <h2 class='account-heading'>Other</h2>
    <p class='account-div-description'></p>
    <button class='regular-button' onclick='requestModification()'>Request Modification</button>
</div>

</main>

</body>
</html>
        ";

        echo $html;
    }
}

### FOR TESTING
$class = (new UserAccountPage())->render();
###
?>
