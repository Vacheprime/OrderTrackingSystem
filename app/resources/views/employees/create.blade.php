<link rel="stylesheet" href="{{ asset('css/employees.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<x-layout title="Create Employee">
    <h1 class="content-title">CREATING EMPLOYEE</h1>
    <div class="content-container">
        <div id="employees-create-content" class="main-content">
            <div class="create-edit-header">
                <a href="/employees" class="regular-button">Go Back</a>
                <h2>Employee Information</h2>
                <div class="filler-div"></div>
            </div>
            <form action="/employees" method="POST" class="create-edit-form">
                @csrf
                <div class="details-div">
                    <x-text-input-property labelText="Initials" name="initials"/>
                    <x-text-input-property labelText="First Name" name="first-name"/>
                    <x-text-input-property labelText="Last Name" name="last-name"/>
                    <x-text-input-property labelText="Email" name="email"/>
                    <x-text-input-property labelText="Phone Number" name="phone-number"/>
                    <x-text-input-property labelText="Address" name="address"/>
                    <x-text-input-property labelText="Position" name="position"/>
                    <x-text-input-property labelText="Postal Code" name="postal-code"/>
                    <x-text-input-property labelText="Area" name="area"/>
                    <p><i class="fa-solid fa-circle-info"></i> Please note that created employee accounts are disabled by
                        default.</p>
                </div>

                <div class="action-input-div">
                    <button class="regular-button" type="submit">Create</button>
                    <a href="/employees" class="regular-button">Cancel</a>
                </div>
            </form>


        </div>
    </div>
</x-layout>
