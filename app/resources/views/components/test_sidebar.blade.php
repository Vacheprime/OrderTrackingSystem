<aside>
    <div>
        <button><img src="{{ asset('images/arrow_icon.png') }}"></button>
    </div>
    <hr/>
    <nav>
        <div>
            <x-test_nav-link href="{{url('/home')}}" img="{{url('/images/home_icon.png')}}"
                        :active="true">
                Home
            </x-test_nav-link>
            <x-test_nav-link href="{{url('/orders')}}" img="{{url('/images/order_icon.png')}}"
                        :active="false">
                Orders
            </x-test_nav-link>
            <x-test_nav-link href="{{url('/clients')}}" img="{{url('/images/client_icon.png')}}"
                        :active="false">
                Clients
            </x-test_nav-link>
            <x-test_nav-link href="{{url('/payments')}}" img="{{url('/images/payment_icon.png')}}"
                        :active="false">
                Payments
            </x-test_nav-link>
            
                <x-test_nav-link href="{{url('/employees')}}" img="{{url('/images/employee_icon.png')}}"
                            :active="true">
                    Employees
                </x-test_nav-link>
            
        </div>
        <hr>
        <div>
            <x-test_nav-link href="{{url('/account')}}" img="{{url('/images/account_icon.png')}}"
                        :active="false">
                Account
            </x-test_nav-link>
            <x-test_nav-link href="{{url('/settings')}}" img="{{url('/images/setting_icon.png')}}"
                        :active="false">
                Settings
            </x-test_nav-link>
        </div>
    </nav>
</aside>
