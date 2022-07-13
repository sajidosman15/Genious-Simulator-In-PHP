<?php

include "FCFS.php";
include "HRRN.php";
include "NonPreemptiveSJF.php";
include "PreemptiveSJF.php";


// $a = new FCFS();
// $a->perform();
// $a = new HRRN();
// $a->perform();

// $a = new NonPreemptiveSJF();
// $a->performs();

$a = new PreemptiveSJF();
$a->perform();
?>