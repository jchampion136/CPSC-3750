<?php
/*
  File: showcalendar.php
  Author: Jackson Champion
  Date: 2025-08-01
  Course: CPSC 3750 – Web Application Development
  Purpose: Displays the gregorian calender where users can select months/year
  Notes: Users view existing events and can click dates to add events
*/

//Number of seconds in a day
define("ADAY", (86400));


if ((!isset($_POST['month']) || !isset($_POST['year']))){
    $nowArray = getdate();
    $month = $nowArray['mon'];
    $year = $nowArray['year'];
} else {
    $month = (int) $_POST['month'];
    $year = (int) $_POST['year'];
}

//Creates timestamp
$start = mktime(12, 0, 0, $month, 1, $year);
$firstDayArray = getdate($start);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?php echo "Calendar: ".$firstDayArray['month']."
    ".$firstDayArray['year' ]; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style.css">
    <title>Calendar</title>
</head>
<body>
    <h1>Select a Month/Year Combination</h1>

    <div id="navbar"></div>

    <p><b>Click a date to add an event. Refresh the page to see the updated list.</b></p>
    
    <!--Form To select Month/Year-->
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
    <select name="month">
    <?php

    //Array for Months of the year
    $months = Array("January", "February", "March", "April", "May", "June", 
                    "July", "August", "September", "October", "November", "December");
    for ($i = 1; $i <= count($months); $i++) {
        echo "<option value='$i'";
        if ($i == $month) {
            echo " selected='selected'";
        }
        echo ">" . $months[$i - 1] . "</option>";
    }
    ?>
    </select>
    <select name="year">
    <?php

    //Dropdown for years from 1900 to 2050
    for ($i = 1900; $i <= 2050; $i++) {
        echo "<option value='$i'";
        if ($i == $year) {
            echo " selected='selected'";
        }
        echo ">$i</option>";
    }
    ?>
    </select>
    <button type="submit" name="submit" value="submit">Go!</button>
    </form>
    <br>
    <?php
    //Creates day array
    $days = Array("Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat");

    //Starts table and renders name of days
    echo "<table><tr>\n";
    foreach ($days as $day) {
        echo "<td>$day</td>\n";
    }

    //Loops over at most 42 days or 6 weeks
    for ($count = 0; $count < (6*7); $count++) {
        $dayArray = getDate($start);

        //Starts a new row every seven days
        if (($count % 7) == 0) {
            if ($dayArray['mon'] != $month) {
                break;
            } else {
                echo "</tr><tr>";
            }
        }


        if ($count < $firstDayArray['wday'] || $dayArray['mon'] != $month) {
            echo "<td>&nbsp</td>\n";
        }
        else {
            $event_title = "";

            //Start DB Connection
            $mysqli = mysqli_connect("localhost",  "ewnuvdmy_demo_user", "JJ1241378j", "ewnuvdmy_calendarDB");

            //Query for events on different days
            $chkEvent_sql = "SELECT event_title FROM calendar_events WHERE month(event_start) = '".$month."' AND
                dayofmonth(event_start) = '".$dayArray['mday']."'
                AND year(event_start) = '".$year."' ORDER BY event_start";
            $chkEvent_res = mysqli_query($mysqli, $chkEvent_sql) or die(mysqli_error($mysqli));

            if (mysqli_num_rows($chkEvent_res) > 0) {
                while ($ev = mysqli_fetch_array($chkEvent_res)) {
                    $event_title .= stripslashes($ev['event_title']) . "<br>";
                }
            } else {
                $event_title = "";
            }
            echo "<td><a href=\"javascript:eventWindow('event.php?m=".$month.
            "&&d=".$dayArray['mday']."&&y=".$year."')\">".$dayArray['mday']."</a><br>".$event_title."</td>\n";
            unset($event_title);
            $start += ADAY;
        }
    }   
    echo "</tr></table>";
    mysqli_close($mysqli);
    ?>

    <footer>
        <h3>Contact Me</h3>
        <p> any questions? feel free to email me at
        <a href="mailto:jackson.champion136@gmail.com">jackson.champion136@gmail.com</a>
        </p>
    </footer>

    <script type="text/javascript">
        function eventWindow(url) {
            event_popupWin = window.open(url, 'event', 'resizable=yes,scrollbars=yes,width=600,height=400');
            event_popupWin.opener = self;
        }
    </script>
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