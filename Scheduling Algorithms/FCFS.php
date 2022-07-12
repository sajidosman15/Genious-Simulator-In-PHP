<?php
include "Process.php";
class FCFS
{
    public $process;
    function AscendingSort(&$arr)
    {
        $n = count($arr);
        for ($i = 0; $i < $n - 1; $i++)
        {
            for ($j = 0; $j < $n - $i - 1; $j++)
            {
                if ($arr[$j]->at > $arr[$j + 1]->at)
                {
                    // swap arr[j+1] and arr[j] 
                    $temp = $arr[$j];
                    $arr[$j] = $arr[$j + 1];
                    $arr[$j + 1] = $temp;
                }
            }
        }
    }

    function perform()
    {
        $processing = array();
        $finished = array();
        // *
        //         * Write Process Here*
        $name = array(
            "A", "B", "C", "D", "E", "F", "G", "H", "I", "J"
        );
        $AT = array(
            0, 2, 4, 6, 8, 0, 2, 4, 6, 8
        );
        $ST = array(
            3, 6, 4, 5, 2, 3, 6, 4, 5, 2
        );
        $this->process = array_fill(0,count($name),NULL);
        for ($i = 0; $i < count($name); $i++)
        {
            $this->process[$i] = new Process();
            $this->process[$i]->name = $name[$i];
            $this->process[$i]->at = $AT[$i];
            $this->process[$i]->st = $ST[$i];
            $this->process[$i]->processing = 0;
        }
        $this->AscendingSort($this->process);
        for ($i = 0; $i < 100; $i++)
        {
            for ($j = 0; $j < count($name); $j++)
            {
                if ($this->process[$j]->processing == 0 && $this->process[$j]->at <= $i)
                {
                    array_push($processing,$this->process[$j]);
                    $this->process[$j]->processing = 1;
                }
            }
            if (count($processing) > 0)
            {
                $p = array_shift($processing);
                $p->ct = $i + $p->st;
                $i = (int)$p->ct - 1;
                array_push($finished,$p);
            }
        }

        echo("<table>");
        echo("<tr>");
        for ($i = 0; $i < count($name); $i++)
        {
            echo("<th colspan='2'>". $finished[$i]->name . "</th>");
        }
        echo("</tr>");
        echo("<tr>");
        for ($i = 0; $i < count($name); $i++)
        {
            echo("<td>".strval((int)($finished[$i]->ct - $finished[$i]->st)) . "</td><td>" . strval((int)$finished[$i]->ct) . "</td>");
        }
        echo("</tr>");

        echo("</table>");


        echo "<br>","<br>";
        echo("<style>
        table, th, td {
          border:1px solid black;
        }
        </style>");

        echo("<table>");
        echo("<tr>");
        echo ("<th>Process</th><th>AT</th><th>ST</th><th>CT</th><th>TAT</th><th>WT</th>");
        echo("</tr>");
        for ($i = 0; $i < count($name); $i++)
        {
            $finished[$i]->tat = $finished[$i]->ct - $finished[$i]->at;
            $finished[$i]->wt = $finished[$i]->tat - $finished[$i]->st;

            echo("<tr>");
            echo("<td>".$finished[$i]->name . "</td><td>" . strval((int)$finished[$i]->at) . "</td><td>" . strval((int)$finished[$i]->st) . "</td><td>" . strval((int)$finished[$i]->ct) . "</td>");
            echo ("<td>".strval((int)$finished[$i]->tat) . "</td>");
            echo("<td>".(int)$finished[$i]->wt."</td>");
            echo("</tr>");
        }
        
        $Atat = 0;
        $Awt = 0;
        for ($i = 0; $i < count($name); $i++)
        {
            $Atat = $finished[$i]->tat + $Atat;
            $Awt = $finished[$i]->wt + $Awt;
        }
        echo("<tr>");
        echo ("<td></td><td></td><td></td><td>Total</td><td>".$Atat."</td><td>".$Awt."</td>");
        echo("</tr>");
        echo("</table>");
        echo "<br>Average TAT = " . strval((int)$Atat) . "/" . strval(count($name)) . " = " . round($Atat / count($name),2) . " ms","<br>";
        echo "Average WT = " . strval((int)$Awt) . "/" . strval(count($name)) . " = " . round($Awt / count($name),2) . " ms","<br>";
    }
    
}

?>