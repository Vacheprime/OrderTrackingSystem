@props(["employees" => $employees ?? []])

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
        <tr>
            <td>Empty</td>
            <td>Empty</td>
            <td>Empty</td>
            <td>Empty</td>
            <td>Empty</td>
        </tr>
    @endforelse
    </tbody>
</table>
