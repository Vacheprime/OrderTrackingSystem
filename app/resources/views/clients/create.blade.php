<link rel="stylesheet" href="{{ asset('css/clients.css') }}">
<link rel="stylesheet" href="{{ asset('css/table.css') }}">
<x-layout>
   <div class="layout-container">
       <div class="main-content">
           <a href="{{url()->previous()}}"><button>Go Back</button></a>
           <h2>Create Client</h2>
           <hr/>
           <form action="/clients/update" method="POST">
               <div class="flex-input-div">
                   <x-text-input-property property="First Name" propertyName="first-name"/>
                   <x-text-input-property property="Last Name" propertyName="last-name"/>
                   <x-text-input-property property="Address" propertyName="address"/>
                   <x-text-input-property property="Reference Number" propertyName="reference-number"/>
                   <x-text-input-property property="Phone Number" propertyName="phone-number"/>
                   <x-text-input-property property="Postal Code" propertyName="postal-code"/>
                   <x-text-input-property property="City" propertyName="city"/>
                   <x-text-input-property property="Province" propertyName="province"/>
                   <x-text-input-property property="Area (Neighborhood)" propertyName="area"/>
               </div>
               <input class="regular-button" value="Create"/>
           </form>
           <a href="/clients">
               <button class="regular-button">Cancel</button>
           </a>
       </div>
   </div>
</x-layout>
