<link rel="stylesheet" href="{{ asset('css/clients.css') }}">
<link rel="stylesheet" href="{{ asset('css/employee.css') }}">
<link rel="stylesheet" href="{{ asset('css/table.css') }}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="{{ asset('css/orders.css') }}">

<x-layout title="Create Employee">
<div class="layout-container">
       <div class="main-content">
            <a href="{{url()->previous()}}"><button class="regular-button">Go Back</button></a>
            <h2>Create Employee</h2>
            <hr/>
            <form action="/employee/store" method="POST">
                <div class="flex-input-div">
                    <x-text-input-property labelText="Initials" name="initials"/>
                    <x-text-input-property labelText="First Name" name="first-name"/>
                    <x-text-input-property labelText="Last Name" name="last-name"/>
                    <x-text-input-property labelText="Email" name="last-name"/>
                    <x-text-input-property labelText="Phone Number" name="phone-number"/>
                    <x-date-input-property labelText="Hired Date" name="hire-date" />
                    <x-text-input-property labelText="Address" name="address"/>
                    <x-text-input-property labelText="Postal Code" name="postal-code"/>
                    <x-text-input-property labelText="City" name="city"/>
                    <x-text-input-property labelText="Province" name="province"/>
                    <x-text-input-property labelText="Area (Neighborhood)" name="area"/>
                </div>

                <div class="action-input-div">
                    <input class="regular-button" type="submit" value="Create"/>
                    <a href="/employees">
                        <button class="regular-button">Cancel</button>
                    </a>
               </div>
            </form>
            
            <p><i class="fa-solid fa-circle-info"></i> Please note that created employee accounts are disabled by default.</p>
        </div>
    </div>
</x-layout>
