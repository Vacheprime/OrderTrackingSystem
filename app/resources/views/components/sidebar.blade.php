@props(['admin' => false])

<aside>
    <div>
        <button><img src="{{url('public/images/arrow_icon.png')}}"></button>
    </div>
    <hr/>
    <nav>
        <div>
            <x-nav-link href="{{url('/home')}}" img="{{url('public/images/home_icon.png')}}"
                        :active="{{request()->is("/home")}}">
                Home
            </x-nav-link>
            <x-nav-link href="{{url('/orders')}}" img="{{url('public/images/home_icon.png')}}"
                        :active="{{request()->is("/orders")}}">
                Orders
            </x-nav-link>
            <x-nav-link href="{{url('/clients')}}" img="{{url('public/images/home_icon.png')}}"
                        :active="{{request()->is("/clients")}}">
                Clients
            </x-nav-link>
            <x-nav-link href="{{url('/payments')}}" img="{{url('public/images/home_icon.png')}}"
                        :active="{{request()->is("/payments")}}">
                Payments
            </x-nav-link>
            @if($admin)
                <x-nav-link href="{{url('/employees')}}" img="{{url('public/images/home_icon.png')}}"
                            :active="{{request()->is("/employees")}}">
                    Employees
                </x-nav-link>
            @endif
        </div>
        <hr>
        <div>
            <x-nav-link href="{{url('/account')}}" img="{{url('public/images/account_icon.png')}}"
                        :active="{{request()->is("/account")}}">
                Account
            </x-nav-link>
            <x-nav-link href="{{url('/settings')}}" img="{{url('public/images/setting_icon.png')}}"
                        :active="{{request()->is("/settings")}}">
                Settings
            </x-nav-link>
        </div>
    </nav>
</aside>
