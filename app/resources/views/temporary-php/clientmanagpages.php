<?php


class ClientManagement
{
    function render()
    {
        echo '
    <h1 class="titleManagement"CLIENT MANAGEMENT</h1>

    <div class="main-content-management">
    <input class="searchBar" type="text" placeholder="Search">

    <select class="searchByDropdown">
    <option value="" disabled selected>Search by</option>
    <option value="searchArea">Area</option>
    <option value="searchName">Name</option>
    <option value="searchClientID">ClientID</option>
    </select>

    <button class="searchButton" onclick="">Seach</button>

    <button class="createOrderButton" onclick="">Create Client</button>

    <hr>

    <h2 class="subTitleManagement">View Clients</h2>

    <table>
    <thead>
        <tr>
            <th>ClientID</th>
            <th>First name</th>
            <th>Last name</th>
            <th>Phone number</th>
            <th>Postal code</th>
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
    <h2>Viewing Client Details</h2>
<div id="ID">
    <p id="label">CLIENT ID</p>
    <p id="value"></p>
    </div>
<div id="firstName">
    <p id="label">First name</p>
    <a href=""></a>
    </div>
<div id="lastName">
    <p id="label">Last name</p>
    <p id="value"></p>
    </div>
<div id="referenceNumber">
    <p id="label">Reference number</p>
    <p id="value"></p>
    </div>
<div id="phoneNumber">
    <p id="label">Phone number</p>
    <p id="value"></p>
    </div>
<div id="Address">
    <p id="label">Address</p>
    <p id="value"></p>
    </div>
<div id="postalCode">
    <p id="label">Postal Code</p>
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
<div id="area">
    <p id="label">Area(neighborhood)</p>
    <p id="value"></p>
    </div>
    <button class="editButton" onclick="">Edit</button>
    </div>
    ';
    }
}


class EditClientManagement
{
    function render()
    {
        echo '

    <div class="goBack">
    <img class="backIcon" src="Minimize.png" alt="qrCode">
    <button class="goBackButton" onclick="">Back</button>
    </div>
<div class="main-content-management">
  <h2 class="title">Edit Client</h2>
  <label for="firstName">First name</label>
  <input type="text" id="firstName" name="firstName" value="Null">
  <br>
  <label for="lastName">Last name</label>
  <input type="text" id="lastName" name="lastName" value="Null">
  <br>
  <label for="address">Address</label>
  <input type="text" id="address" name="address" value="Null">
  <br>
  <label for="referenceNumber">Reference Number</label>
  <input type="text" id="referenceNumber" name="referenceNumber" value="Null">
  <br>
  <label for="phoneNumber">Phone number</label>
  <input type="text" id="phoneNumber" name="phoneNumber" value="Null">
  <br>
  <label for="postalCode">Postal code</label>
  <input type="text" id="postalCode" name="postalCode" value="Null">
<label for="city">City</label>
<input type="text" id="city" name="city" value="Null">
<br>
<label for="province">Province</label>
<input type="text" id="province" name="province" value="Null">
<br>
<label for="area">Area(neighborhood)</label>
<input type="text" id="area" name="area" value="Null">
<br>
    </div>
    <button class="saveButton" onclick="">Save</button>
    <button class="cancelButton" onclick="">Cancel</button>
        ';
    }
}

class CreateClientManagement
{
    function render()
    {
        echo '

    <div class="goBack">
    <img class="backIcon" src="Minimize.png" alt="qrCode">
    <button class="goBackButton" onclick="">Back</button>
    </div>
<div class="main-content-management">
  <h2 class="title">Create Client</h2>
  <label for="firstName">First name</label>
  <input type="text" id="firstName" name="firstName" value="Null">
  <br>
  <label for="lastName">Last name</label>
  <input type="text" id="lastName" name="lastName" value="Null">
  <br>
  <label for="address">Address</label>
  <input type="text" id="address" name="address" value="Null">
  <br>
  <label for="referenceNumber">Reference Number</label>
  <input type="text" id="referenceNumber" name="referenceNumber" value="Null">
  <br>
  <label for="phoneNumber">Phone number</label>
  <input type="text" id="phoneNumber" name="phoneNumber" value="Null">
  <br>
  <label for="postalCode">Postal code</label>
  <input type="text" id="postalCode" name="postalCode" value="Null">
<label for="city">City</label>
<input type="text" id="city" name="city" value="Null">
<br>
<label for="province">Province</label>
<input type="text" id="province" name="province" value="Null">
<br>
<label for="area">Area(neighborhood)</label>
<input type="text" id="area" name="area" value="Null">
<br>
    </div>
    <button class="createButton" onclick="">Create</button>
        ';
    }
}
