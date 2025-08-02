<!--
  File: event.php
  Author: Jackson Champion
  Date: 2025-08-01
  Course: CPSC 3750 – Web Application Development
  Purpose: Shows events in any given day and allows users to add new events
  Notes: Retrieves event data from MySQL and uses PHP form inputs.
-->
<!DOCTYPE html>
<html>
<head>
    <title>Show/Add Events</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Show/Add Events</h1>

    <?php
    // Database connection
    $mysqli = mysqli_connect("localhost", "ewnuvdmy_demo_user", "JJ1241378j", "ewnuvdmy_calendarDB");


    if (!$mysqli) {
        die("Connection failed: " . mysqli_connect_error());
    }

    //If form submits, process input
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $safe_m = mysqli_real_escape_string($mysqli, $_POST['month']);
        $safe_d = mysqli_real_escape_string($mysqli, $_POST['day']);
        $safe_y = mysqli_real_escape_string($mysqli, $_POST['year']);
        $safe_event_title = mysqli_real_escape_string($mysqli, $_POST['event_title']);
        $safe_event_description = mysqli_real_escape_string($mysqli, $_POST['event_shortdesc']);
        $safe_event_time_hh = mysqli_real_escape_string($mysqli, $_POST['event_time_hh']);
        $safe_event_time_mm = mysqli_real_escape_string($mysqli, $_POST['event_time_mm']);
        $safe_date = $safe_y . "-" . $safe_m . "-" . $safe_d . " " . $safe_event_time_hh . ":" . $safe_event_time_mm . ":00";

        //add event into database
        $insEvent_sql = "INSERT INTO calendar_events (event_title, event_shortdesc, event_start)
                         VALUES ('$safe_event_title', '$safe_event_description', '$safe_date')";
        $insEvent_res = mysqli_query($mysqli, $insEvent_sql) or die(mysqli_error($mysqli));
    } else {
        //Gets date from URL
        $safe_m = mysqli_real_escape_string($mysqli, $_GET['m']);
        $safe_d = mysqli_real_escape_string($mysqli, $_GET['d']);
        $safe_y = mysqli_real_escape_string($mysqli, $_GET['y']);
    }

    //Shows events for the given day
    $event_sql = "SELECT event_title, event_shortdesc, event_start 
                  FROM calendar_events 
                  WHERE MONTH(event_start) = '$safe_m' 
                    AND DAY(event_start) = '$safe_d' 
                    AND YEAR(event_start) = '$safe_y' 
                  ORDER BY event_start";
    $event_res = mysqli_query($mysqli, $event_sql) or die(mysqli_error($mysqli));

    //Displays list of events
    if (mysqli_num_rows($event_res) > 0) {
        echo "<p><strong>Today's Events:</strong></p><ul>";
        while ($ev = mysqli_fetch_array($event_res)) {
            $event_title = stripslashes($ev['event_title']);
            $event_shortdesc = stripslashes($ev['event_shortdesc']);
            $fmt_date = date("g:i A", strtotime($ev['event_start']));
            echo "<li><strong>$fmt_date:</strong> $event_title<br>$event_shortdesc</li>";
        }
        echo "</ul>";
        mysqli_free_result($event_res);
    } else {
        echo "<p><strong>Today's Events:</strong> No events for this date.</p>";
    }

    mysqli_close($mysqli);
    ?>

    <hr>

    <!-- Form for events --->
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <p><strong>Would you like to add an event?</strong><br>
        Complete the form below and press the submit button to add the event and refresh this window.</p>

        <p>
            <label for="event_title">Event Title:</label><br>
            <input type="text" name="event_title" id="event_title" size="25" maxlength="255">
        </p>

        <p>
            <label for="event_shortdesc">Event Description:</label><br>
            <input type="text" name="event_shortdesc" id="event_shortdesc" size="25" maxlength="255">
        </p>

        <!--Time selection field-->
        <fieldset>
            <legend>Event Time (hh:mm):</legend>
            <select name="event_time_hh">
                <?php
                for ($i = 0; $i < 24; $i++) {
                    printf('<option value="%02d">%02d</option>', $i, $i);
                }
                ?>
            </select> :
            <select name="event_time_mm">
                <option value="00">00</option>
                <option value="15">15</option>
                <option value="30">30</option>
                <option value="45">45</option>
            </select>
        </fieldset>

        <!-- Hidden date fields -->
        <input type="hidden" name="month" value="<?php echo $safe_m; ?>">
        <input type="hidden" name="day" value="<?php echo $safe_d; ?>">
        <input type="hidden" name="year" value="<?php echo $safe_y; ?>">

        <p><button type="submit" name="submit" value="submit">Add Event</button></p>
    </form>
</body>
</html>
