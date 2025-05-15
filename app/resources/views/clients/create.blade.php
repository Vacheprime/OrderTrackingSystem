<link rel="stylesheet" href="{{ asset('css/clients.css') }}">
<link rel="stylesheet" href="{{ asset('css/table.css') }}">

<x-layout title="Create Client">
   <div class="layout-container">
       <div class="main-content">
           <a href="{{url()->previous()}}"><button class="regular-button">Go Back</button></a>
           <h2>Create Client</h2>
           <hr/>
           <form action="/clients" method="POST">
               @csrf
               <div class="flex-input-div">
                   <x-text-input-property labelText="First Name" name="first-name"/>
                   <x-text-input-property labelText="Last Name" name="last-name"/>
                   <x-text-input-property labelText="Address" name="address"/>
                   <x-text-input-property labelText="Reference Number" name="reference-number"/>
                   <x-text-input-property labelText="Phone Number" name="phone-number"/>
                   <x-text-input-property labelText="Postal Code" name="postal-code"/>
                   <x-text-input-property labelText="City" name="city"/>
                   <x-text-input-property labelText="Province" name="province"/>
                   <x-text-input-property labelText="Area (Neighborhood)" name="area"/>
               </div>
               <div class="action-input-div">
                   <button class="regular-button" type="submit">Create</button>
                    <a href="/clients" class="regular-button">Cancel</a>
               </div>
           </form>
       </div>
   </div>
</x-layout>
