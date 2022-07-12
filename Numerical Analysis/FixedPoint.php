<?php

include "Method.php";
include "ResultTable.php" ;

class FixedPoint extends Method
{
    private $oldRoot;
    private $newRoot;
    private $initialIteration;
    private $endCount=0;

    function  __construct($function, $oldRoot, $initialIteration)
    {
        parent::__construct($function);
        $this->oldRoot = $oldRoot;
        $this->initialIteration = $initialIteration;
    }

    function calculationFormat($val)
    {
        $num = floatval($val);
        $val = number_format($num, 7);
        return $val;
    }
    function rootFormat($val)
    {
        $num = floatval($val);
        $val = number_format($num, 7);
        return $val;
    }
    function errorFormat($val)
    {
        $num = floatval($val);
        $val = number_format($num, 3);
        return $val;
    }

    function getFofFunction($x)
    {
        $text = "";
        for ($i = 0; $i < strlen($this->function); $i++)
        {
            if ($this->function[$i] == 'x')
            {
                if ($i != 0)
                {
                    if ($this->function[$i - 1] != '(' && $this->function[$i - 1] != '+' && $this->function[$i - 1] != '-' && $this->function[$i - 1] != '/' && $this->function[$i - 1] != '*')
                    {
                        $text = $text . "*" . $x;
                    }
                    else 
                    {
                        $text = $text . $x;
                    }
                }
                else 
                {
                    $text = $text . $x;
                }
            }
            else 
            {
                $text = $text . $this->function[$i];
            }
        }
        echo "X" . strval(($this->initialIteration + 1)) . " => g(X" . strval($this->initialIteration) . ")","<br>";
        echo "X" . strval(($this->initialIteration + 1)) . " => " . $text,"<br>";
        $cal = new Calculation($text);
        $value = $cal->getAnswer();
        echo "X" . strval(($this->initialIteration + 1)) . " => " . $value,"<br>";
        return $this->calculationFormat($value);
    }

    function getError()
    {
        echo "<br>      ( X" . strval(($this->initialIteration + 1)) . " - X" . strval(($this->initialIteration)) . " )","<br>";
        echo "=>|-----------------| x100","<br>";
        echo "\t  X" . strval(($this->initialIteration + 1)),"<br>";
        $text = "((" . parent::negativeCheck($this->oldRoot) . "-" . parent::negativeCheck($this->newRoot) . ")/" . parent::negativeCheck($this->newRoot) . ")*100";
        echo "<br>     (" . $this->newRoot . " - " . $this->oldRoot . ")","<br>";
        echo "=>|-----------------| x100","<br>";
        echo "         " . $this->newRoot,"<br>";
        $cal = new Calculation($text);
        $value = $this->errorFormat($cal->getAnswer());
        if($value==0){
            $this->endCount=1;
        }
        $this->oldRoot = $this->newRoot;
        if ($value[0] == '-')
        {
            $value = substr($value,1,strlen($value) - 1);
        }
        $value =$value . "%";
        return $value;
    }


    function runFixedPoint($iterationNumber)
    {
        $table = array_fill(0,$iterationNumber,NULL);
        $j = 0;
        for ($i = 1; $i < $iterationNumber + 1; $i++)
        {
            $j++;
            $table[$i - 1] = new ResultTable();
            $table[$i - 1]->iter = $i;
            $table[$i - 1]->i = $this->initialIteration;
            $table[$i - 1]->xi = $this->oldRoot;
            echo "<br>Iteration : " . strval($i),"<br>";
            echo "<br>Step 1:","<br>";
            $this->newRoot=$this->getFofFunction(parent::negativeCheck($this->oldRoot));
            $table[$i - 1]->xiplus1 = $this->newRoot;
            echo "<br>Step 2:","<br>";
            echo "Error:","<br>";
            $table[$i-1]->error=$this->getError();
            echo "<br>=> " . $table[$i - 1]->error,"<br>";
            if ($this->endCount==1)
            {
                break;
            }
            $this->initialIteration++;
        }
        echo "<br>","<br>";
        echo("<style>
        table, th, td {
          border:1px solid black;
        }
        </style>");
        echo "****Table****","<br>";
        echo("<table>");
        echo("<tr>");
        echo "<th>Iter</th><th>i</th><th>Xi</th><th>Xi+1</th><th>Error</th>";
        echo("</tr>");
        for ($i = 0; $i < $j; $i++)
        {
            $table[$i]->printFixedPointRow();
        }
        echo("</table>");
        echo "","<br>";
    }
}

?>