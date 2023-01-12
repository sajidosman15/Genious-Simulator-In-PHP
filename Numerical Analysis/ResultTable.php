<?php

class ResultTable
{
    public $iter;
    public $xl;
    public $xu;
    public $xr;
    public $error;
    public $fofxl;
    public $fofxu;
    public $fofxr;
    public $i;
    public $xi;
    public $xiMinus1;
    public $fofxi;
    public $fprimeofxi;
    public $xiplus1;
    public function printRow()
    {
        echo("<tr>");
        echo("<td>".strval($this->iter) . "</td> <td>" . $this->xl . "</td> <td>" . $this->xu . "</td> <td>" . $this->xr . "</td> <td>" . $this->error . "</td> <td>" . $this->fofxl . "</td> <td>" . $this->fofxu . "</td> <td>" . $this->fofxr."</td>");
        echo("</tr>");
    }
    function printRaphsonRow()
    {
        echo strval($this->iter) . "\t" . strval($this->i) . "      X" . strval($this->i) . " = " . $this->xi . "     \tf(X" . strval($this->i) . ") = " . $this->fofxi . "\t\tf\'(X" . strval($this->i) . ") = " . $this->fprimeofxi . "\t\tX" . strval(($this->i + 1)) . " = " . $this->xiplus1 . "    \t" . $this->error,"<br>";
    }
    function printSecantRow()
    {
        echo("<tr>");
        echo("<td>".strval($this->iter) . "</td> <td>" . $this->xiMinus1 . "</td><td>" . $this->xi . " </td> <td>" . $this->xiplus1 . "</td><td>" . $this->error."</td>");
        echo("</tr>");
    }

    function printFixedPointRow()
    {
        echo("<tr>");
        echo("<td>".strval($this->iter) . "</td> <td>" . strval($this->i) . "</td> <td>X" . strval($this->i) . " = " . $this->xi . "</td> <td>X" . strval(($this->i + 1)) . " = " . $this->xiplus1 . "</td> <td>" . $this->error . "</td>");
        echo("</tr>");
    }
}

?>