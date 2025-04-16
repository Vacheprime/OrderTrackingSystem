@extends("layouts.default")

@section("main")
<div class="main-content">
    @if($isEdits)
        <h2>Edit Client</h2>
    @else
        <h2>Create Client</h2>
    @endif
    <hr/>
    {{--    If the user pressed Edit Client    --}}
    @if($isEdits)
        <form action="/clients/update" method="POST">
            <div class="flex-input-div">
                @foreach ($clientproperties as $property)
                    <div class="property-div">
                        <label id="{{$property}}-label" for="{{$property}}-input">{{$property}}</label>
                        <input id="{{$property}}-input" name="{{$property}}-input" placeholder="{{$property}}" value=""/>
                    </div>

                @endforeach
                {{-- Find a way to insert the values into the input --}}
                @php
                    $doc = new DOMDocument();
                    $doc->getElementById("clientId-input")->nodeValue = $client->getClientID();
                    $doc->getElementById("firstName-input")->nodeValue = $client->getFirstName();
                    $doc->getElementById("lastName-input")->nodeValue = $client->getLastName();
                    $doc->getElementById("address-input")->nodeValue = $client->getAddress()->getAddressId();
                    $doc->getElementById("clientReference-input")->nodeValue = $client->getClientReference();
                    $doc->getElementById("phoneNumber-input")->nodeValue = $client->getPhoneNumber();
                    $doc->getElementById("postalCode-input")->nodeValue = $client->getAddress()->getPostalCode();
        //                $doc->getElementById("city-input")->nodeValue = $client->getAddress()->getCity();
        //                $doc->getElementById("province-input")->nodeValue = $client->getClientID();
                @endphp
            </div>
            <input class="regular-button" value="Save"/>
            <a href="/clients"><button class="regular-button">Cancel</button></a>
        </form>
    {{--  If the user pressed Add Client  --}}
    @else
        <form action="/clients/create" method="POST">
            <div>
                @foreach($clientproperties as $property)
                    <div class="property-div">
                        <label id="{{$property}}-label" for="{{$property}}-input">{{$property}}</label>
                        <input id="{{$property}}-input" name="{{$property}}-input" placeholder="{{$property}}"/>
                    </div>
                @endforeach
            </div>
            <input class="regular-button" id="client-create-button" name="client-create-button" value="Create"/>
            <a href="/clients"><button class="regular-button">Cancel</button></a>
        </form>
    @endif
</div>
@endsection
