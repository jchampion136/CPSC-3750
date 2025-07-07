<!--
  File: forms.php
  Author: Jackson Champion
  Date: 2025-07-07
  Course: CPSC 3750 – Web Application Development
  Purpose: Inputs information for forms using PHP onto a Webpage
  Notes: uses PHP and HTML
-->
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Forms</title>
  <link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>

    <h1>Forms</h1>
    <div id="navbar"></div>


<?php if (isset($_POST['text_input'])): ?>
    <h2>Submitted Form Information</h2>

    <!--Text Input Output -->
    <p><strong>First and Last Name:</strong> <? echo $_POST['text_input'] ?></p>

    <!--Text Area Output -->
    <p><strong>Additional Information:</strong><br><? echo $_POST['textarea_input'] ?></p>

    <!--Password Output -->
    <p><strong>Password:</strong> <? echo $_POST['password_input'] ?></p>

    <!--CheckBox Output -->
    <p><strong>Languages Learned:</strong><br>
        <?php
            foreach ($_POST['languages'] as $lang) {
                echo "- " . htmlspecialchars($lang) . "<br>";
            }
        ?>
    </p>

    <!--Radio Button Output-->
    <p><strong>School Year:</strong> <? echo $_POST['school'] ?></p>

    <!--Selection List Output-->
    <p><strong>Favorite Movie Genre:</strong> <? echo $_POST['movie_genre'] ?></p>

    <!--Upload File Output-->
    <p><strong>Uploaded File Name: </strong> <?echo $_POST['upload_file'] ?></p>

    <!--URL Output-->
    <p><strong>Website URL:</strong> <? echo $_POST['site_url'] ?></p>

    
<?php endif; ?>


<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    
    <!--Text Input Demo -->
    <p>
        <label>First and Last Name(Text Demo):<br>
            <input type="text" name="text_input">
        </label>
    </p>

    <!--Text Area Demo -->
    <p>
        <label>Additional Information About You(Text Area Demo):<br>
            <textarea name="textarea_input" style="textAreaInput"></textarea>
        </label>
    </p>

    <!--Password Demo -->
    <p>
        <label>Password(Password Demo):<br>
            <input type="password" name="password_input" required>
        </label>
    </p>

    <!--CheckBox Demo -->
    <p><strong>Programming Languages Learned(Checkbox Demo): </strong><br>
        <label><input type="checkbox" name="languages[]" value="HTML"> HTML</label><br>
        <label><input type="checkbox" name="languages[]" value="C++"> C++ </label><br>
        <label><input type="checkbox" name="languages[]" value="JavaScript"> JavaScript</label><br>
        <label><input type="checkbox" name="languages[]" value="PHP"> PHP</label><br>
        <label><input type="checkbox" name="languages[]" value="SQL"> SQL</label>

    </p>


    <!--Radio Button Demo -->
    <p><strong>School Year(Radio Demo):</strong><br>
        <label><input type="radio" name="school" value="Freshman">Freshman</label><br>
        <label><input type="radio" name="school" value="Sophomore">Sophomore</label><br>
        <label><input type="radio" name="school" value="Junior">Junior</label><br>
        <label><input type="radio" name="school" value="Senior">Senior</label><br>
    </p>

    <!--Selection List Demo -->
    <p>
        <label>Favorite Movie Genre(Selection List Demo):<br>
            <select name="movie_genre">
                <option value="Fantasy">Fantasy</option>
                <option value="Sci-Fi">Sci-Fi</option>
                <option value="Historical Fiction">Historical Fiction</option>
                <option value="Comedy">Comedy</option>
                <option value="Horror">Horror</option>
            </select>
        </label>
    </p>

    <!--Upload File Demo-->
    <p>
        <label>Upload a File(Upload File Demo):<br>
            <input type="file" name="upload_file">
        </label>
    </p>

     <!--URL Demo-->
    <p>
        <label>Your Website URL(URL Demo):<br>
            <input type="url" name= "site_url">
        </label>
    </p>

    <!--Submit-->
    <p>
        <button type="submit">Submit</button>
    </p>
</form>

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
