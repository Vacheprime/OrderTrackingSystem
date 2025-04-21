<?php

namespace resources\views\layouts;

class PaymentManagement
{
    function render()
    {
        echo '
    <h1 class="titleManagement"PAYMENT MANAGEMENT</h1>
    
    <div class="main-content-management">
    <input class="searchBar" type="text" placeholder="Search">

    <select class="searchByDropdown">
    <option value="" disabled selected>Search by</option>
    <option value="paymentID">PaymentID</option>
    <option value="orderID">OrderID</option>
    </select>
      
    <button class="searchButton" onclick="">Seach</button>

    <button class="createPaymentButton" onclick="">Create Payment</button>

    <hr>
    
    <h2 class="subTitleManagement">View Payments</h2>
    
    <table>
    <thead>
        <tr>
            <th>PaymentID</th>
            <th>OrderID</th>
            <th>Date</th>
            <th>Amount</th>
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
    <h2>Viewing Payment Details</h2>
<div id="ID">
    <p id="label">PAYMENT ID</p>
    <p id="value"></p>
    </div>
<div id="order">
    <p id="label">Order</p>
    <a href="" id="value>View Order</a>
    </div>
<div id="date">
    <p id="label">Date</p>
    <p id="value"></p>
    </div>
<div id="amountPayed">
    <p id="label">Amount payed</p>
    <p id="value"></p>
    </div>
<div id="type">
    <p id="label">Type</p>
    <p id="value"></p>
    </div>
<div id="method">
    <p id="label">Method</p>
    <p id="value"></p>
    </div>
    
    <button class="editButton" onclick="">Edit</button>   
    </div>
    ';
    }
}


class EditPaymentManagement
{
    function render()
    {
        echo '

    <div class="goBack">
    <img class="backIcon" src="Minimize.png" alt="qrCode">
    <button class="goBackButton" onclick="">Back</button>
    </div>
<div class="main-content-management">
  <h2 class="title">Edit Payment</h2>
  <label for="orderID">OrderID</label>
  <input type="text" id="orderID" name="orderID" value="Null">
  <br>
  <label for="date">Date</label>
  <input type="date" id="date" name="date">
  <br>
  <label for="amount">Amount</label>
  <input type="text" id="amount" name="amount" value="Null">
  <br>
  <label for="type">Type</label>
  <input type="text" id="type" name="type" value="Null">
  <br>
  <label for="method">Method</label>
  <input type="text" id="method" name="method" value="Null">
  <br>
    </div>
    <button class="saveButton" onclick="">Save</button>
    <button class="cancelButton" onclick="">Cancel</button>
        ';
    }
}

class CreatePaymentManagement
{
    function render()
    {
        echo '

    <div class="goBack">
    <img class="backIcon" src="Minimize.png" alt="qrCode">
    <button class="goBackButton" onclick="">Back</button>
    </div>
<div class="main-content-management">
  <h2 class="title">Create Payment</h2>
  <label for="orderID">OrderID</label>
  <input type="text" id="orderID" name="orderID" value="Null">
  <br>
  <label for="date">Date</label>
  <input type="date" id="date" name="date">
  <br>
  <label for="amount">Amount</label>
  <input type="text" id="amount" name="amount" value="Null">
  <br>
  <label for="type">Type</label>
  <input type="text" id="type" name="type" value="Null">
  <br>
  <label for="method">Method</label>
  <input type="text" id="method" name="method" value="Null">
  <br>
    </div>
    <button class="createButton" onclick="">Create</button>
        ';
    }
}