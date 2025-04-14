# OrderTrackingSystem

## Database Setup
The database used in this web application is MySQL. To setup the database, the `db_create.sql` file must be executed. For development purposes, the database connection is made using the username `root` and the password `12345678`.

## php-decimal Dependency
The php-decimal/php-decimal dependency is required for accurate decimal calculations. It can be installed using `composer require php-decimal/php-decimal`. However, it requires the ext-decimal php extension which may not included with XAMPP on Windows. The compiled DLL files for the different php versions can be found at: 
https://pecl.php.net/package/decimal/1.5.0/windows 

To install `ext-decimal`, the `php_decimal.dll` file must be placed inside the 
`C:\xampp\php\ext\` folder and the `libmpdec.dll` file must be placed inside
`C:\xampp\php\` folder. Then, the `php.ini` file must be edited to include the line `extension=php_decimal.dll` at the end of the `Module Settings` section.