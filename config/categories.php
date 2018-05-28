<?php

    /*
    Specify here all the categories you want to appear in the left-hand column. For each
    category you need to supply a unique ID that will be used internally by RRDash to refer
    to it. This ID will only show in the URL, as a GET parameter. For each category you
    need to specify the name that will appear, as well as the graphs that will be visible.
    */
    $Categories = array(
        "network" => array(
            "name" => "Network Traffic",
            "graphs" => array("eth0", "eth1", "lo"),
        ),
        "server" => array(
            "name" => "Server A",
            "graphs" => array("cpu", "ram", "disk"),
        ),
    );

    /*
    DefaultCategory is the ID of the category that will be visible initially, when RRDash
    is loaded.
    */
    $DefaultCategory = "network";
?>