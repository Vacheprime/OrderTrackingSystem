<link rel="stylesheet" href="{{ asset('css/orders.css') }}">

<x-layout>
    <h1 class="content-title">ORDER MANAGEMENT</h1>
    <div class="content-container">
        <div id="orders-content" class="main-content">
            <a href="{{url()->previous()}}"><button>Go Back</button></a>
            <form action="" class="create-edit-form">
                <h2 class="title">Edit Payment</h2>
                <x-input-property property="Order ID" propertyName="order-id"/>
                <div>
                    <label for="date">Date</label>
                    <input type="date" id="date" name="date">
                </div>
                <x-input-property property="Amount" propertyName="amount"/>
                <x-input-property property="Type" propertyName="type"/>
                <x-input-property property="Method" propertyName="method"/>
                <input type="submit" value="Save"/>
            </form>
            <a href="{{url()->previous()}}"><button>Cancel</button></a>
        </div>
    </div>
</x-layout>
