<?php
    /* Include all configuration files */
    require_once("config/periods.php");
    require_once("config/categories.php");

    /* Set some HTTP Headers */
    header("X-Powered-By: RRDash");

    /* Set the Current Period and Category */
    if (!isset($_GET['period']) || empty($_GET['period']) || !array_key_exists($_GET['period'], $TimePeriods)) {
        $CurrentPeriod = $DefaultTimePeriod;
    } else {
        $CurrentPeriod = $_GET['period'];
    }

    if (!isset($_GET['category']) || empty($_GET['category']) || !array_key_exists($_GET['category'], $Categories)) {
        $CurrentCategory = $DefaultCategory;
    } else {
        $CurrentCategory = $_GET['category'];
    }

?>

<!DOCTYPE html>
<html>
    <head>
        <title>RRDash</title>
        <meta charset="UTF-8">
        <meta name="description" content="RRDash is an open source dashboard for rrdtool.">
        <meta name="author" content="RRDash">
        <link rel="stylesheet" href="static/css/bootstrap.min.css">
    </head>
    <body>
        <!-- Navigation Bar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <a class="navbar-brand" href=".">RRDash</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarColor02" aria-controls="navbarColor02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarColor02">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href=".">Home</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Time Period
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <?php
                                foreach ($TimePeriods as $period => $values) {
                                    print("<a class=\"dropdown-item\" href=\"?period=" . $period . "&category=" . $CurrentCategory . "\">" . $values['name'] . "</a>");
                                }
                            ?>
                            <div class="dropdown-divider"></div>
                            <?php
                                print("<a class=\"dropdown-item\" href=\"?period=" . $DefaultTimePeriod . "&category=" . $CurrentCategory . "\">Default</a>");
                            ?>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Page Body -->
        <div class="row">
            <!-- Left Panel with all Categories -->
            <div class="col-3">
                <div class="list-group col-12">
                    <?php
                        foreach($Categories as $catid => $values) {
                            print("<a href=\"?period=" . $CurrentPeriod . "&category=" . $catid . "\" class=\"list-group-item list-group-item-action");
                            if ($CurrentCategory === $catid) {
                                print(" active");
                            }
                            print("\">");
                            print($values['name']);
                            print("</a>");
                        }
                    ?>
                </div>
            </div>
            <!-- Right Panel with all the Graphs -->
            <div class="col-9">
                <div class="row justify-content-center">
                    <?php
                        foreach($Categories[$CurrentCategory]['graphs'] as $graph) {
                            print("<img src=\"rrd.php");
                            print("?from=" . $TimePeriods[$CurrentPeriod]['from']);
                            print("&to=" . $TimePeriods[$CurrentPeriod]['to']);
                            print("&graph=" . $graph . "\"></img>");
                        }
                    ?>
                </div>
            </div>
        </div>

        <!-- JavaScript -->
        <script src="static/js/jquery.min.js"></script>
        <script src="static/js/popper.min.js"></script>
        <script src="static/js/bootstrap.min.js"></script>
    </body>
</html>