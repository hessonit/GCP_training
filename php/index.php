<h1>
<?php
$name = getenv('NAME', true) ?: 'World';
echo sprintf('Hello %s!', $name);
?>
</h1>

<?php


$servername = "127.0.0.1";
$dbserver = getenv('DB_NAME', true);
$dbuser = getenv('DB_USER', true);
$dbpassword = getenv('DB_PASS', true);
// In a production blog, we would not store the MySQL
// password in the document root. Instead, we would store it in a
// configuration file elsewhere on the web server VM instance.
$mysqli = new mysqli($servername, $dbuser, $dbpassword, $dbserver);
if (mysqli_connect_error()) {
        echo ("Database connection failed: " . mysqli_connect_error());
} else {
    printf ("Database connection succeeded.\n");
}


$result = $mysqli->query("SELECT * FROM entries");
printf("Select returned %d rows.\n", $result->num_rows);

while ($row = $result -> fetch_row()) {
    printf ("%s (%s)\n", $row[0], $row[1]);
}
$result -> free_result();



$mysqli -> close();
?>