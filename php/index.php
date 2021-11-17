<h1>Welcome to my page!</h1>
<?php
$name = getenv('NAME', true) ?: 'World';
echo sprintf('Hello %s!', $name);
?>
<?php


$servername = "127.0.0.1";
$dbserver = getenv('DB_NAME', true);
$dbuser = getenv('DB_USER', true);
$dbpassword = getenv('DB_PASS', true);
// In a production blog, we would not store the MySQL
// password in the document root. Instead, we would store it in a
// configuration file elsewhere on the web server VM instance.
$conn = new mysqli($servername, $dbuser, $dbpassword, $dbserver);
if (mysqli_connect_error()) {
        echo ("Database connection failed: " . mysqli_connect_error());
} else {
        echo ("Database connection succeeded.");
}

?>