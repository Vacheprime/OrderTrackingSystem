<aside id="sidebar" class="sidebar">
    <div id="sidebar-arrow-div">
        <button id="sidebar-arrow"><img src="{{url('images/arrow_icon.png')}}"></button>
    </div>
    <hr/>
    <nav>
        <div>
            <x-nav-link href="{{url('/home')}}" img="{{url('images/home_icon.png')}}"
                        :active="request()->is('/home')">
                Home
            </x-nav-link>
            <x-nav-link href="{{url('/orders')}}" img="{{url('images/order_icon.png')}}"
                        :active="request()->is('/orders')">
                Orders
            </x-nav-link>
            <x-nav-link href="{{url('/clients')}}" img="{{url('images/client_icon.png')}}"
                        :active="request()->is('/clients')">
                Clients
            </x-nav-link>
            <x-nav-link href="{{url('/payments')}}" img="{{url('images/payment_icon.png')}}"
                        :active="request()->is('/payments')">
                Payments
            </x-nav-link>
            @if(session()->has('employee') && session()->get('employee')['isEmployeeAdmin'])
                <x-nav-link href="{{url('/employees')}}" img="{{url('images/employee_icon.png')}}"
                            :active="request()->is('/employees')">
                    Employees
                </x-nav-link>
            @endif
        </div>
        <div>
            <hr>
            <x-nav-link href="{{url('/account')}}" img="{{url('images/account_icon.png')}}"
                        :active="request()->is('/account')">
                Account
            </x-nav-link>
{{--            <x-nav-link href="{{url('/settings')}}" img="{{url('images/setting_icon.png')}}"--}}
{{--                        :active="request()->is('/settings')">--}}
{{--                Settings--}}
{{--            </x-nav-link>--}}
        </div>
    </nav>
</aside>
