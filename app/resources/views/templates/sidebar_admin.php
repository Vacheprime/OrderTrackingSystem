<?php

namespace resources\views\templates;

class SidebarAdmin
{

    function render()
    {
        echo '<div class="sidebar">
    <a href="">
    <img src="resources/views/images/Minimize.png" alt="minimizeIcon">
    </a>
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
}

class SidebarEmployee
{

    function render()
    {
        echo '<div class="sidebar">
    <a href="">
    <img src="resources/views/images/Minimize.png" alt="minimizeIcon">
    </a>
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
  </ul>
  <hr class="separator">
  <div class="settings">
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
}

