<?php
include "Method.php";
include "ResultTable.php" ;

class NewtonRaphson extends Method
{
    private $functionPrimeX;
    private $initialIteration;
    private $oldRoot;
    private $newRoot;
    public $ProcessedFunction;
    public $ProcessedPrimeFunction;
    public $fofXi;
    public $fPrimeofXi;
    private $endCount=0;

    function  __construct($function, $functionPrimeX, $initialIteration, $oldRoot)
    {
        parent::__construct($function);
        $this->functionPrimeX = $functionPrimeX;
        $this->initialIteration = $initialIteration;
        $this->oldRoot = $oldRoot;
    }
    function calculationFormat($val)
    {
        $num = floatval($val);
        $val = number_format($num, 3);
        return $val;
    }
    function rootFormat($val)
    {
        $num = floatval($val);
        $val = number_format($num, 3);
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
        $this->ProcessedFunction = $text;
        $cal = new Calculation($text);
        $value = $cal->getAnswer();
        return $this->calculationFormat($value);
    }
    function getFofPrimeFunction($x)
    {
        $text = "";
        for ($i = 0; $i < strlen($this->functionPrimeX); $i++)
        {
            if ($this->functionPrimeX[$i] == 'x')
            {
                if ($i != 0)
                {
                    if ($this->function[$i - 1] != '(' && $this->functionPrimeX[$i - 1] != '+' && $this->functionPrimeX[$i - 1] != '-' && $this->functionPrimeX[$i - 1] != '/' && $this->functionPrimeX[$i - 1] != '*')
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
                $text = $text . $this->functionPrimeX[$i];
            }
        }
        $this->ProcessedPrimeFunction = $text;
        $cal = new Calculation($text);
        $value = $cal->getAnswer();
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

    function findRoot()
    {
        $this->fofXi = $this->getFofFunction(parent::negativeCheck($this->oldRoot));
        $this->fPrimeofXi = $this->getFofPrimeFunction(parent::negativeCheck($this->oldRoot));
        $text = parent::negativeCheck($this->oldRoot) . "-(" . parent::negativeCheck($this->fofXi) . "/" . parent::negativeCheck($this->fPrimeofXi) . ")";
        $cal = new Calculation($text);
        $value = $cal->getAnswer();

        $this->newRoot = $this->rootFormat($value);


        echo "\t     f(X" . strval($this->initialIteration) . ")","<br>";
        echo "X" . strval(($this->initialIteration + 1)) . " = X" . strval($this->initialIteration) . " - ------------","<br>";
        echo "\t     f\'(X" . strval($this->initialIteration) . ")<br>","<br>";
        echo "\t       " . $this->ProcessedFunction,"<br>";
        echo "X" . strval(($this->initialIteration + 1)) . " = " . $this->oldRoot . " - -------------------------------------","<br>";
        echo "\t\t" . $this->ProcessedPrimeFunction,"<br>";
        echo "<br>\t\t" . $this->fofXi,"<br>";
        echo "X" . strval(($this->initialIteration + 1)) . " = " . $this->oldRoot . " - --------------","<br>";
        echo "\t\t" . $this->fPrimeofXi,"<br>";
        echo "<br>X" . strval(($this->initialIteration + 1)) . " = " . $this->newRoot,"<br>";
    }

    function runNewton($iterationNumber)
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
            $this->findRoot();
            $table[$i - 1]->fofxi = $this->fofXi;
            $table[$i - 1]->fprimeofxi = $this->fPrimeofXi;
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
        echo "****Table****","<br>";
        echo "Iter\ti\t Xi\t\t   f(Xi)\t\t    f\'(Xi)\t\t  Xi+1\t\tError","<br>";
        for ($i = 0; $i < $j; $i++)
        {
            $table[$i]->printRaphsonRow();
        }
        echo "","<br>";
    }
}

?>