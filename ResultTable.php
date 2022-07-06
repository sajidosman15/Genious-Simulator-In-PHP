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
    function printRow()
    {
        echo strval($this->iter) . "\t" . $this->xl . "\t\t" . $this->xu . "\t\t" . $this->xr . "\t\t" . $this->error . "\t\t" . $this->fofxl . "\t\t" . $this->fofxu . "\t\t" . $this->fofxr,"<br>";
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
}

?>