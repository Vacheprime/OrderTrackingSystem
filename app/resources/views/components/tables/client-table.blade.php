@props(["clients" => $clients ?? [], "short" => false])

<table class="search-table">
    <thead>
    <tr>
        <th>ClientID</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Phone Number</th>
        <th>Client Reference #</th>
    </tr>
    </thead>
    <tbody id="clients-tbody">
    @forelse($clients as $client)
        <tr id="client-id-{{$client->getClientId()}}" onclick="">
            <td>{{$client->getClientId()}}</td>
            <td>{{$client->getFirstName()}}</td>
            <td>{{$client->getLastName()}}</td>
            <td>{{$client->getClientReference()}}</td>
            <td>{{$client->getPhoneNumber()}}</td>
        </tr>
    @empty
        <td colspan="{{$short ? 4 : 5}}" style="text-align: center;">
            <div class="order-table-td-div">No results!</div>
        </td>
    @endforelse
    </tbody>
</table>
