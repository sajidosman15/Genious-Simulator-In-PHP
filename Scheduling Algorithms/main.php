<?php

include "FCFS.php";
include "HRRN.php";
include "NonPreemptiveSJF.php";


// $a = new FCFS();
// $a->perform();
// $a = new HRRN();
// $a->perform();

$a = new NonPreemptiveSJF();
$a->performs();
?>