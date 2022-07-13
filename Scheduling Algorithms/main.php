<?php

include "FCFS.php";
include "HRRN.php";
include "NonPreemptiveSJF.php";
include "PreemptiveSJF.php";
include "Priroty.php";


// $a = new FCFS();
// $a->perform();
// $a = new HRRN();
// $a->perform();

// $a = new NonPreemptiveSJF();
// $a->performs();

// $a = new PreemptiveSJF();
// $a->perform();

echo "1. Lower the number Higher the priroty","<br>";
echo "1. Higher the number Lower the priroty","<br>";
echo "2. Lower the number Lower the priroty","<br>";
echo "2. Higher the number Higher the priroty<br>","<br>";
// echo "Enter the Priroty :";

$p = 1;
if ($p == 1 || $p == 2) {
    $a = new Priroty();
    $a->perform($p);
} else {
    echo "Wrong Input","<br>";
}
?>