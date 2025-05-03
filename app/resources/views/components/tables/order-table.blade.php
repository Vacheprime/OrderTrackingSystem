@props(["orders" => $orders ?? []])

<table class="search-table">
    <thead>
    <tr>
        <th>OrderID</th>
        <th>ClientID</th>
        <th>Reference Number</th>
        <th>Measured by</th>
        <th>Fabrication start date</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody id="orders-tbody">
    @forelse($orders as $order)
        <tr id="order-id-{{$order->getOrderId()}}" onclick="">
            <td>{{$order->getOrderId()}}</td>
            {{--                        <td>{{$order->getInvoiceNumber() == null ? "null" : "null"}}</td>--}}
            <td>{{$order->getClient()->getClientId()}}</td>
            <td>{{$order->getReferenceNumber()}}</td>
            <td>{{$order->getMeasuredBy()->getInitials()}}</td>
            <td>{{$order->getFabricationStartDate() == null ? "null" : $order->getFabricationStartDate()->format("Y -m -d")}}</td>
            <td class="status {{ strtolower($order->getStatus()->value) }}">
                {{$order->getStatus()->value}}
            </td>
        </tr>
    @empty
        <tr>
            <td>Empty</td>
            <td>Empty</td>
            <td>Empty</td>
            <td>Empty</td>
            <td>Empty</td>
            <td>Empty</td>
        </tr>
    @endforelse
    </tbody>
</table>
