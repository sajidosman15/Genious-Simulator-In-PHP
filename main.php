<?php 

    //include "BiSection.php";
    //include "FalsePosition.php";
    //include "NewtonRaphson.php";
    //include "Secant.php";
    //include "FixedPoint.php";

    // $function = "-0.6x^2+2.4x+5.5";
    // $xl = "-3";
    // $xu = "2";
    // $iterationNumber = 5;

    // $functionX = "7x^3-8x+4";
    // $functionPrimeX = "21x^2-8";
    // $initialRoot = "-1";
    // $initialIteration = 0;
    // $numberOfIteration = 10;

    // $obj3 = new NewtonRaphson($functionX, $functionPrimeX, $initialIteration, $initialRoot);
    // $obj3->runNewton($numberOfIteration);

    // $obj = new FalsePosition($function, $xl, $xu);
    // $obj->runFalsePosition($iterationNumber);


    // $SecantfunctionX = "x^3-0.165x^2+3.993*10^-4";
    // $XiMinus1 = "0.02";
    // $Xi = "0.05";
    // $obj4 = new Secant($SecantfunctionX, $XiMinus1, $Xi);
    // $obj4->runSecant(5);


    // $fixedfunctionX = "(x+10)^(1/4)";
    // $fixedOldRoot = "4";
    // $FinitialIteration = 0;
    // $obj5 = new FixedPoint($fixedfunctionX, $fixedOldRoot, $FinitialIteration);
    //$obj5->runFixedPoint(10);

    include "Calculation.php";
    $cal = new Calculation("sqrt(sqrt(16))");
    echo($cal->getAnswer());
    // $t="(4)+(2)";
    // echo(strlen($t));
?>