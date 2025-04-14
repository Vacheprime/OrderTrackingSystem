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
	phone_number VARCHAR(20) NOT NULL,
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
	phone_number VARCHAR(20) NOT NULL,
	email VARCHAR(75) NOT NULL,
	birth_date DATE NOT NULL,
	hire_date DATE NOT NULL,
	is_admin BOOLEAN NOT NULL,
	password_hash VARCHAR(255) NOT NULL,
	secret VARCHAR(255),
	address_id INTEGER NOT NULL,
	CONSTRAINT employee_address_fk FOREIGN KEY (address_id) REFERENCES address(address_id)
);

-- Create the order table
CREATE TABLE `order` (
	order_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	reference_number VARCHAR(100) NOT NULL,
	is_plan_ready BOOLEAN NOT NULL,
	is_in_fabrication BOOLEAN NOT NULL,
	is_completed BOOLEAN NOT NULL,
	fabrication_start_date DATE,
	price DECIMAL(10, 2) NOT NULL,
	taxes DECIMAL(10, 2) NOT NULL,
	estimated_install_date DATE,
	order_completed_date DATE,
	invoice_number VARCHAR(100),
	`status` VARCHAR(25),
	`client_id` INTEGER NOT NULL,
	measured_by INTEGER NOT NULL,
	CONSTRAINT order_client_fk FOREIGN KEY (client_id) REFERENCES `client`(client_id),
	CONSTRAINT order_measured_by_fk FOREIGN KEY (measured_by) REFERENCES employee(employee_id)
);

-- Create order product table
CREATE TABLE order_product (
	order_id INTEGER PRIMARY KEY,
	material_name VARCHAR(100),
	is_material_available BOOLEAN NOT NULL,
	slab_height INTEGER,
	slab_width INTEGER,
	slab_thickness INTEGER,
	plan_image_path VARCHAR(75),
	product_description TEXT NOT NULL,
	sink_type VARCHAR(100),
	product_square_footage DECIMAL(8, 2),
	product_notes TEXT,
	CONSTRAINT order_product_order_fk FOREIGN KEY (order_id) REFERENCES `order`(order_id)
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