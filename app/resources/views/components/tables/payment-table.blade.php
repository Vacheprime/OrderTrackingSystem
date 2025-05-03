@props(["payments" => $payments ?? []])

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
            <td>{{$payment->getPaymentDate() == null ? "null" : $payment->getPaymentDate()->format("Y -m -d")}}</td>
            <td>{{$payment->getAmount()}}</td>
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
