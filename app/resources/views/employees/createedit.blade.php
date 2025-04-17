<x-layout>
    <div class="main-content">
        @if($isCreate)
            <h2>Create Employee</h2>
        @else
            <h2>Update Employee</h2>
        @endif
        @foreach($employeeproperties as $property)
            <x-input-property :property="{{$property}}"/>
        @endforeach
        @if($isCreate)
            @php
                $doc = new DOMDocument();
                $doc->getElementById('firstname')->nodeValue = $employee->getEmployeeId();
                $doc->getElementById('lastname')->nodeValue = $employee->getEmployeeId();
                $doc->getElementById('email')->nodeValue = $employee->getEmployeeId();
                $doc->getElementById('phonenumber')->nodeValue = $employee->getEmployeeId();
                $doc->getElementById('address')->nodeValue = $employee->getEmployeeId();
                $doc->getElementById('postalcode')->nodeValue = $employee->getEmployeeId();
                $doc->getElementById('city')->nodeValue = $employee->getEmployeeId();
                $doc->getElementById('province')->nodeValue = $employee->getEmployeeId();
                $doc->getElementById('disable')->setAttribute('checked', true);
            @endphp
        @endif
    </div>
</x-layout>
