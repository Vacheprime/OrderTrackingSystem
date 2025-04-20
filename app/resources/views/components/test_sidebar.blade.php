<aside id="sidebar" class="sidebar">
    <div>
        <button id="button" onclick="shrink()"><img src="{{url('/images/arrow_icon.png')}}"></button>
    </div>
    <hr/>
    <nav>
        <div>
            <x-test_nav-link href="{{url('/home')}}" img="{{url('/images/home_icon.png')}}"
                        :active="request()->is('orders')">
                Home
            </x-test_nav-link>
            <x-test_nav-link href="{{url('/orders')}}" img="{{url('/images/order_icon.png')}}"
                        :active="request()->is('orders')">
                Orders
            </x-test_nav-link>
            <x-test_nav-link href="{{url('/clients')}}" img="{{url('/images/client_icon.png')}}"
                        :active="request()->is('clients')">
                Clients
            </x-test_nav-link>
            <x-test_nav-link href="{{url('/payments')}}" img="{{url('/images/payment_icon.png')}}"
                        :active="request()->is('payments')">
                Payments
            </x-test_nav-link>
            
                <x-test_nav-link href="{{url('/employees')}}" img="{{url('/images/employee_icon.png')}}"
                            :active="request()->is('/employees')">
                    Employees
                </x-test_nav-link>
            
        </div>
        <div>
        <hr>
            <x-test_nav-link href="{{url('/account')}}" img="{{url('/images/account_icon.png')}}"
                        :active="request()->is('/account')">
                Account
            </x-test_nav-link>
            <x-test_nav-link href="{{url('/settings')}}" img="{{url('/images/setting_icon.png')}}"
                        :active="request()->is('/settings')">
                Settings
            </x-test_nav-link>
        </div>
    </nav>
</aside>