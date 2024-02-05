<?php

$location = $_POST['location'];
$consumption = $_POST['consumption'];


// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "sandeep";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

   
// Retrieve data for the selected location from the database
$sql = "SELECT solar_radiation, panel_efficiency, installation_cost_per_panel
        FROM solar_locations
        WHERE location_name = '$location'";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    
    $row = $result->fetch_assoc();

    // Extracting data
    $solar_radiation = $row['solar_radiation'];
    $panel_efficiency = $row['panel_efficiency'];
    $installation_cost_per_panel = $row['installation_cost_per_panel'];

    // Calculate the number of panels needed and total cost
     $energy_per_panel_per_day = $solar_radiation * $panel_efficiency;
     $panels_needed = ceil($consumption / $energy_per_panel_per_day);
    $total_cost = $panels_needed * $installation_cost_per_panel;

    // Display calculation result
    echo "<h2>Calculation Result for $location</h2>";
    echo "Number of solar panels needed: $panels_needed<br>";
    echo "Total cost of installation:" . number_format($total_cost, 2);
} else {
    // No data found for the selected location
    echo "Error: No data found for the selected location.";
}

$conn->close();
?>
