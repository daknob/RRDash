<?php

    /* This function is used in case of an error. Returns all apropriate headers
    to the browser, and then serves an error image from the static folder. */
    function showImageError($error) {
        error_log("RRDash Error: rrd.php: $error");
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header("X-RRDash-Error: $error");
        print( file_get_contents( "static/img/error.png" ) );
    }

    /* Send the image/png Content-Type */
    header("Content-Type: image/png");

    /* Check if all required parameters are passed */
    if (!isset($_GET['from']) || empty($_GET['from'])) {
        showImageError("Variable 'from' not supplied");
        exit();
    }
    if (!isset($_GET['to']) || empty($_GET['to'])) {
        showImageError("Variable 'to' not supplied");
        exit();
    }
    if (!isset($_GET['graph']) || empty($_GET['graph'])) {
        showImageError("Variable 'graph' not supplied");
        exit();
    }

    /* Convert GET parameters to more handleable variables */
    $from = $_GET['from'];
    $to = $_GET['to'];
    $graph = $_GET['graph'];

    /* Convert from and to to integers, for many reasons.. */
    $from = intval($from);
    $to = intval($to);

    /* Load the Graphs configuration file */
    require_once("config/graphs.php");

    /* Check if the required graph exists */
    if (!array_key_exists($graph, $Graphs)) {
        showImageError("Graph not found");
        exit();
    }

    /* Send some HTTP Headers */
    header("Cache-Control: public, max-age=60");
    header("X-Powered-By: RRDash");

    /* Synthesize command */
    $cmd =  "$RRDToolPath graph \"/dev/stdout\" -s $from -e $to -a PNG ";
    $cmd .= $Graphs[$graph];

    /* Execute the command, and return the input to the user */
    /*
    Security Notice:
        This will execute a shell command. If an attacker has control of the parameters
        passed to this command, they will be able to achieve Remote Code Execution, and
        fully compromise the server. This PHP page only adds two user controlled values
        to the command executed, the from and to GET parameters. While this would be, in
        normal circumstances enough to be exploited, both values are first passed from
        PHP's intval() function first. This function returns an int, *and only* and int.
        If anything other than a number is passed, PHP will convert this to a number. To
        the best of my knowledge, this is not exploitable, unless PHP has some more
        surprises for us. Now in addition to these two above, a string is passed to the
        shell (the graph specification). This is taken from the configuration file, which
        is written by the RRDash administrator. Therefore, it is considered trusted,
        since the administrator can execute arbitrary commands to the server anyways.
        In case someone finds an arbitrary file write from another program, or RRDash,
        and they can write to this file remotely, it is not a risk, since they could
        add their executable code there anyways. Therefore, with all that said, this call
        is probably secure. If you are still uncomfortable, do not use RRDash. Sorry! :-(
    */
    print( passthru( $cmd ) );
?>