<?php
include "Calculation.php";

class Method
{
    public $function;
    function  __construct($function)
    {
        $this->function = $function;
    }

    function negativeCheck($val)
    {
        if ($val[0] == '-')
        {
            $val = "(" . $val . ")";
        }
        return $val;
    }
    
    function decimalFormat($val)
    {
        $num = floatval($val);
        $val = number_format($num, 3);
        return $val;
    }
    function getFof($x)
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
        echo $text . "  ";
        $cal = new Calculation($text);
        $value = $cal->getAnswer();
        return $this->decimalFormat($value);
    }
    function getFofFalse($x)
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
        //        System.out.print(text+"  ");
        $cal = new Calculation($text);
        $value = $cal->getAnswer();
        return $this->decimalFormat($value);
    }
    function getTwoFunctionMulti($num1, $num2)
    {
        echo "=> ";
        $result1 = $this->getFof($this->negativeCheck($num1));
        echo "*  ";
        $result2 = $this->getFof(($this->negativeCheck($num2)));
        echo "<br>=> ";
        $text = $this->negativeCheck($result1) . "*" . $this->negativeCheck($result2);
        echo $text."<br>";
        $cal = new Calculation($text);
        $value = $this->decimalFormat($cal->getAnswer());
        return $value;
    }
}

?>