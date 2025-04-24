<?php


class EmployeeManagement
{
    function render()
    {
        echo '
    <h1 class="titleManagement"EMPLOYEE MANAGEMENT</h1>

    <div class="main-content-management">
    <input class="searchBar" type="text" placeholder="Search">

    <select class="searchByDropdown">
    <option value="" disabled selected>Search by</option>
    <option value="employeeID">EmployeeID</option>
    <option value="name">Name</option>
    <option value="position">Position</option>
    </select>

    <button class="searchButton" onclick="">Search</button>

    <button class="createEmployeeButton" onclick="">Create Employee</button>

    <hr>

    <h2 class="subTitleManagement">View Employees</h2>

    <table>
    <thead>
        <tr>
            <th>EmployeeID</th>
            <th>First name</th>
            <th>Last name</th>
            <th>Email</th>
            <th>Phone number</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <!-- I will add rows dynamically using JavaScript -->
        </tr>
    </tbody>
    </table>

    <ul id="paginationControlls" ></ul>
    <!-- <script src="pagination.js"></script> -->
    </div>


    <div id="detailsOfSelectedRow">
    <h2>Viewing Employee Details</h2>
<div id="ID">
    <p id="label">EMPLOYEE ID</p>
    <p id="value"></p>
    </div>
<div id="initials">
    <p id="label">Initials</p>
    <p id="value"></p>
    </div>
<div id="firstName">
    <p id="label">First name</p>
    <p id="value"></p>
    </div>
<div id="lastName">
    <p id="label">Last name</p>
    <p id="value"></p>
    </div>
<div id="hiredDate">
    <p id="label">Hired date</p>
    <p id="value"></p>
    </div>
<div id="position">
    <p id="label">Position</p>
    <p id="value"></p>
    </div>
<div id="email">
    <p id="label">Email</p>
    <p id="value"></p>
    </div>
<div id="phoneNumber">
    <p id="label">Phone number</p>
    <p id="value"></p>
    </div>
<div id="address">
    <p id="label">Address</p>
    <p id="value"></p>
    </div>
<div id="postalCode">
    <p id="label">Postal code</p>
    <p id="value"></p>
    </div>
<div id="city">
    <p id="label">City</p>
    <p id="value"></p>
    </div>
<div id="province">
    <p id="label">Province</p>
    <p id="value"></p>
    </div>
<div id="accountStatus">
    <p id="label">Account Status</p>
    <p id="value"></p>
    </div>

    <button class="editButton" onclick="">Edit</button>
    </div>
    ';
    }
}


class EditEmployeeManagement
{
    function render()
    {
        echo '

    <div class="goBack">
    <img class="backIcon" src="Minimize.png" alt="qrCode">
    <button class="goBackButton" onclick="">Back</button>
    </div>
<div class="main-content-management">
  <h2 class="title">Edit Employee</h2>
  <label for="initials">Initials</label>
  <input type="text" id="initials" name="initials" value="Null">
  <br>
  <label for="firstName">First name</label>
  <input type="text" id="firstName" name="firstName">
  <br>
  <label for="lastName">Last name</label>
  <input type="text" id="lastName" name="lastName" value="Null">
  <br>
  <label for="email">Email</label>
  <input type="text" id="email" name="email" value="Null">
  <br>
  <label for="phoneNumber">Phone number</label>
  <input type="text" id="phoneNumber" name="phoneNumber" value="Null">
  <br>
  <label for="address">Address</label>
  <input type="text" id="address" name="address" value="Null">
  <br>
  <label for="hiredDate">Hired date</label>
  <input type="date" id="hiredDate" name="hiredDate" value="Null">
  <br>
  <label for="position">Position</label>
  <input type="text" id="position" name="position" value="Null">
  <br>
  <label for="postalCode">Postal code</label>
  <input type="text" id="postalCode" name="postalCode" value="Null">
  <br>
  <label for="city">City</label>
  <input type="text" id="city" name="city" value="Null">
  <br>
  <label for="province">Province</label>
  <input type="text" id="province" name="province" value="Null">
  <br>
  <label for="accountStatus">Account status</label>
  <select class="accountStatusDropdown">
    <option value="disabled">Disabled</option>
    <option value="enabled">Enabled</option>
  </select>
  <br>

    </div>
    <button class="saveButton" onclick="">Save</button>
    <button class="cancelButton" onclick="">Cancel</button>
        ';
    }
}

class CreateEmployeeManagement
{
    function render()
    {
        echo '

    <div class="goBack">
    <img class="backIcon" src="Minimize.png" alt="qrCode">
    <button class="goBackButton" onclick="">Back</button>
    </div>
<div class="main-content-management">
  <h2 class="title">Edit Employee</h2>
  <label for="initials">Initials</label>
  <input type="text" id="initials" name="initials" value="Null">
  <br>
  <label for="firstName">First name</label>
  <input type="text" id="firstName" name="firstName">
  <br>
  <label for="lastName">Last name</label>
  <input type="text" id="lastName" name="lastName" value="Null">
  <br>
  <label for="email">Email</label>
  <input type="text" id="email" name="email" value="Null">
  <br>
  <label for="phoneNumber">Phone number</label>
  <input type="text" id="phoneNumber" name="phoneNumber" value="Null">
  <br>
  <label for="address">Address</label>
  <input type="text" id="address" name="address" value="Null">
  <br>
  <label for="hiredDate">Hired date</label>
  <input type="date" id="hiredDate" name="hiredDate" value="Null">
  <br>
  <label for="position">Position</label>
  <input type="text" id="position" name="position" value="Null">
  <br>
  <label for="postalCode">Postal code</label>
  <input type="text" id="postalCode" name="postalCode" value="Null">
  <br>
  <label for="city">City</label>
  <input type="text" id="city" name="city" value="Null">
  <br>
  <label for="province">Province</label>
  <input type="text" id="province" name="province" value="Null">
  <br>
  <label for="note">Note: Created employee accounts are disabled by default.</label>
  <br>
    </div>
    <button class="createButton" onclick="">Create</button>
        ';
    }
}
