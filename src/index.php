<!DOCTYPE HTML>
<html>
    <head>
        <title>bexio API Example</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="css/bootstrap.min.css" rel="stylesheet" media="screen">
        <style>
            body {
                padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
            }
        </style>
        <link href="css/bootstrap-responsive.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container-fluid" style="max-width: 1100px; margin: 0 auto;">
                    <a class="brand" href="index.php">bexio API Example</a>
                    <div class="nav-collapse collapse">
                        <ul class="nav">
                            <li><a href="http://www.bexio.com/kontakt.html">Contact</a></li>
                        </ul>
                    </div><!--/.nav-collapse -->
                </div>
            </div>
        </div>
        <div class="container" style="max-width: 1100px; margin: 0 auto;">
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-error">
                    <strong>Error!</strong> <?php echo $_GET['error'] ?>
                </div>
            <?php endif; ?>

            <h2>bexio OAuth2 Demo Application</h2>
            <p>Click on &quot;Authorize me&quot; to start the demo.</p>
            <br/>
            <a href="authorize.php" class="btn btn-primary">Authorize me</a>
        </div>
    </body>
</html>