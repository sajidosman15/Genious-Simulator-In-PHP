<?php
include "Calculation.php";

class LuDecomposition
{
    private $matrix;
    private $Umatrix;
    private $Lmatrix;
    private $ZVector;
    private $d;
    private $result;
    private $size;
    private static $df = array();
    function  __construct($matrix, $ZVector, $size)
    {
        $this->matrix = $matrix;
        $this->ZVector = $ZVector;
        $this->size = $size;
        $this->Umatrix = array_fill(0,$size,array_fill(0,$size,0.0));
        $this->Lmatrix = array_fill(0,$size,array_fill(0,$size,0.0));
        $this->d = array_fill(0,$size,0.0);
        $this->result = array_fill(0,$size,0.0);

        $this->Umatrix=$matrix;
        
        for ($i = 0; $i < $size; $i++)
        {
            for ($j = 0; $j < $size; $j++)
            {
                $this->Lmatrix[$i][$j] = 0;
            }
        }
        for ($i = 0; $i < $size; $i++)
        {
            $this->Lmatrix[$i][$i] = 1;
            $this->d[$i] = 0;
            $this->result[$i] = 1;
        }
    }
    function findUandLMatrix()
    {
        echo "Step : 1<br>Find the [U] Matrix<br>","<br>";
        for ($col = 0; $col < $this->size - 1; $col++)
        {
            for ($row = $col + 1; $row < $this->size; $row++)
            {
                $val = $this->Umatrix[$row][$col] / $this->Umatrix[$col][$col];
                $val = floatval(number_format($val,3));
                echo strval($this->Umatrix[$row][$col]) . " / " . strval($this->Umatrix[$col][$col]) . " = " . strval($val),"<br>";
                echo "Row" . strval(($row + 1)) . " - Row" . strval(($col + 1)) . "*(" . strval($val) . ") =>","<br>";
                $this->Lmatrix[$row][$col] = $val;
                for ($i = $col; $i < $this->size; $i++)
                {
                    $this->Umatrix[$row][$i] = $this->Umatrix[$row][$i] - ($this->Umatrix[$col][$i] * $val);
                    $this->Umatrix[$row][$i] = floatval(number_format($this->Umatrix[$row][$i],3));
                    if ($this->Umatrix[$row][$i] > -0.01 && $this->Umatrix[$row][$i] < 0.01)
                    {
                        $this->Umatrix[$row][$i] = 0;
                    }
                }
                for ($i = 0; $i < $this->size; $i++)
                {
                    for ($j = 0; $j < $this->size; $j++)
                    {
                        echo strval($this->Umatrix[$i][$j]) . "\t";
                    }
                    echo "","<br>";
                }
                echo "","<br>";
            }
        }
    }
    function findValueOfD()
    {
        for ($i = 0; $i < $this->size; $i++)
        {
            $text = "";
            $displaytextnumber = "";
            $displaytext = "";
            for ($j = 0; $j < $this->size; $j++)
            {
                $text = $text . "(" . strval(floatval(number_format($this->Lmatrix[$i][$j] * $this->d[$j],3))) . ")";
                if ($this->Lmatrix[$i][$j] * $this->d[$j] != 0)
                {
                    $displaytext = $displaytext . "(" . strval($this->Lmatrix[$i][$j]) . " * d" . strval(($j + 1)) . ") - ";
                    $displaytextnumber = $displaytextnumber . "(" . strval($this->Lmatrix[$i][$j]) . " * " . strval($this->d[$j]) . ") - ";
                }
                if ($j != $this->size - 1)
                {
                    $text = $text . "+";
                }
            }
            if (!empty($displaytext))
            {
                $displaytext = substr($displaytext,0,strlen($displaytext) - 2 - 0);
                $displaytextnumber = substr($displaytextnumber,0,strlen($displaytextnumber) - 2 - 0);
            }
            $cal = new Calculation($text);
            $value = floatval($cal->getAnswer());
            if ($value == 0)
            {
                $this->d[$i] = $this->ZVector[$i];
                echo "d" . strval(($i + 1)) . " = " . strval($this->d[$i]) . "<br>","<br>";
            }
            else 
            {
                $this->d[$i] = $this->ZVector[$i] - $value;
                echo "d" . strval(($i + 1)) . " = " . strval($this->ZVector[$i]) . " - " . $displaytext,"<br>";
                echo "d" . strval(($i + 1)) . " = " . strval($this->ZVector[$i]) . " - " . $displaytextnumber,"<br>";
                echo "d" . strval(($i + 1)) . " = " . strval($this->ZVector[$i]) . " - " . strval($value),"<br>";
                echo "d" . strval(($i + 1)) . " = " . number_format($this->d[$i],3) . "<br>","<br>";
            }
            $this->d[$i] = floatval(number_format($this->d[$i],3));
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
                    $text = $text . "(" . strval(floatval(number_format($this->Umatrix[$i][$j] * $this->result[$j],3))) . ")+";
                    if ($this->Umatrix[$i][$j] * $this->result[$j] != 0)
                    {
                        $displaytext = $displaytext . "(" . strval($this->Umatrix[$i][$j]) . " * X" . strval(($j + 1)) . ") - ";
                        $displaytextnumber = $displaytextnumber . "(" . strval($this->Umatrix[$i][$j]) . " * " . strval($this->result[$j]) . ") - ";
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
            $value = $this->d[$i] - $left;
            $this->result[$i] = $value / $this->Umatrix[$i][$i];
            $this->result[$i] = floatval(number_format($this->result[$i],3));
            $value = floatval(number_format($value,3));
            if ($left == 0)
            {
                echo strval($this->Umatrix[$i][$i]) . "X" . strval(($i + 1)) . " = " . strval($this->d[$i]),"<br>";
                echo "X" . strval(($i + 1)) . " = " . strval($value) . " / " . strval($this->Umatrix[$i][$i]),"<br>";
                echo "X" . strval(($i + 1)) . " = " . strval($this->result[$i]) . "<br>","<br>";
            }
            else 
            {
                echo strval($this->Umatrix[$i][$i]) . "X" . strval(($i + 1)) . " = " . strval($this->d[$i]) . " - " . $displaytext,"<br>";
                echo strval($this->Umatrix[$i][$i]) . "X" . strval(($i + 1)) . " = " . strval($this->d[$i]) . " - " . $displaytextnumber,"<br>";
                echo strval($this->Umatrix[$i][$i]) . "X" . strval(($i + 1)) . " = " . strval($this->d[$i]) . " - " . strval($left),"<br>";
                echo "X" . strval(($i + 1)) . " = " . strval($value) . " / " . strval($this->Umatrix[$i][$i]),"<br>";
                echo "X" . strval(($i + 1)) . " = " . strval($this->result[$i]) . "<br>","<br>";
            }
        }
    }
    function runLuDecomposition()
    {
        $this->findUandLMatrix();
        echo "The Final [U] Matrix is :","<br>";
        for ($i = 0; $i < $this->size; $i++)
        {
            for ($j = 0; $j < $this->size; $j++)
            {
                echo strval($this->Umatrix[$i][$j]) . "\t";
            }
            echo "","<br>";
        }
        echo "","<br>";
        echo "Step : 2<br>The [L] Matrix is :","<br>";
        for ($i = 0; $i < $this->size; $i++)
        {
            for ($j = 0; $j < $this->size; $j++)
            {
                echo strval($this->Lmatrix[$i][$j]) . "\t";
            }
            echo "","<br>";
        }
        echo "","<br>";
        echo "Step : 3","<br>";
        echo "We Know [L]*[D]=[B]","<br>";
        $middle = (int)ceil((float)$this->size / 2);
        for ($i = 0; $i < $this->size; $i++)
        {
            for ($j = 0; $j < $this->size; $j++)
            {
                echo strval($this->Lmatrix[$i][$j]) . "\t";
            }
            if ($i == $middle - 1)
            {
                echo "*";
            }
            echo "\td" . strval(($i + 1)) . "\t";
            if ($i == $middle - 1)
            {
                echo "=";
            }
            echo "\t" . strval($this->ZVector[$i]),"<br>";
        }
        echo "","<br>";
        for ($i = 0; $i < $this->size; $i++)
        {
            $text = "";
            for ($j = 0; $j < $this->size; $j++)
            {
                if ($this->Lmatrix[$i][$j] != 0)
                {
                    if ($this->Lmatrix[$i][$j] == 1)
                    {
                        $text = $text . "d" . strval(($j + 1)) . " + ";
                    }
                    else 
                    {
                        $text = $text . strval($this->Lmatrix[$i][$j]) . "d" . strval(($j + 1)) . " + ";
                    }
                }
            }
            $text = substr($text,0,strlen($text) - 2 - 0);
            $text = $text . " = " . strval($this->ZVector[$i]);
            echo $text,"<br>";
        }
        echo "","<br>";
        $this->findValueOfD();
        echo "From The Equations we find","<br>";
        for ($i = 0; $i < $this->size; $i++)
        {
            echo "d" . strval(($i + 1)) . " = " . strval($this->d[$i]),"<br>";
        }
        echo "<br>Step : 4","<br>";
        echo "Again, We Know [U]*[X]=[D]","<br>";
        $middle = (int)ceil((float)$this->size / 2);
        for ($i = 0; $i < $this->size; $i++)
        {
            for ($j = 0; $j < $this->size; $j++)
            {
                echo strval($this->Umatrix[$i][$j]) . "\t";
            }
            if ($i == $middle - 1)
            {
                echo "*";
            }
            echo "\tX" . strval(($i + 1)) . "\t";
            if ($i == $middle - 1)
            {
                echo "=";
            }
            echo "\t" . strval($this->d[$i]),"<br>";
        }
        echo "","<br>";
        for ($i = 0; $i < $this->size; $i++)
        {
            $text = "";
            for ($j = 0; $j < $this->size; $j++)
            {
                if ($this->Umatrix[$i][$j] != 0)
                {
                    if ($this->Umatrix[$i][$j] == 1)
                    {
                        $text = $text . "X" . strval(($j + 1)) . " + ";
                    }
                    else 
                    {
                        $text = $text . strval($this->Umatrix[$i][$j]) . "X" . strval(($j + 1)) . " + ";
                    }
                }
            }
            $text = substr($text,0,strlen($text) - 2 - 0);
            $text = $text . " = " . strval($this->d[$i]);
            echo $text,"<br>";
        }
        echo "","<br>";
        $this->findResult();
        echo "<br>The Result is","<br>";
        for ($i = 0; $i < $this->size; $i++)
        {
            echo "X" . strval(($i + 1)) . " = " . strval($this->result[$i]),"<br>";
        }
    }
}

?>