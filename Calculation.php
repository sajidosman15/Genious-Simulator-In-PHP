<?php

class Calculation
{
    private $text;
    private $error = false;
    function  __construct($text)
    {
        $this->text = $text;
    }
    function getAnswer()
    {
        $ans = 0;
        if ((strpos($this->text,"^-") !== false ))
        {
            $this->text = str_replace("^-","^~",$this->text);
        }
        // Change the minus sign
        if ((strpos($this->text,"-") !== false ))
        {
            $this->text = str_replace("-","k",$this->text);
        }
        // If text contain brackets then remove the brackets
        if ((strpos($this->text,"(") !== false ) || (strpos($this->text,")") !== false ))
        {
            $this->text = $this->firstBracketCheck($this->text);
            // reducing first bracket
            if ((strpos($this->text,".") !== false ))
            {
                $this->text = str_replace(".","·",$this->text);
            }
            $ans = $this->calculate($this->text);
        }
        else 
        {
            $ans = $this->calculate($this->text);
        }
        if ($this->error == true)
        {
            return "Error";
        }
        return strval($ans) . "";
    }
    function firstBracketCheck($text)
    {
        try
        {
            $firstindex = -1;
            $lastindex = -1;
            $texts1;
            $texts2;
            $texts3;
            // Identify the indexes of brackets and
            //            separate them in different module
            $text=trim($text);
            for ($i = 0; $i < strlen($text); $i++)
            {
                if ($text[$i] == "(")
                {
                    $firstindex = $i;
                }
                if ($text[$i] == ")")
                {
                    $lastindex = $i;
                    break;
                }
            }
            $texts2 = substr($text,$firstindex + 1,$lastindex-($firstindex + 1));
            
            // texts inside the bracket is storing here
            // if bracket is not the first character
            //            then store those first characters
            if ($firstindex != 0)
            {
                $texts1 = substr($text,0,$firstindex);
                
            }
            else 
            {
                $texts1 = "";
            }
            // if brackets is not the last character then
            //            store those last characters
            if ($lastindex != strlen($text))
            {
                $texts3 = substr($text,$lastindex + 1,strlen($text));
                
            }
            else 
            {
                $texts3 = "";
            }
            // if the last character of the first part of string does not
            //            contain a symbol then add multiplication there
            $txt1lngt = strlen($texts1);
            if ($txt1lngt != 0)
            {
                $lastchar = $texts1[$txt1lngt - 1];
                if ($lastchar >= '0' && $lastchar <= '9')
                {
                    $texts1 =$texts1 . "*";
                }
            }
            $ans = $this->calculate($texts2);
            // calculate the values of string that was inside the bracket
            $text = $texts1 . strval($ans) . $texts3;
            //echo($text."<br>");

            // marge part1,value of bracket and part3
            // if the text contain more brackets then again pass it 
            //            to the function untill all brackets are reduced
            if ((strpos($text,"(") !== false ) || (strpos($text,")") !== false ))
            {
                if ((strpos($text,".") !== false ))
                {
                    $text = str_replace(".","·",$text);
                }
                $text = $this->firstBracketCheck($text);

            }
            return $text;
        } catch ( Exception $ex) {
            $this->error = true;
            return strval(0) . "";
        }
    }
    function calculate($text)
    {
        //echo($text."<br>");
        try
        {
            if (!empty($text)){
                if ($text[0] == '+')
                {
                    // if the first character is plus then remove it
                    $text = substr($text,1,strlen($text));
                    echo($text);
                }
                else if ($text[0] == 'k')
                {
                    // if the first character is minus then remove it
                    $text = "0" . $text;
                    //echo($text."<br>");
                    
                }
            }
            // separate the parts of before sign and after sign
            //            then calculate them.
            if ((strpos($text,"+") !== false ))
            {
                $texts1 = substr($text,0,strripos($text,"+"));
                $texts2 = substr($text,strripos($text,"+") + 1,strlen($text));
                $number1 = $this->calculate($texts1);
                $number2 = $this->calculate($texts2);
                return $number1 + $number2;
            }
            else if ((strpos($text,"k") !== false ))
            {
                //echo($text."<br>");
                $texts1 = substr($text,0,strripos($text,"k"));
                $texts2 = substr($text,strripos($text,"k") + 1,strlen($text));
                $number1 = $this->calculate($texts1);
                $number2 = $this->calculate($texts2);
                return $number1 - $number2;
            }
            else if ((strpos($text,"*") !== false ))
            {
                $texts1 = substr($text,0,strripos($text,"*"));
                $texts2 = substr($text,strripos($text,"*") + 1,strlen($text));
                $number1 = $this->calculate($texts1);
                $number2 = $this->calculate($texts2);
                return $number1 * $number2;
            }
            else if ((strpos($text,"/") !== false ))
            {
                // echo($text);
                $texts1 = substr($text,0,strripos($text,"/"));
                $texts2 = substr($text,strripos($text,"/") + 1,strlen($text));
                $number1 = $this->calculate($texts1);
                $number2 = $this->calculate($texts2);
                //echo(strlen($texts2));
                return $number1 / $number2;
            }
            else if ((strpos($text,"%") !== false ))
            {
                $texts1 = substr($text,0,strripos($text,"%"));
                $texts2 = substr($text,strripos($text,"%") + 1,strlen($text));
                $val = $this->calculate($texts1);
                $val = $val / 100;
                if (!empty($texts2))
                {
                    switch ($texts2[0]) {
                        case '√':
                            $texts2 = strval($val) . "*" . $texts2;
                            // if character after % is a root
                            break;
                        case '^':
                            $texts2 = strval($val) . $texts2;
                            // if character after % is a square
                            break;
                        default:
                            $this->error = true;
                            return 0;
                    }
                    $val = $this->calculate($texts2);
                }
                return $val;
            }
            else if ((strpos($text,"ln") !== false ))
            {
                $texts1 = substr($text,strripos($text,"n") + 1,strlen($text));
                $val = $this->calculate($texts1);
                $val = log($val);
                $format = number_format($val, 3);
                $val = floatval($format);
                return $val;
            }
            else if ((strpos($text,"log") !== false ))
            {
                $texts1 = substr($text,strripos($text,"g") + 1,strlen($text));
                $val = $this->calculate($texts1);
                $val = log10($val);
                $format = number_format($val, 3);
                $val = floatval($format);
                return $val;
            }
            else if ((strpos($text,"e") !== false ))
            {
                $texts1 = substr($text,strripos($text,"e") + 1,strlen($text));
                $val = $this->calculate($texts1);
                $val = exp($val);
                $format = number_format($val, 3);
                $val = floatval($format);
                return $val;
            }
            else if ((strpos($text,"sin") !== false ))
            {
                $texts1 = substr($text,strripos($text,"n") + 1,strlen($text));
                $val = $this->calculate($texts1);
                $val = deg2rad($val);
                $val = sin($val);
                $format = number_format($val, 3);
                $val = floatval($format);
                return $val;
            }
            else if ((strpos($text,"cos") !== false ))
            {
                $texts1 = substr($text,strripos($text,"s") + 1,strlen($text));
                $val = $this->calculate($texts1);
                $val = deg2rad($val);
                $val = cos($val);
                $format = number_format($val, 3);
                $val = floatval($format);
                return $val;
            }
            else if ((strpos($text,"tan") !== false ))
            {
                $texts1 = substr($text,strripos($text,"n") + 1,strlen($text));
                $val = $this->calculate($texts1);
                $val = deg2rad($val);
                $val = tan($val);
                $format = number_format($val, 3);
                $val = floatval($format);
                return $val;
            }
            else if ((strpos($text,"cot") !== false ))
            {
                $texts1 = substr($text,strripos($text,"t") + 1,strlen($text));
                $val = $this->calculate($texts1);
                $val = deg2rad($val);
                $val = tan($val);
                $format = number_format($val, 3);
                $val = floatval($format);
                $val = 1.0 / $val;
                $format = number_format($val, 3);
                $val = floatval($format);
                return $val;
            }
            else if ((strpos($text,"√") !== false ))
            {
                $texts1 = substr($text,strripos($text,"√") + 3,strlen($text));
                $texts2 = substr($text,0,strripos($text,"√"));
                if ($texts1[0] == '^')
                {
                    // if character after root is a square
                    $this->error = true;
                    return 0;
                }
                $val = $this->calculate($texts1);
                $val = sqrt($val);
                if (!empty($texts2))
                {
                    if (mb_substr($texts2, 0, 1) == '√')
                    {
                        // if character before root is a root
                        $texts2 =$texts2 . $val;
                    }
                    else 
                    {
                        // if character before root is a number or square
                        $texts2 =$texts2 . "*" . strval($val);
                    }
                    $val = $this->calculate($texts2);
                }
                return $val;
            }
            else if ((strpos($text,"^") !== false ))
            {
                if ((strpos($text,"^~") !== false ))
                {
                    $text = str_replace("^~","^-",$text);
                }
                $texts1 = substr($text,0,strripos($text,"^"));
                $texts2 = substr($text,strripos($text,"^") + 1,strlen($text));
                $val = $this->calculate($texts1);
                $power = $this->calculate($texts2);
                $val = pow($val,$power);
                return $val;
            }
            else 
            {
                // base case. replace the point and convert string to double
                if ((strpos($text,"·") !== false ))
                {
                    $text = str_replace("·",".",$text);
                }
                return floatval($text);
            }
        } catch ( Exception $ex) {
            $this->error = true;
            return 0;
        }
    }
}

?>