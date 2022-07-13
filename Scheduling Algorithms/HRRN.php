<?php

class HRRN
{
    public $process;
    public function perform()
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

        $this->process = array_fill(0, count($name), null);
        for ($i = 0; $i < count($name); $i++) {
            $this->process[$i] = new Process();
            $this->process[$i]->name = $name[$i];
            $this->process[$i]->at = $AT[$i];
            $this->process[$i]->st = $ST[$i];
            $this->process[$i]->processing = 0;
        }
        for ($i = 0; $i < 1000; $i++) {
            for ($j = 0; $j < count($name); $j++) {
                if ($this->process[$j]->processing == 0 && $this->process[$j]->at <= $i) {
                    array_push($processing, $this->process[$j]);
                    $this->process[$j]->processing = 1;
                }
            }
            if (count($processing) > 1) {
                echo("Queue List at Time ".$i);
                echo("<table>");
                for ($j = 0; $j < count($processing); $j++) {
                    echo("<tr>");
                    $processing[$j]->rrx = (($i - $processing[$j]->at) + $processing[$j]->st) / $processing[$j]->st;
                    echo("<td>".strval($i) . "</td><td>" . $processing[$j]->name . "</td><td>" . round($processing[$j]->rrx, 3)."</td>");
                    echo("</tr>");
                }
                echo("</table>");
                echo("<br>");

                $p = $processing[0];
                for ($j = 1; $j < count($processing); $j++) {
                    if ($p->rrx < $processing[$j]->rrx) {
                        $p = $processing[$j];
                    }
                }

                $key=0;
                for ($l=0;$l<count($processing);$l++) {
                    if (strcmp($processing[$l]->name, $p->name)==0) {
                        $key=$l;
                        break;
                    }
                }

                unset($processing[$key]);
                $processing = array_values($processing);
                



                $p->ct = $i + $p->st;
                $i = (int)$p->ct - 1;
                array_push($finished, $p);
            } elseif (count($processing) == 1) {
                $p = array_shift($processing);
                $p->ct = $i + $p->st;
                $i = (int)$p->ct - 1;
                array_push($finished, $p);
            }
        }

        echo("<table>");
        echo("<tr>");
        for ($i = 0; $i < count($name); $i++) {
            echo("<th colspan='2'>". $finished[$i]->name . "</th>");
        }
        echo("</tr>");
        echo("<tr>");

        for ($i = 0; $i < count($name); $i++) {
            echo("<td>".strval((int)($finished[$i]->ct - $finished[$i]->st)) . "</td><td>" . strval((int)$finished[$i]->ct) . "</td>");
        }
        echo("</tr>");

        echo("</table>");


        for ($i = 0; $i < count($name); $i++) {
            $finished[$i]->tat = $finished[$i]->ct - $finished[$i]->at;
            $finished[$i]->wt = $finished[$i]->tat - $finished[$i]->st;
        }
        for ($i = 0; $i < count($name); $i++) {
            for ($j = 0; $j < count($finished); $j++) {
                if ((strcmp($this->process[$i]->name, $finished[$j]->name)==0)) {
                    $this->process[$i]->ct = $finished[$j]->ct;
                    $this->process[$i]->tat = $this->process[$i]->ct - $this->process[$i]->at;
                    $this->process[$i]->wt = $this->process[$i]->tat - $this->process[$i]->st;
                    break;
                }
            }
        }
        echo "<br>","<br>";
        echo("<style>
        table, th, td {
          border:1px solid black;
        }
        </style>");

        echo("<table>");
        echo("<tr>");
        echo("<th>Process</th><th>AT</th><th>ST</th><th>CT</th><th>TAT</th><th>WT</th>");
        echo("</tr>");
        for ($i = 0; $i < count($name); $i++) {
            echo("<tr>");
            echo("<td>".$this->process[$i]->name . "</td><td>" . strval((int)$this->process[$i]->at) . "</td><td>" . strval((int)$this->process[$i]->st) . "</td><td>" . strval((int)$this->process[$i]->ct) . "</td>");
            echo("<td>".strval((int)$this->process[$i]->tat) . "</td>");
            echo("<td>".(int)$this->process[$i]->wt."</td>");
            echo("</tr>");
        }
        $Atat = 0;
        $Awt = 0;
        for ($i = 0; $i < count($name); $i++) {
            $Atat = $finished[$i]->tat + $Atat;
            $Awt = $finished[$i]->wt + $Awt;
        }
        echo("<tr>");
        echo("<td></td><td></td><td></td><td>Total</td><td>".$Atat."</td><td>".$Awt."</td>");
        echo("</tr>");
        echo("</table>");
        echo "<br>Average TAT = " . strval((int)$Atat) . "/" . strval(count($name)) . " = " . round($Atat / count($name), 2) . " ms","<br>";
        echo "Average WT = " . strval((int)$Awt) . "/" . strval(count($name)) . " = " . round($Awt / count($name), 2) . " ms","<br>";
    }
}
