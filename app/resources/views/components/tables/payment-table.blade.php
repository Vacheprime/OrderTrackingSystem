@props(["payments" => $payments ?? []], "short" => false)

<table class="search-table">
    <thead>
    <tr>
        <th>PaymentID</th>
        <th>OrderID</th>
        <th>Date</th>
        <th>Amount</th>
    </tr>
    </thead>
    <tbody id="payments-tbody">
    @forelse($payments as $payment)
        <tr id="payment-id-{{$payment->getPaymentId()}}" onclick="">
            <td>{{$payment->getPaymentId()}}</td>
            <td>{{$payment->getOrder()->getOrderId()}}</td>
            <td>{{$payment->getPaymentDate() == null ? "null" : $payment->getPaymentDate()->format("Y/m/d")}}</td>
            <td>{{$payment->getAmount()}}</td>
        </tr>
    @empty
        <td colspan="{{$short ? 4 : 6}}" style="text-align: center;">
            <div class="order-table-td-div">No results!</div>
        </td>
    @endforelse
    </tbody>
</table>
