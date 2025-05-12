@props(["orders" => $orders ?? [], "short" => $short ?? false])

<table class="search-table">
    <thead>
    <tr>
        <th><div class="order-table-th-div">OrderID</div></th>
        <th><div class="order-table-th-div">ClientID</div></th>
        <th><div class="order-table-th-div">Measured by</div></th>
        <th><div class="order-table-th-div">Status</div></th>
        @if(!$short) 
            <th><div class="order-table-th-div">Reference Number</div></th>
            <th><div class="order-table-th-div">Fabrication start date (Y/M/D)</div></th>
        @endif
    </tr>
    </thead>
    <tbody id="orders-tbody">
    @forelse($orders as $order)
        <tr id="order-id-{{$order->getOrderId()}}" onclick="">
            <td>
                <div class="order-table-td-div">{{$order->getOrderId()}}</div>
            </td>
            <td>
                <div class="order-table-td-div">{{$order->getClient()->getClientId()}}</div>
            </td>
            <td>
                <div class="order-table-td-div">{{$order->getMeasuredBy()->getInitials()}}</div>
            </td>
            <td class="status {{ strtolower($order->getStatus()->value) }}">
                <div class="order-table-td-div">{{$order->getStatus()->value}}</div>
            </td>
            @if(!$short)
            <td>
                <div class="order-table-td-div">{{$order->getReferenceNumber()}}</div>
            </td>
            <td>
                <div class="order-table-td-div">
                    {{$order->getFabricationStartDate() == null ? "null" : $order->getFabricationStartDate()->format("Y / m / d")}}
                </div>
            </td>
            @endif
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
