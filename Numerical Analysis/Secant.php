<?php

include "Method.php";
include "ResultTable.php" ;

class Secant extends Method
{
    private $XiMinus1;
    private $Xi;
    private $XiPlus1;
    private $initialIteration = 0;
    private $endCount=0;

    function  __construct($function, $XiMinus1, $Xi)
    {
        parent::__construct($function);
        $this->XiMinus1 = $XiMinus1;
        $this->Xi = $Xi;
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
        $val = number_format($num, 5);
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
        $cal = new Calculation($text);
        $value = $cal->getAnswer();
        return $this->calculationFormat($value);
    }

    
    function getError()
    {
        echo "<br>      ( X" . strval(($this->initialIteration + 1)) . " - X" . strval(($this->initialIteration)) . " )","<br>";
        echo "=>|-----------------| x100","<br>";
        echo "\t  X" . strval(($this->initialIteration + 1)),"<br>";
        $text = "((" . parent::negativeCheck($this->Xi) . "-" . parent::negativeCheck($this->XiPlus1) . ")/" . parent::negativeCheck($this->XiPlus1) . ")*100";
        echo "<br>     (" . $this->XiPlus1 . " - " . $this->Xi . ")","<br>";
        echo "=>|-----------------| x100","<br>";
        echo "         " . $this->XiPlus1,"<br>";
        $cal = new Calculation($text);
        $value = $this->errorFormat($cal->getAnswer());
        if($value==0){
            $this->endCount=1;
        }
        $this->XiMinus1 = $this->Xi;
        $this->Xi = $this->XiPlus1;
        if ($value[0] == '-')
        {
            $value = substr($value,1,strlen($value) - 1);
        }
        $value = $value . "%";
        return $value;
    }

    function findRoot()
    {
        echo "<br>             f(X" . strval($this->initialIteration) . ") * (X" . strval($this->initialIteration) . " - X" . strval(($this->initialIteration - 1)) . ")","<br>";
        echo "X" . strval(($this->initialIteration + 1)) . " = " . "X" . strval($this->initialIteration) . " - -------------------------","<br>";
        echo "               f(X" . strval($this->initialIteration) . ") - f(X" . strval(($this->initialIteration - 1)) . ")","<br>";
        echo("<br>\t       ".parent::negativeCheck($this->getFofFunction(parent::negativeCheck($this->Xi)))." * (".parent::negativeCheck($this->Xi)." - ".parent::negativeCheck($this->XiMinus1).")<br>");
        echo "X" . strval(($this->initialIteration + 1)) . " = " . $this->Xi . " - -----------------------------","<br>";
        echo("                 ".parent::negativeCheck($this->getFofFunction(parent::negativeCheck($this->Xi)))." - ".parent::negativeCheck($this->getFofFunction(parent::negativeCheck($this->XiMinus1))));
        $text=parent::negativeCheck($this->Xi)."-((".parent::negativeCheck($this->getFofFunction(parent::negativeCheck($this->Xi)))."*(".parent::negativeCheck($this->Xi)."-".parent::negativeCheck($this->XiMinus1)."))/(".parent::negativeCheck($this->getFofFunction(parent::negativeCheck($this->Xi)))."-".parent::negativeCheck($this->getFofFunction(parent::negativeCheck($this->XiMinus1)))."))";
        $cal = new Calculation($text);
        $value = $cal->getAnswer();
        $this->XiPlus1=$this->rootFormat($value);
        echo "<br>X" . strval(($this->initialIteration + 1)) . " = " . $this->XiPlus1,"<br>";
    }

    function runSecant($iterationNumber)
    {
        echo "<br><br>Given That","<br>";
        echo "f(x) = " . $this->function,"<br>";
        echo "Xi-1 = " . $this->XiMinus1,"<br>";
        echo "Xi = " . $this->Xi . "<br>","<br>";
        $table = array_fill(0,$iterationNumber,NULL);
        $j = 0;
        for ($i = 1; $i < $iterationNumber + 1; $i++)
        {
            $j++;
            $table[$i - 1] = new ResultTable();
            $table[$i - 1]->iter = $i;
            $table[$i - 1]->xi = $this->Xi;
            $table[$i - 1]->xiMinus1 = $this->XiMinus1;
            echo "<br>Iteration : " . strval($i),"<br>";
            echo "<br>Step 1:","<br>";
            $this->findRoot();
            $table[$i - 1]->xiplus1 = $this->XiPlus1;
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
        echo "<th>Iteration</th> <th>Xi-1</th>   <th>Xi</th>    <th>Xi+1</th><th>Error</th>";
        echo("</tr>");
        for ($i = 0; $i < $j; $i++)
        {
            $table[$i]->printSecantRow();
        }
        echo("</table>");
        echo "","<br>";
    }
}

?>