<?php
include "Method.php";
include "ResultTable.php" ;

class FalsePosition extends Method
{
    private $xl;
    private $xu;
    private $xr;
    private $xrold = "-99999";

    function  __construct($function, $xl, $xu)
    {
        parent::__construct($function);
        $this->xl = $xl;
        $this->xu = $xu;
    }


    function getFofXLandFofXU(){
        return parent::getTwoFunctionMulti($this->xl,$this->xu);
    }

    function getFofXLandFofXR(){
        $result= parent::getTwoFunctionMulti($this->xl,$this->xr);
        return $result;
    }

    function getXR(){
        echo("<br>           ".parent::negativeCheck(parent::getFofFalse(parent::negativeCheck($this->xu)))." * (".parent::negativeCheck($this->xl)." - ".parent::negativeCheck($this->xu).")<br>");
        echo("=> ".$this->xu." - ---------------------------<br>");
        echo("                 ".parent::negativeCheck(parent::getFofFalse(parent::negativeCheck($this->xl)))." - ".parent::negativeCheck(parent::getFofFalse(parent::negativeCheck($this->xu)))."<br>");
        
        
        $text=parent::negativeCheck($this->xu)."-((".parent::negativeCheck(parent::getFofFalse(parent::negativeCheck($this->xu)))."*(".parent::negativeCheck($this->xl)."-".parent::negativeCheck($this->xu)."))/(".parent::negativeCheck(parent::getFofFalse(parent::negativeCheck($this->xl)))."-".parent::negativeCheck(parent::getFofFalse(parent::negativeCheck($this->xu)))."))";
                
        $cal = new Calculation($text);
        $value = $cal->getAnswer();
        $this->xr=parent::decimalFormat($value);
        return parent::decimalFormat($value);
    }

    function getError()
    {
        if ((strcmp($this->xrold,"-99999")==0))
        {
            $this->xrold = $this->xr;
            return "-";
        }
        else 
        {
            echo "   (Xr old - Xr new)","<br>";
            echo "=>|-----------------| x100","<br>";
            echo "        Xr new","<br>";
            $text="((".parent::negativeCheck($this->xrold)."-".parent::negativeCheck($this->xr).")/".parent::negativeCheck($this->xr).")*100";
            echo "<br>     (" . $this->xrold . " - " . $this->xr . ")","<br>";
            echo "=>|-----------------| x100","<br>";
            echo "        " . $this->xr,"<br>";
            // echo($text."<br>");
            $cal = new Calculation($text);
            $value = parent::decimalFormat($cal->getAnswer());
            $this->xrold = $this->xr;
            if ($value[0] == '-')
            {
                $value = substr($value,1,strlen($value) - 1);
            }
            $value =$value . "%";
            return $value;
        }
    }

    function runFalsePosition($iterationNumber)
    {
        $table = array_fill(0,$iterationNumber,NULL);
        $j = 0;
        for ($i = 1; $i < $iterationNumber + 1; $i++)
        {
            $j++;
            $table[$i - 1] = new ResultTable();
            $table[$i - 1]->iter = $i;
            $table[$i - 1]->xl = $this->xl;
            $table[$i - 1]->xu = $this->xu;
            echo "Iteration : " . strval($i),"<br>";
            echo "<br>Step 1:","<br>";
            echo "f(xl) * f(xu) =","<br>";
            $mul=$this->getFofXLandFofXU();
            $table[$i-1]->fofxl=parent::getFofFalse(parent::negativeCheck($this->xl));
            $table[$i-1]->fofxu=parent::getFofFalse(parent::negativeCheck($this->xu));
            echo "=> " . $mul,"<br>";
            if (floatval($mul) > 0)
            {
                echo "f(xl) * f(xu) < 0","<br>";
                break;
            }
            echo "<br>Step 2:","<br>";
            echo "         f(Xu) * (Xl - Xu)","<br>";
            echo "=> Xu - -------------------","<br>";
            echo "           f(Xl) - f(Xu)","<br>";
            $table[$i-1]->xr=$this->getXR();
            echo "=> " . $table[$i - 1]->xr,"<br>";
            echo "<br>Error:","<br>";
            $table[$i-1]->error=$this->getError();
            echo "=> " . $table[$i - 1]->error,"<br>";
            if (strtolower($table[$i - 1]->error) == strtolower("0%"))
            {
                break;
            }
            echo "<br>Step 3:","<br>";
            echo "f(xl) * f(xr) =","<br>";
            $result=$this->getFofXLandFofXR();
            $table[$i-1]->fofxr=parent::getFofFalse(parent::negativeCheck($this->xr));
            echo "=> " . $result,"<br>";
            $res = floatval($result);
            if ($res < 0)
            {
                $this->xu = $this->xr;
                echo "<br>Xu = Xr = " . $this->xr,"<br>";
            }
            else if ($res > 0)
            {
                $this->xl = $this->xr;
                echo "<br>Xl = Xr = " . $this->xr,"<br>";
            }
            else 
            {
                break;
            }
            echo "","<br>";
        }
        echo "<br>","<br>";
        echo "****Table****","<br>";
        echo "Iter\tXl\t\tXu\t\tXr\t\tError\t\tf(xl)\t\tf(xu)\t\tf(xr)","<br>";
        for ($i = 0; $i < $j; $i++)
        {
            $table[$i]->printRow();
        }
        echo "","<br>";
    }


}

?>