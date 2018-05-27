<?php

    /*
    Here you need to specify the rrdtool binary path in the system. You may use
    simply "rrdtool" and it will be searched in the PATH variable, but it is
    recommended for security reasons to set the full path, starting with the
    root directory (/).
    */
    $RRDToolPath = "/usr/bin/rrdtool";

    /* Defines */
    /*
    Here you can define constants that you may see repeated throughout the graph
    commands. For example, you may want to define the location of the RRD files
    on your system, so you don't have to type it again, or the height and width
    of the graphs, so they can be changed from a single place, or the watermark
    in the end of your files. Make sure all defines start with RRD_ to ensure
    they are not used anywhere else in the RRDash code.
    */
    define("RRD_PATH", "/var/lib/collectd/rrd/");
    define("RRD_DIMENSIONS", "-D -w 750 -h 300");
    define("RRD_CONSTANTS", "-E");

    /*
    The Graphs array contains all graphs that will be generated with rrdtool. Each
    graph must be assigned a unique ID. This unique ID will be used by RRDash
    internally, and will not be exposed to the user through the UI. The contents
    of each ID are the parameters that will be passed to rrdtool for graph generation.
    You can use the constants defined above, but each graph has its own needs. Things
    that usually go here can be the Title, Y-Axis Label, as well, of course, as the
    actual data. All data here will be passed to a shell, so it will be executed as
    code. BE VERY CAREFUL OF THE CONTENT OF THE LINES BELOW.
    */
    $Graphs = array(
        "eth0" => RRD_DIMENSIONS . " " . RRD_CONSTANTS . " -t \"Network Traffic on eth0\" DEF:rx=/tmp/eth0.rrd:rx:MAX DEF:tx=/tmp/eth0.rrd:tx:MAX AREA:rx#38e100:\"Receive\" LINE:tx#2c4de1:\"Transmit\"",
    );

?>