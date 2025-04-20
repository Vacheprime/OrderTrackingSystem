-- Create the database
CREATE DATABASE IF NOT EXISTS TESTING_crown_granite_order_db;

-- Select the database for usage
USE TESTING_crown_granite_order_db;

-- Create the address table
CREATE TABLE IF NOT EXISTS address (
	address_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	street_name VARCHAR(75) NOT NULL,
	appartment_number VARCHAR(15),
	postal_code VARCHAR(10) NOT NULL,
	area VARCHAR(50) NOT NULL
);

-- Create the client table
CREATE TABLE IF NOT EXISTS `client` (
	client_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	first_name VARCHAR(50) NOT NULL,
	last_name VARCHAR(50) NOT NULL,
	client_reference VARCHAR(100),
	phone_number VARCHAR(25) NOT NULL,
	address_id INTEGER NOT NULL,
	CONSTRAINT client_address_fk FOREIGN KEY (address_id) REFERENCES address(address_id)
);

-- Create the employee table
CREATE TABLE IF NOT EXISTS employee (
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
CREATE TABLE IF NOT EXISTS `order` (
	order_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	reference_number VARCHAR(100), -- Required, but has to be nullable because of how it's generated in PHP.
	price DECIMAL(10, 2) NOT NULL,
  `status` VARCHAR(25) NOT NULL,
  invoice_number VARCHAR(100), -- Not required because the invoice is not generated from the start.
  creation_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP, -- Default to current time of insertion
  fabrication_start_date DATE,
	estimated_install_date DATE,
	order_completed_date DATE,
	client_id INTEGER NOT NULL,
	measured_by INTEGER NOT NULL,
	CONSTRAINT order_client_fk FOREIGN KEY (client_id) REFERENCES `client`(client_id),
	CONSTRAINT order_measured_by_fk FOREIGN KEY (measured_by) REFERENCES employee(employee_id)
);

-- Create order product table
CREATE TABLE IF NOT EXISTS product (
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
CREATE TABLE IF NOT EXISTS payment (
	payment_id INTEGER PRIMARY KEY AUTO_INCREMENT,
	amount DECIMAL(10, 2) NOT NULL,
	`type` VARCHAR(50) NOT NULL,
	method VARCHAR(50) NOT NULL,
	payment_date DATE NOT NULL,
	order_id INTEGER NOT NULL,
	CONSTRAINT payment_order_fk FOREIGN KEY (order_id) REFERENCES `order`(order_id)
);

-- Create activity table
CREATE TABLE IF NOT EXISTS activity (
	activity_id INTEGER PRIMARY KEY AUTO_INCREMENT,
    activity_type VARCHAR(6) NOT NULL,
    log_date DATE NOT NULL,
    order_id INTEGER NOT NULL,
    employee_id INTEGER NOT NULL,
    CONSTRAINT activity_order_id FOREIGN KEY (order_id) REFERENCES `order`(order_id),
    CONSTRAINT activity_employee_id FOREIGN KEY (employee_id) REFERENCES employee(employee_id)
);

-- Delete all data from all tables
SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE TABLE address;
TRUNCATE TABLE `client`;
TRUNCATE TABLE employee;
TRUNCATE TABLE `order`;
TRUNCATE TABLE product;
TRUNCATE TABLE payment;
TRUNCATE TABLE activity;
SET FOREIGN_KEY_CHECKS = 1;

-- Populate with test data
-- Address table
INSERT INTO address (street_name, appartment_number, postal_code, area)
VALUES 
  ('Maple Street', 'Apt 101', 'A1B 2C3', 'Downtown'),
  ('Kingston Ave', NULL, 'B3C 4D5', 'East Side'),
  ('Granite Rd', 'Suite 205', 'E2G 3H4', 'North District'),
  ('Elm Street', '', 'H5J 6K7', 'Old Town'),
  ('Victoria Blvd', 'Unit 4B', 'J8K 9L0', 'Uptown'),
  ('Stone Way', NULL, 'L1M 2N3', 'South Park'),
  ('Oak Drive', '15A', 'M4N 5P6', 'Central'),
  ('Riverbank Ln', '', 'P7R 8S9', 'West End'),
  ('Crown Heights', NULL, 'R1S 2T3', 'Harbor View'),
  ('Sunset Road', 'Apt 303', 'T4V 5X6', 'Lakeside'),
  ('Another Riad', NULL, 'H8U 2R4', 'View Another');
  
-- Client table
INSERT INTO client (first_name, last_name, client_reference, phone_number, address_id)
VALUES
  ('John', 'Doe', 'JD-001', '+1 (555)-123-4567', 1),
  ('Emily', 'Clark', 'EC-202', '+1 (555)-234-5678', 2),
  ('Michael', 'Nguyen', 'MN-333', '+1 (555)-345-6789', 3),
  ('Sofia', 'Martinez', NULL, '+1 (555)-456-7890', 4),
  ('Liam', 'O\'Connor', 'LOC-999', '+1 (555)-567-8901', 5),
  ('Just', 'Some', 'REF', '+1 (555)-567-8901', 11);

-- Employee table
INSERT INTO employee (
	initials, first_name, last_name, position, phone_number, email, 
	is_admin, has_set_up_2fa, password_hash, secret, address_id
)
VALUES
  ('JD', 'Jane', 'Doe', 'Manager', '+1 (555) 123-4567', 'jane.doe@example.com', TRUE, TRUE, 'hashed_password_1', 'secret_key_1', 5),
  ('RT', 'Robert', 'Taylor', 'Sales', '+1 (555) 234-5678', 'robert.taylor@example.com', FALSE, FALSE, 'hashed_password_2', 'secret_key_2', 6),
  ('AL', 'Alice', 'Liu', 'Designer', '+1 (555) 345-6789', 'alice.liu@example.com', FALSE, TRUE, 'hashed_password_3', 'secret_key_3', 7),
  ('MK', 'Mohammed', 'Khan', 'Technician', '+1 (555) 456-7890', 'mohammed.khan@example.com', FALSE, FALSE, 'hashed_password_4', 'secret_key_4', 8),
  ('SC', 'Sophie', 'Chan', 'Installer', '+1 (555) 567-8901', 'sophie.chan@example.com', FALSE, TRUE, 'hashed_password_5', 'secret_key_5', 9);

-- Order table
INSERT INTO `order` (
	reference_number, price, `status`, invoice_number, 
	creation_date, fabrication_start_date, estimated_install_date, order_completed_date, 
	client_id, measured_by
)
VALUES
  ('ORD-1001', 2500.00, 'MEASURING', NULL, '2024-12-20 13:36:28', NULL, NULL, NULL, 1, 2),
  ('ORD-1002', 3200.50, 'ORDERING_MATERIAL', NULL, '2024-11-30 14:00:56', '2024-12-01', NULL, NULL, 2, 3),
  ('ORD-1003', 4500.00, 'FABRICATING', 'INV-883', '2024-12-04 09:36:28', '2024-12-05', '2024-12-15', NULL, 3, 1),
  ('ORD-1004', 5200.75, 'READY_TO_HANDOVER', 'INV-884', '2024-12-08 11:36:28', '2024-12-10', '2024-12-20', NULL, 4, 4),
  ('ORD-1005', 1999.99, 'INSTALLED', 'INV-885', '2024-11-06 16:36:28', '2024-11-20', '2024-11-30', '2024-12-01', 5, 1),
  ('ORD-1006', 2799.00, 'PICKED_UP', 'INV-886', '2024-11-25 18:36:28', '2024-12-01', '2024-12-10', '2024-12-11', 1, 2),
  ('ORD-1007', 3400.00, 'MEASURING', NULL, '2024-12-20 10:36:28', NULL, NULL, NULL, 2, 2),
  ('ORD-1008', 3900.25, 'ORDERING_MATERIAL', NULL, '2024-11-25 08:36:28', '2024-12-02', NULL, NULL, 3, 3),
  ('ORD-1009', 4700.50, 'FABRICATING', 'INV-887', '2024-12-04 12:36:28', '2024-12-08', '2024-12-18', NULL, 4, 5),
  ('ORD-1010', 6100.00, 'INSTALLED', 'INV-888', '2024-11-19 11:36:28', '2024-11-25', '2024-12-05', '2024-12-06', 5, 1),
  ('ORD-1011', 5000.00, 'MEASURING', NULL, '2024-12-20 05:10:10', NULL, NULL, NULL, 6, 1);

-- Payment table
INSERT INTO payment (
	amount, `type`, method, payment_date, order_id
)
VALUES
  (1250.00, 'DEPOSIT', 'CARD', '2024-10-01', 1),
  (1600.25, 'DEPOSIT', 'TRANSFER', '2024-10-03', 2),
  (2250.00, 'DEPOSIT', 'CASH', '2024-10-05', 3),
  (2600.00, 'DEPOSIT', 'CARD', '2024-10-06', 4),
  (1000.00, 'DEPOSIT', 'TRANSFER', '2024-10-07', 5),
  (1400.00, 'DEPOSIT', 'CASH', '2024-10-09', 6),
  (1800.75, 'DEPOSIT', 'CARD', '2024-10-10', 7),
  (1500.00, 'DEPOSIT', 'TRANSFER', '2024-10-11', 8),
  (1700.00, 'DEPOSIT', 'CASH', '2024-10-12', 9),
  (2000.00, 'DEPOSIT', 'CARD', '2024-10-13', 10),

  (2600.75, 'INSTALLMENT', 'TRANSFER', '2024-12-01', 4),
  (999.99, 'INSTALLMENT', 'CARD', '2024-12-02', 5),
  (1399.00, 'INSTALLMENT', 'CASH', '2024-12-03', 6),
  (4100.00, 'INSTALLMENT', 'TRANSFER', '2024-12-04', 10);

-- Activity table
INSERT INTO activity (
    activity_type, log_date, order_id, employee_id
)
VALUES
  ('VIEWED', '2024-12-14', 1, 3),
  ('EDITED', '2024-12-15', 2, 1),
  ('VIEWED', '2024-12-15', 3, 4),
  ('EDITED', '2024-12-16', 4, 2),
  ('VIEWED', '2024-12-17', 5, 5),
  ('EDITED', '2024-12-17', 6, 1),
  ('VIEWED', '2024-12-18', 7, 3),
  ('EDITED', '2024-12-19', 8, 2),
  ('VIEWED', '2024-12-20', 9, 4),
  ('EDITED', '2024-12-20', 10, 5);
