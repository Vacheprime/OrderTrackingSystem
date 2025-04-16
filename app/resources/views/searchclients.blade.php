@extends("layouts.default")

@section("main")
<div class="main-content">
    <div id="clients-table-div" class="table-div">
        <div id="clients-table-header" class="table-header-div">
            <form action="/clients">
                <input type="text">
                <select>
                    <option>None</option>
                </select>
                <input type="submit" value="Search"/>
            </form>
            <a href="/create-client">
                <button class="regular-button">Create Client</button>
            </a>
        </div>
        <div id="clients-table-content" class="table-content-div">
            <div id="clients-table-content-heading" class="table-content-heading">
                <p>Client ID</p>
                <p>First Name</p>
                <p>Last Name</p>
                <p>Reference</p>
                <p>Phone Number</p>
                <p>Postal Code</p>
            </div>
            @forelse($clients as $client)
                <div class="table-content-entry">
                    <p>{{$client.getClientId()}}</p>
                    <p>{{$client.getFirstName()}}</p>
                    <p>{{$client.getLastName()}}</p>
                    <p>{{$client.getClientReference()}}</p>
                    <p>{{$client.getPhoneNumber()}}</p>
                    <p>{{$client.getPostalCode()}}</p>
                </div>
            @empty
                <p>No Clients</p>
            @endforelse
        </div>
    </div>
</div>
<div class="side-content">
    <div id="clients-details-div" class="details-div">
        <h2>Viewing Client Details</h2>
        <hr/>
        <div id="client-details-scrollable" class="details-scrollable">
            <h3><span>CLIENT ID</span><span>0001</span></h3>
            <div id="personal-information-details" class="details-subsection">
                <h4>Personal Information</h4>
                <hr/>
                <p><span><b>First Name:</b></span> <span>John</span></p>
                <p><span><b>Last Name:</b></span> <span>Smith</span></p>
                <p><span><b>Client Reference:</b></span> <span>null</span></p>
                <p><span><b>Phone Number:</b></span> <span>121-121-1212</span></p>
                <p><span><b>Address:</b></span> <span>1212 av. Asada</span></p>
                <p><span><b>Postal Code:</b></span> <span>F3F 3F3</span></p>
                <p><span><b>City:</b></span> <span>Montreal</span></p>
                <p><span><b>Province:</b></span> <span>Quebec</span></p>
            </div>
            {{--            <div id="order-history-details" class="details-subsection">--}}
            {{--                <h4>Order History</h4>--}}
            {{--                <hr/>--}}
            {{--                <p><span><b>Orders from Client:</b></span> <a href="">View Orders</a></p>--}}
            {{--                @foreach ($orders as $order)--}}
            {{--                    <div class="order-div">--}}
            {{--                        <p><span><b>ORDER ID:</b></span>{{$order->getOrderId()}}<span></span></p>--}}
            {{--                    </div>--}}
            {{--                @endforeach--}}
            {{--            </div>--}}
            {{--            <div id="payments-details" class="details-subsection">--}}
            {{--                <h4>Payment History</h4>--}}
            {{--                <hr/>--}}
            {{--                <p><span><b>Payments from Client:</b></span> <a href="">View Payments</a></p>--}}
            {{--                @foreach ($payments as $payment)--}}
            {{--                    <div class="playment-div">--}}
            {{--                        <p><span><b>ORDER ID:</b></span>{{$payment->getPaymentId()}}<span></span></p>--}}
            {{--                    </div>--}}
            {{--                @endforeach--}}
            {{--            </div>--}}
        </div>
        <a href="/edit-client">
            <button class="regular-button">Edit Client</button>
        </a>
    </div>
</div>
@endsection
