@props(["clients" => $clients ?? []])

<table class="search-table">
    <thead>
    <tr>
        <th>ClientID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Phone Number</th>
        <th>Client Reference #</th>
        <th>Phone</th>
        <th>Area</th>
    </tr>
    </thead>
    <tbody id="clients-tbody">
    @forelse($clients as $client)
        <tr id="client-id-{{$client->getClientId()}}" onclick="">
            <td>{{$client->getClientId()}}</td>
            <td>{{$client->getFirstName()}}</td>
            <td>{{$client->getLastName()}}</td>
            <td>{{$client->getAddress()->getAddressId() . $client->getAddress()->getStreetName()}}</td>
            <td>{{$client->getClientReference()}}</td>
            <td>{{$client->getPhoneNumber()}}</td>
            <td>{{$client->getAddress()->getArea()}}</td>
        </tr>
    @empty
        <tr>
            <td>Empty</td>
            <td>Empty</td>
            <td>Empty</td>
            <td>Empty</td>
        </tr>
    @endforelse
    </tbody>
</table>
