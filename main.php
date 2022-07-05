<?php 

    //include "BiSection.php";
    // include "FalsePosition.php";
    include "NewtonRaphson.php";

    // $function = "-0.6x^2+2.4x+5.5";
    // $xl = "-3";
    // $xu = "2";
    // $iterationNumber = 5;

    $functionX = "7x^3-8x+4";
    $functionPrimeX = "21x^2-8";
    $initialRoot = "-1";
    $initialIteration = 0;
    $numberOfIteration = 10;

    $obj3 = new NewtonRaphson($functionX, $functionPrimeX, $initialIteration, $initialRoot);
    $obj3->runNewton($numberOfIteration);

    // $obj = new FalsePosition($function, $xl, $xu);
    // $obj->runFalsePosition($iterationNumber);



    // include "Calculation.php";
    // $cal = new Calculation("(-325)x(-193)");
    // echo($cal->getAnswer());
    // $t="(4)+(2)";
    // echo(strlen($t));
?>