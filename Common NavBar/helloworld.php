<!DOCTYPE html>
<html>
    <head>
        <Title> PHP Hello World  </Title>
        <link href="style.css" rel="stylesheet" type="text/css">
    </head>

    <body>
        <header>
            <h1> PHP Hello World!</h1>
        </header>
        
        <div id="navbar"></div>

    <h1 class="title"><?php echo "Hello, World!"; ?></h1>

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