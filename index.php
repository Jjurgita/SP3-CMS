<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="./style.css">
    <title>CMS</title>
</head>

<body>
    <div class="container">
        <h2 class="header">Mini Content Management System (CMS) App</h2>
        <?php
        function startsWith($string, $startString)
        {
            $len = strlen($startString);
            return (substr($string, 0, $len) === $startString);
        }

        $url = $_SERVER['REQUEST_URI'];
        $root = '/CMS/';
        print("<br><br>");

        if (startsWith($url, $root . 'admin_page')) {
            require __DIR__ . '/src/views/admin.php';
        } elseif (startsWith($url, $root)) {
            require __DIR__ . '/src/views/pages.php';
        } else {
            http_response_code(404);
            print('<p style="color: red;">ERROR: Path not found.</p>');
        }
        ?>
        <footer class="footer">
            <p class="footerText">&copy Mini CMS 2021</p>
        </footer>
    </div>
</body>

</html>