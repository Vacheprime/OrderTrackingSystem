<link rel="stylesheet" href="{{ asset('css/clients.css') }}">
<link rel="stylesheet" href="{{ asset('css/table.css') }}">
<x-layout title="Edit Client">
    <h1 class="content-title">EDIT CLIENT</h1>
   <div class="content-container">
       <div id="client-create-content" class="main-content">
           <div class="create-edit-header">
               <a href="/clients" class="regular-button">Go Back</a>
               <h2>Client Information</h2>
               <div class="filler-div"></div>
           </div>
           <form id="create-edit-form" action="{{route("clients.update", $client->getClientId())}}" method="POST">
               @csrf
               @method("PUT")
               <div class="details-div">
                   <x-text-input-property labelText="First Name" name="first-name" :value="$client->getFirstName()"/>
                   <x-text-input-property labelText="Last Name" name="last-name" :value="$client->getLastName()"/>
                   <x-text-input-property labelText="Street" name="street" :value="$client->getAddress()->getStreetName()"/>
                   <x-text-input-property labelText="Apartment Number" name="apartment-number" :value="$client->getAddress()->getAppartmentNumber()"/>
                   <x-text-input-property labelText="Reference Number" name="reference-number" :value="$client->getClientReference()"/>
                   <x-text-input-property labelText="Phone Number" name="phone-number" :value="$client->getPhoneNumber()"/>
                   <x-text-input-property labelText="Postal Code" name="postal-code" :value="$client->getAddress()->getPostalCode()"/>
                   <x-text-input-property labelText="Area (Neighborhood)" name="area" :value="$client->getAddress()->getArea()"/>
               </div>
               <div class="action-input-div">
                   <button class="regular-button" type="submit">Save</button>
                   <a href="/clients" class="regular-button">Cancel</a>
               </div>
           </form>
       </div>
   </div>
</x-layout>
