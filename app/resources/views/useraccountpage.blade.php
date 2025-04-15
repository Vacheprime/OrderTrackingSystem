@extends("layouts.default")

@section("main")
<div class="main-content">
    <div id="account-header" class="account-div">
        <img/>
        <div id="account-header-content">
            <p class="account-header-p"><b>Full Name:</b> {{$user->getFirstName()}} {{$user->getLastName()}}</p>
            <p class="account-header-p"><b>Employee ID:</b> {{$user->getEmployeeId()}}</p>
            <p class="account-header-p"><b>Account Creation:</b> {{$user->getHireDate()}}</p>
            <p class="account-header-p"><b>Department:</b> {{$user->getDepartment()}}</p>
            <p class="account-header-p"><b>User Title:</b> {{$user->getPosition()}}</p>
        </div>
    </div>

    <div id="account-details" class="account-div">
        <h2 class="account-heading">Account Details</h2>
        <hr/>
        <div id="account-details-content">
            <div id="first-name-div" class=\"account-input-div\">
                <label id="first-name-label" class="account-details-label" for="first-name-input">First Name</label>
                <input id="first-name-input" class="account-details-input" type="text" name="first-name-input" placeholder="{{$user->getFirstName()}}" readonly/>
            </div>
            <div id="last-name-div" class=\"account-input-div\">
                <label id="last-name-label" class="account-details-label" for="last-name-input">First Name</label>
                <input id="last-name-input" class="account-details-input" type="text" name="last-name-input" placeholder="{{$user->getLastName()}}" readonly/>
            </div>
            <div id="dob-name-div" class=\"account-input-div\">
                <label id="dob-name-label" class="account-details-label" for="dob-name-input">First Name</label>
                <input id="dob-name-input" class="account-details-input" type="text" name="dob-name-input" placeholder="{{$user->getBirthDate()}}" readonly/>
            </div>
            <div id="phone-name-div" class=\"account-input-div\">
                <label id="phone-name-label" class="account-details-label" for="phone-name-input">First Name</label>
                <input id="phone-name-input" class="account-details-input" type="text" name="phone-name-input" placeholder="{{$user->getPhoneNumber()}}" readonly/>
            </div>
            <div id="email-name-div" class=\"account-input-div\">
                <label id="email-name-label" class="account-details-label" for="email-name-input">First Name</label>
                <input id="email-name-input" class="account-details-input" type="text" name="email-name-input" placeholder="{{$user->getEmail()}}"  readonly/>
            </div>
            <div id="address-name-div" class=\"account-input-div\">
                <label id="address-name-label" class="account-details-label" for="address-name-input">First Name</label>
                <input id="address-name-input" class="account-details-input" type="text" name="address-name-input" placeholder="{{$user->getAddress()}}" readonly/>
            </div>
        </div>
    </div>

    <div id="account-password" class="account-div">
        <h2 class="account-heading">Password</h2>
        <hr/>
        <div>
            <p class="account-div-description"></p>
            <div>
                <div id="address-name-div" class=\"account-input-div\">
                    <label id="password-name-label" class="account-details-label" for="password-name-input">First Name</label>
                    <input id="password-name-input" class="account-details-input" type="text" name="password-name-input" placeholder="{{$user->getPassword()}}" readonly />
                </div>
                <a href="">
                    <button class="regular-button">Reset Password</button>
                </a>
            </div>
        </div>
    </div>

    <div id="account-others" class="account-div">
        <h2 class="account-heading">Other</h2>
        <hr/>
        <p class="account-div-description"></p>
        <button class="regular-button">Request Modification</button>
    </div>
</div>
@endsection
