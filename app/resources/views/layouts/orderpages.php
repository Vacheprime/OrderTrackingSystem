<?php

namespace resources\views\layouts;

class OrderManagement
{

    function render()
    {
        echo '
    <h1 class="titleManagement"ORDER MANAGEMENT</h1>
    
    <div class="main-content-management">
    <input class="searchBar" type="text" placeholder="Search">

    <select class="searchByDropdown">
    <option value="" disabled selected>Search by</option>
    <option value="searchArea">Area</option>
    <option value="searchName">Name</option>
    <option value="searchOrderID">OrderID</option>
    <option value="searchClientID">ClientID</option>
    </select>

    <select class="filterByDropdown">
    <option value="" disabled selected>Filter by</option>
    <option value="filterNewest">Newest</option>
    <option value="filterOldest">Oldest</option>
    <option value="filterStatus">Status</option>
    </select>
      
    <button class="searchButton" onclick="">Seach</button>

    <button class="createOrderButton" onclick="">Create order</button>

    <hr> <!-- This is for the kind of big separator line under the search bar-->
    
    <h2 class="subTitleManagement">View Orders</h2>
    
    <table>
    <thead>
        <tr>
            <th>OrderID</th>
            <th>ClientID</th>
            <th>Reference Number</th>
            <th>Measured by</th>
            <th>Fabrication start date</th>
            <th>Status</th>
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
    <h2>Viewing Order Details</h2>
<div id="ID">
    <p id="label">ORDER ID</p>
    <p id="value"></p>
    </div>
<div id="client">
    <p id="label">Client</p>
    <a href=""></a>
    </div>
<div id="measuredBy">
    <p id="label">Measured by</p>
    <p id="value"></p>
    </div>
<div id="referenceNumber">
    <p id="label">Reference number</p>
    <p id="value"></p>
    </div>
<div id="invoiceNumber">
    <p id="label">Invoice number</p>
    <p id="value"></p>
    </div>
<div id="totalPrice">
    <p id="label">Total price</p>
    <p id="value"></p>
    </div>
<div id="status">
    <p id="label">Status</p>
    <select class="statusDropdown">
        <option value="" disabled selected>Choose</option>
        <option value="confirmedMsNotReady">Confirmed ms not ready</option>
        <option value="confirmedMsReady">Confirmed ms ready</option>
        <option value="readyForMs">Ready for ms</option>
        <option value="pickedUp">Picked up</option>
        <option value="installed">Installed</option>
    </select>
    </div>
<div id="fabrication_startDate">
    <p id="label">Fabrication_start date</p>
    <p id="value"></p>
    </div>
<div id="installationDate">
    <p id="label">Installation date</p>
    <p id="value"></p>
    </div>
<div id="picked_upDate">
    <p id="label">Picked_up date</p>
    <p id="value"></p>
    </div>
<div id="materialName">
    <p id="label">Material name</p>
    <p id="value"></p>
    </div>
<div id="slabHeight">
    <p id="label">Slab height</p>
    <p id="value"></p>
    </div>
<div id="slabWidth">
    <p id="label">Slab width</p>
    <p id="value"></p>
    </div>
<div id="slabThickness">
    <p id="label">Slab thickness</p>
    <p id="value"></p>
    </div>
<div id="slabSquareFootage">
    <p id="label">Slab square footage</p>
    <p id="value"></p>
    </div>
<div id="sinkType">
    <p id="label">Sink type</p>
    <p id="value"></p>
    </div>
<div id="fabrication_plan image">
    <p id="label"></p>
    <div class="fabPlanImage">
    <img class="fabricationPlanImage" src="" alt="fabricationPlanImage">
    </div>
    </div>
<div id="productDescription">
    <p id="label">Product description</p>
    <p id="value"></p>
    </div>
<div id="productNotes">
    <p id="label">Product notes</p>
    <p id="value"></p>
    </div>
    <button class="editButton" onclick="">Edit</button>   
    </div>
    ';
    }
}


class EditOrderManagement
{
    function render()
    {
        echo '

    <div class="goBack">
    <img class="backIcon" src="Minimize.png" alt="qrCode">
    <button class="goBackButton" onclick="">Back</button>
    </div>
<div class="main-content-management">
  <h2 class="title">Edit Order</h2>
  <label for="clientID">ClientID</label>
  <input type="text" id="clientID" name="clientID" value="Null">
  <br>
  <label for="measuredBy">Measured by (initials)</label>
  <input type="text" id="measuredBy" name="measuredBy" value="Null">
  <br>
  <label for="referenceNumber">Reference Number</label>
  <input type="text" id="referenceNumber" name="referenceNumber" value="Null">
  <br>
  <label for="invoiceNumber">Invoice Number</label>
  <input type="text" id="invoiceNumber" name="invoiceNumber" value="Null">
  <br>
  <label for="totalPrice">Total price</label>
  <input type="text" id="totalPrice" name="totalPrice" value="0$">
  <br>
  <label for="orderStatus">Order status</label>
  <select class="statusDropdown">
        <option value="" disabled selected>Choose</option>
        <option value="confirmedMsNotReady">Confirmed ms not ready</option>
        <option value="confirmedMsReady">Confirmed ms ready</option>
        <option value="readyForMs">Ready for ms</option>
        <option value="pickedUp">Picked up</option>
        <option value="installed">Installed</option>
    </select>
    <br>
    <label for="fabricationStartDate">Fabrication_start date</label>
    <input type="date" id="fabricationStartDate">
    <br>
    <label for="installationDate">Installation date</label>
    <input type="date" id="installationDate">
    <br>
    <label for="pickedUpDate">Picked_up date</label>
    <input type="date" id="pickedUpDate">
    <br>
        <label for="materialName">Material name</label>
        <input type="text" id="materialName" name="materialName" value="Null">
        <br>
        <label for="slabHeight">Slab height</label>
        <input type="text" id="slabHeight" name="slabHeight" value="Null">
        <br>
        <label for="slabWidth">Slab width</label>
        <input type="text" id="slabWidth" name="slabWidth" value="Null">
        <br>
        <label for="slabThickness">Slab thickness</label>
        <input type="text" id="slabThickness" name="slabThickness" value="Null">
        <br>
        <label for="slabSquareFootage">Slab square footage</label>
        <input type="text" id="slabSquareFootage" name="slabSquareFootage" value="Null">
        <br>
        <label for="sinkType">Sink type</label>
        <input type="text" id="sinkType" name="sinkType" value="Null">
        <br>
    <div class="uploadFabPlanImage" onclick=""> 
        <img src="cloud-icon.png" alt="Upload Icon">
        <p>Fabrication plan image</p>
    </div>
    <input type="file" id="uploadedImage" style="display: none;">
    <br>
     <label for="productDescription">Product Description</label>
     <input type="text" id="productDescription" name="productDescription" value="Null">
        <br>
    <label for="productNotes">Product Notes</label>
    <input type="text" id="productNotes" name="productNotes" value="Null">
        <br>  
    </div>
    <button class="saveButton" onclick="">Save</button>
    <button class="cancelButton" onclick="">Cancel</button>
        ';
    }
}

class CreateOrderManagement
{
    function render()
    {
        echo '
    <div class="goBack">
    <img class="backIcon" src="Minimize.png" alt="qrCode">
    <button class="goBackButton" onclick="">Back</button>
    </div>
<div class="main-content-management">
<h2 class="title">Create Order</h2>
  <a href="" class="createClient">Inexistant client? Create one</a>
  <label for="clientID">ClientID</label>
  <input type="text" id="clientID" name="clientID" value="Null">
  <br>
  <label for="measuredBy">Measured by (initials)</label>
  <input type="text" id="measuredBy" name="measuredBy" value="Null">
  <br>
  <label for="referenceNumber">Reference Number</label>
  <input type="text" id="referenceNumber" name="referenceNumber" value="Null">
  <br>
  <label for="invoiceNumber">Invoice Number</label>
  <input type="text" id="invoiceNumber" name="invoiceNumber" value="Null">
  <br>
  <label for="totalPrice">Total price</label>
  <input type="text" id="totalPrice" name="totalPrice" value="0$">
  <br>
  <label for="orderStatus">Order status</label>
  <select class="statusDropdown">
        <option value="" disabled selected>Choose</option>
        <option value="confirmedMsNotReady">Confirmed ms not ready</option>
        <option value="confirmedMsReady">Confirmed ms ready</option>
        <option value="readyForMs">Ready for ms</option>
        <option value="pickedUp">Picked up</option>
        <option value="installed">Installed</option>
    </select>
    <br>
    <label for="fabricationStartDate">Fabrication_start date</label>
    <input type="date" id="fabricationStartDate">
    <br>
    <label for="installationDate">Installation date</label>
    <input type="date" id="installationDate">
    <br>
    <label for="pickedUpDate">Picked_up date</label>
    <input type="date" id="pickedUpDate">
    <br>
        <label for="materialName">Material name</label>
        <input type="text" id="materialName" name="materialName" value="Null">
        <br>
        <label for="slabHeight">Slab height</label>
        <input type="text" id="slabHeight" name="slabHeight" value="Null">
        <br>
        <label for="slabWidth">Slab width</label>
        <input type="text" id="slabWidth" name="slabWidth" value="Null">
        <br>
        <label for="slabThickness">Slab thickness</label>
        <input type="text" id="slabThickness" name="slabThickness" value="Null">
        <br>
        <label for="slabSquareFootage">Slab square footage</label>
        <input type="text" id="slabSquareFootage" name="slabSquareFootage" value="Null">
        <br>
        <label for="sinkType">Sink type</label>
        <input type="text" id="sinkType" name="sinkType" value="Null">
        <br>
    <div class="uploadFabPlanImage" onclick=""> 
        <img src="cloud-icon.png" alt="Upload Icon">
        <p>Fabrication plan image</p>
    </div>
    <input type="file" id="uploadedImage" style="display: none;">
    <br>
     <label for="productDescription">Product Description</label>
     <input type="text" id="productDescription" name="productDescription" value="Null">
        <br>
    <label for="productNotes">Product Notes</label>
    <input type="text" id="productNotes" name="productNotes" value="Null">
        <br>  
    </div>
    <button class="createButton" onclick="">Create</button>
        ';
    }
}
