<?php 

    //include "BiSection.php";
    //include "FalsePosition.php";
    //include "NewtonRaphson.php";
    // include "Secant.php";
    include "FixedPoint.php";
    // include "LuDecomposition.php";
    // include "GaussianElimination.php";


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


    $fixedfunctionX = "(x+10)^(1/4)";
    $fixedOldRoot = "4";
    $FinitialIteration = 0;
    $obj5 = new FixedPoint($fixedfunctionX, $fixedOldRoot, $FinitialIteration);
    $obj5->runFixedPoint(10);

    $size = 3;
    $array = array_fill(0,$size,array_fill(0,$size,0.0));
    $ZVector = array_fill(0,$size,0.0);
    $array[0][0] = 25;
    $array[0][1] = 5;
    $array[0][2] = 1;

    $array[1][0] = 64;
    $array[1][1] = 8;
    $array[1][2] = 1;

    $array[2][0] = 144;
    $array[2][1] = 12;
    $array[2][2] = 1;

    $ZVector[0] = 106.8;
    $ZVector[1] = 177.2;
    $ZVector[2] = 279.2;

    // $obj6 = new LuDecomposition($array, $ZVector, $size);
    // $obj6->runLuDecomposition();

    // $obj7 = new GaussianElimination($array, $ZVector, $size);
    // $obj7->runGaussianElimination();

    // include "Calculation.php";
    // $cal = new Calculation("sqrt(sqrt(16))");
    // echo($cal->getAnswer());
    // $t="(4)+(2)";
    // echo(strlen($t));
?>