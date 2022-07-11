<?php
include "Calculation.php";

class GaussianElimination
{
    private $matrix;
    private $ZVector;
    private $result;
    private $size;

    function  __construct($matrix, $ZVector, $size)
    {
        $this->matrix = $matrix;
        $this->ZVector = $ZVector;
        $this->size = $size;
        $this->result = array_fill(0,$size,0.0);
        for ($i = 0; $i < $size; $i++)
        {
            $this->result[$i] = 1;
        }
    }

    function findEquations()
    {
        for ($col = 0; $col < $this->size - 1; $col++)
        {
            echo "Step : " . strval(($col + 1)),"<br>";
            for ($row = $col + 1; $row < $this->size; $row++)
            {
                $firstValue = $this->matrix[$col][$col];
                $secondValue = $this->matrix[$row][$col];
                echo "R" . strval(($row + 1)) . " => " . strval($firstValue) . "R" . strval(($row + 1)) . " - " . strval($secondValue) . "R" . strval(($col + 1)) . "<br>","<br>";
                $i;
                for ($i = $col; $i < $this->size; $i++)
                {
                    echo "R" . strval(($row + 1)) . "(" . strval(($i + 1)) . ")" . " => " . strval($firstValue) . " * " . strval($this->matrix[$row][$i]) . " - " . strval($secondValue) . " * " . strval($this->matrix[$col][$i]);
                    $this->matrix[$row][$i] = $this->matrix[$row][$i] * $firstValue - $this->matrix[$col][$i] * $secondValue;
                    $this->matrix[$row][$i] = floatval(round($this->matrix[$row][$i],3));
                    if ($this->matrix[$row][$i] > -0.01 && $this->matrix[$row][$i] < 0.01)
                    {
                        $this->matrix[$row][$i] = 0;
                    }
                    echo " = " . strval($this->matrix[$row][$i]),"<br>";
                }
                echo "R" . strval(($row + 1)) . "(" . strval(($i + 1)) . ")" . " => " . strval($firstValue) . " * " . strval($this->ZVector[$row]) . " - " . strval($secondValue) . " * " . strval($this->ZVector[$col]);
                $this->ZVector[$row] = $this->ZVector[$row] * $firstValue - $this->ZVector[$col] * $secondValue;
                $this->ZVector[$row] = floatval(round($this->ZVector[$row],3));
                echo " = " . strval($this->ZVector[$row]),"<br>";
                echo "","<br>";
                $this->printMatrix();
            }
        }
    }

    function findResult()
    {
        for ($i = $this->size - 1; $i >= 0; $i--)
        {
            $text = "";
            $displaytextnumber = "";
            $displaytext = "";
            for ($j = 0; $j < $this->size; $j++)
            {
                if ($j != $i)
                {
                    $text = $text . "(" . strval(floatval(round($this->matrix[$i][$j] * $this->result[$j],3))) . ")+";
                    if ($this->matrix[$i][$j] * $this->result[$j] != 0)
                    {
                        $displaytext = $displaytext . "(" . strval($this->matrix[$i][$j]) . " * X" . strval(($j + 1)) . ") - ";
                        $displaytextnumber = $displaytextnumber . "(" . strval($this->matrix[$i][$j]) . " * " . strval($this->result[$j]) . ") - ";
                    }
                }
            }
            // Removing the last + sign
            $text = substr($text,0,strlen($text) - 1 - 0);
            if (!empty($displaytext))
            {
                $displaytext = substr($displaytext,0,strlen($displaytext) - 2 - 0);
                $displaytextnumber = substr($displaytextnumber,0,strlen($displaytextnumber) - 2 - 0);
            }
            $cal = new Calculation($text);
            $left = floatval($cal->getAnswer());
            $value = 0;
            $value = $this->ZVector[$i] - $left;
            $this->result[$i] = $value / $this->matrix[$i][$i];
            $this->result[$i] = floatval(round($this->result[$i],3));
            $value = floatval(round($value,3));
            if ($left == 0)
            {
                echo strval($this->matrix[$i][$i]) . "X" . strval(($i + 1)) . " = " . strval($this->ZVector[$i]),"<br>";
                echo "X" . strval(($i + 1)) . " = " . strval($value) . " / " . strval($this->matrix[$i][$i]),"<br>";
                echo "X" . strval(($i + 1)) . " = " . strval($this->result[$i]) . "<br>","<br>";
            }
            else 
            {
                echo strval($this->matrix[$i][$i]) . "X" . strval(($i + 1)) . " = " . strval($this->ZVector[$i]) . " - " . $displaytext,"<br>";
                echo strval($this->matrix[$i][$i]) . "X" . strval(($i + 1)) . " = " . strval($this->ZVector[$i]) . " - " . $displaytextnumber,"<br>";
                echo strval($this->matrix[$i][$i]) . "X" . strval(($i + 1)) . " = " . strval($this->ZVector[$i]) . " - " . strval($left),"<br>";
                echo "X" . strval(($i + 1)) . " = " . strval($value) . " / " . strval($this->matrix[$i][$i]),"<br>";
                echo "X" . strval(($i + 1)) . " = " . strval($this->result[$i]) . "<br>","<br>";
            }
        }
    }
    function printMatrix()
    {
        for ($i = 0; $i < $this->size; $i++)
        {
            for ($j = 0; $j < $this->size; $j++)
            {
                echo strval($this->matrix[$i][$j]) . "\t";
            }
            echo ":\t" . strval($this->ZVector[$i]);
            echo "","<br>";
        }
        echo "","<br>";
    }
    function printEquations()
    {
        echo "From the matrix, We find the equations are:<br>","<br>";
        for ($i = 0; $i < $this->size; $i++)
        {
            $text = "";
            for ($j = 0; $j < $this->size; $j++)
            {
                if ($this->matrix[$i][$j] != 0)
                {
                    if ($this->matrix[$i][$j] == 1)
                    {
                        $text = $text . "X" . strval(($j + 1)) . " + ";
                    }
                    else 
                    {
                        $text = $text . strval($this->matrix[$i][$j]) . "X" . strval(($j + 1)) . " + ";
                    }
                }
            }
            $text = substr($text,0,strlen($text) - 2 - 0);
            $text = $text . " = " . strval($this->ZVector[$i]);
            echo $text,"<br>";
        }
        echo "","<br>";
    }
    function runGaussianElimination()
    {
        echo "Given That,<br>The Matrix is:<br>","<br>";
        $this->printMatrix();
        $this->findEquations();
        $this->printEquations();
        echo "From the Equations, We get:<br>","<br>";
        $this->findResult();
        echo "<br>The Result is","<br>";
        for ($i = 0; $i < $this->size; $i++)
        {
            echo "X" . strval(($i + 1)) . " = " . strval($this->result[$i]),"<br>";
        }
    }
}

?>