-- Create the database
CREATE DATABASE crown_granite_order_db;

-- Select the database for usage
USE crown_granite_order_db;

-- Create the address table
CREATE TABLE address (
	address_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	street_name VARCHAR(75) NOT NULL,
	appartment_number VARCHAR(15),
	postal_code VARCHAR(10) NOT NULL,
	area VARCHAR(50) NOT NULL
);

-- Create the client table
CREATE TABLE `client` (
	client_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	first_name VARCHAR(50) NOT NULL,
	last_name VARCHAR(50) NOT NULL,
	client_reference VARCHAR(100),
	phone_number VARCHAR(25) NOT NULL,
	address_id INTEGER NOT NULL,
	CONSTRAINT client_address_fk FOREIGN KEY (address_id) REFERENCES address(address_id)
);

-- Create the employee table
CREATE TABLE employee (
	employee_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	initials VARCHAR(10) NOT NULL,
	first_name VARCHAR(50) NOT NULL,
	last_name VARCHAR(50) NOT NULL,
	position VARCHAR(25) NOT NULL,
	phone_number VARCHAR(25) NOT NULL,
	email VARCHAR(75) NOT NULL,
	is_admin BOOLEAN NOT NULL,
    has_set_up_2fa BOOLEAN NOT NULL, -- Needed for first time access
	password_hash VARCHAR(255) NOT NULL,
	secret VARCHAR(255) NOT NULL, 
	address_id INTEGER NOT NULL,
	CONSTRAINT employee_address_fk FOREIGN KEY (address_id) REFERENCES address(address_id)
);

-- Create the order table
CREATE TABLE `order` (
	order_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	reference_number VARCHAR(100), -- Required, but has to be nullable because of how it's generated in PHP.
	price DECIMAL(10, 2) NOT NULL,
    `status` VARCHAR(25) NOT NULL,
    invoice_number VARCHAR(100), -- Not required because the invoice is not generated from the start.
    fabrication_start_date DATE,
	estimated_install_date DATE,
	order_completed_date DATE,
	`client_id` INTEGER NOT NULL,
	measured_by INTEGER NOT NULL,
	CONSTRAINT order_client_fk FOREIGN KEY (client_id) REFERENCES `client`(client_id),
	CONSTRAINT order_measured_by_fk FOREIGN KEY (measured_by) REFERENCES employee(employee_id)
);

-- Create order product table
CREATE TABLE product (
	order_id INTEGER PRIMARY KEY,
	material_name VARCHAR(100), -- Only for slabs
	slab_height DECIMAL(6, 2), -- Only for slabs
	slab_width DECIMAL(6, 2), -- Only for slabs
	slab_thickness DECIMAL(4, 2), -- Only for slabs
    slab_square_footage DECIMAL(8, 2), -- Only for slabs
	plan_image_path VARCHAR(75), -- Only for slabs
	sink_type VARCHAR(100), -- Only for sinks
    product_description TEXT NOT NULL,
	product_notes TEXT NOT NULL,
	CONSTRAINT product_order_fk FOREIGN KEY (order_id) REFERENCES `order`(order_id)
);

-- Create payment table
CREATE TABLE payment (
	payment_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	amount DECIMAL(10, 2) NOT NULL,
	`type` VARCHAR(50) NOT NULL,
	method VARCHAR(50) NOT NULL,
	payment_date DATE NOT NULL,
	order_id INTEGER NOT NULL,
	CONSTRAINT payment_order_fk FOREIGN KEY (order_id) REFERENCES `order`(order_id)
);

-- Create activity table
CREATE TABLE activity (
	activity_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    activity_type VARCHAR(6) NOT NULL,
    log_date DATE NOT NULL,
    order_id INTEGER NOT NULL,
    employee_id INTEGER NOT NULL,
    CONSTRAINT activity_order_id FOREIGN KEY (order_id) REFERENCES `order`(order_id),
    CONSTRAINT activity_employee_id FOREIGN KEY (employee_id) REFERENCES employee(employee_id)
);