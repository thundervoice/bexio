<?php
require_once dirname(__FILE__) . "/config/config.php";
require_once dirname(__FILE__) . "/class/bexioConnector.class.php";

session_start();

/**
 * Check for a valid access_token and organisation
 */
if (!isset($_SESSION['access_token']) || !isset($_SESSION['org'])) {
    header("Location:index.php");
    die();
}

/**
 * Fetch all Countries (call the ressource "GET /country") and order them by name (ascending)
 */
$con = new bexioConnector(BEXIO_API_URL, $_SESSION['org'], $_SESSION['access_token']);

try {
    $countries = $con->getCountries(array('order_by' => 'name_asc'));
} catch (Exception $e) {
    header("Location: index.php?error=" . urlencode($e->getMessage()));
    die();
}

?>

<!DOCTYPE html>
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
            <h4>bexio OAuth2 Demo Application - Response</h4>
            <table class="table table-striped table-hover table-bordered table-condensed">
                <thead>
                    <tr>
                        <th width="50">ID</th>
                        <th width="300">Country</th>
                        <th>ISO 3166 Alpha 2</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($countries as $country): ?>
                        <tr>
                            <td><?php echo $country['id'] ?></td>
                            <td><?php echo $country['name'] ?></td>
                            <td><?php echo $country['iso_3166_alpha2'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <a href="index.php" class="btn btn-primary" style="margin-bottom: 20px">Restart Demo</a>
        </div>
    </body>
</html>