@props(["employees" => $employees ?? [], "short" => false])

<table class="search-table">
    <thead>
    <tr>
        <th>EmployeeID</th>
        <th>First name</th>
        <th>Last name</th>
        <th>Email</th>
        <th>Phone number</th>
    </tr>
    </thead>
    <tbody id="employees-tbody">
    @forelse($employees as $employee)
        <tr id="employee-id-{{$employee->getEmployeeId()}}" onclick="">
            <td>{{$employee->getEmployeeId()}}</td>
            <td>{{$employee->getFirstName()}}</td>
            <td>{{$employee->getLastName()}}</td>
            <td>{{$employee->getAccount()->getEmail()}}</td>
            <td>{{$employee->getPhoneNumber()}}</td>
        </tr>
    @empty
        <td colspan="{{$short ? 4 : 6}}" style="text-align: center;">
            <div class="order-table-td-div">No results!</div>
        </td>
    @endforelse
    </tbody>
</table>
