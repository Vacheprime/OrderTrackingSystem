<?php

function maximizedSideBar()
{
    echo '<div class="sidebar">
  <button class="minimizeButton">◀</button> 
  <hr class="separator">
  <ul>
    <li>
    <div>
        <img class="homeIcon" src="homeIcon.png" alt="Home icon">
        <p>Home</p>
    </div>
    </li>
    <li>
    <div>
        <img class="ordersIcon" src="ordersIcon.png" alt="Orders icon">
        <p>Orders</p>
    </div>
    </li>
    <li>
    <div>
        <img class="clientsIcon" src="clientsIcon.png" alt="Clients icon">
        <p>Clients</p>
    </div>
    </li>
    <li>
    <div>
        <img class="paymentsIcon" src="paymentsIcon.png" alt="Payments icon">
        <p>Payments</p>
    </div>
    </li>
    <li>
    <div>
        <img class="employeesIcon" src="employeesIcon.png" alt="Employees icon">
        <p>Employees</p>
    </div>
    </li>
  </ul>
  <hr class="separator">
  <div class="settings">
    <button class="theme-toggle">🌞🌜</button> <!-- TODO I will remove this thing, since night mode we wont do it -->
    <li>
    <div>
        <img class="settingsIcon" src="settingsIcon.png" alt="Settings icon">
        <p>Settings</p>
    </div>
    </li>
    <li>
    <div>
        <img class="AccountIcon" src="AccountIcon.png" alt="Account icon">
        <p>Account</p>
    </div>
    </li>
  </div>
</div>';
}

function minimizedSideBar()
{
    echo '<div class="sidebar">
  <button class="maximizeButton">▶</button> 
  <hr class="separator">
  <ul>
    <li>
    <div>
        <img class="homeIcon" src="homeIcon.png" alt="Home icon">
    </div>
    </li>
    <li>
    <div>
        <img class="ordersIcon" src="ordersIcon.png" alt="Orders icon">
    </div>
    </li>
    <li>
    <div>
        <img class="clientsIcon" src="clientsIcon.png" alt="Clients icon">
    </div>
    </li>
    <li>
    <div>
        <img class="paymentsIcon" src="paymentsIcon.png" alt="Payments icon">
    </div>
    </li>
    <li>
    <div>
        <img class="employeesIcon" src="employeesIcon.png" alt="Employees icon">
    </div>
    </li>
  </ul>
  <hr class="separator">
  <div class="settings">
    <button class="theme-toggle">🌞🌜</button> <!-- TODO I will remove this thing, since night mode we wont do it -->
    <li>
    <div>
        <img class="settingsIcon" src="settingsIcon.png" alt="Settings icon">
    </div>
    </li>
    <li>
    <div>
        <img class="AccountIcon" src="AccountIcon.png" alt="Account icon">
    </div>
    </li>
  </div>
</div>';
}
