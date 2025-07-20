<?php
/*
  File: zipFinder.php
  Author: Jackson Champion
  Date: 2025-07-19
  Course: CPSC 3750 – Web Application Development
  Purpose: Calculates the distance between two Zip Codes using the haversine formula
  Notes: uses PHP to Read zip codes from a text file
*/

function loadZipFile($zipcodeFile) {
    $zipData = [];
    $file = fopen($zipcodeFile, "r");

    //Reads each line of the file
    while (($line = fgets($file)) !== false) {
        $line = trim($line);

        //Split line by white spaces
        $parts = preg_split('/\s+/', $line);

        //Ensures theres a ZIP, latitude, and longitude
        if (count($parts) >= 3) {
            $zip = $parts[0];         
            $lat = floatval($parts[1]); 
            $lng = floatval($parts[2]);

            //Store into a zip array
            $zipData[$zip] = ['lat' => $lat, 'lng' => $lng];
        }
    }

    fclose($file);
    return $zipData;
}


//The haversine formula that calculates distance between points on Earth
function haversine($latFrom, $lonFrom, $latTo, $lonTo, $earthRadius = 3958.8) {
    // Convert degrees to radians
    $latFrom = deg2rad($latFrom);
    $lonFrom = deg2rad($lonFrom);
    $latTo   = deg2rad($latTo);
    $lonTo   = deg2rad($lonTo);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $angle = 2 * asin(sqrt(
        pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)
    ));

    return $angle * $earthRadius;
}

// Loads zipcode data from the file
$zipData = loadZipFile("zip_lat_long.txt");

// Initialize variables
$distance = null;
$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['zip1'])) {
    $zip1 = trim($_POST['zip1']);
    } else {
        $zip1 = '';
    }

    if (isset($_POST['zip2'])) {
        $zip2 = trim($_POST['zip2']);
    } else {
        $zip2 = '';
    }

    //Checks if both Zip Codes exist
    if (!isset($zipData[$zip1]) || !isset($zipData[$zip2])) {
        $error = "ZIP codes not found!";
    } else {
        $lat1 = $zipData[$zip1]['lat'];
        $lon1 = $zipData[$zip1]['lng'];
        $lat2 = $zipData[$zip2]['lat'];
        $lon2 = $zipData[$zip2]['lng'];

    //Calculates the distance using the haversine formula
    $distance = haversine($lat1, $lon1, $lat2, $lon2);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>ZIP Code Distance Finder</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav>
        <div id="navbar"></div>
    </nav>
    
    <h1>ZIP Code Distance Finder</h1>


    <!--Form to Ask user to input two ZIP Codes-->
    <form method="POST">
        <label for="zip1">Enter First ZIP Code:</label><br>
        <input type="text" name="zip1" id="zip1" value="<?php echo $zip1; ?>"><br><br>

        <label for="zip2">Enter Second ZIP Code:</label><br>
        <input type="text" name="zip2" id="zip2" value="<?php echo $zip2; ?>"><br><br>

        <button type="submit">Calculate Distance</button>
    </form>

    <div>
        <?php if (!empty($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php elseif (!empty($distance)): ?>
            <p>Distance between <strong><?php echo $zip1; ?></strong> and <strong><?php echo $zip2; ?></strong> is:</p>
            <p><?php echo round($distance, 2); ?> miles</p>
        <?php endif; ?>
    </div>

    <footer>
        <h3>Contact Me</h3>
        <p> Email me at <a href="mailto:jackson.champion136@gmail.com">jackson.champion136@gmail.com</a></p>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            fetch('navbar.html')
                .then(response => response.text())
                .then(data => {
                    document.getElementById('navbar').innerHTML = data;
        });
    });
    </script>
</body>
</html>
