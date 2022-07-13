<?php

class Priroty
{
    public $process;
    public $perform = array();
    public $index;
    public function ArrivalSort(&$arr)
    {
        $n = count($arr);
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                if (($arr[$j]->priroty == $arr[$j + 1]->priroty) && ($arr[$j]->at > $arr[$j + 1]->at)) {
                    // swap arr[j+1] and arr[j]
                    $temp = $arr[$j];
                    $arr[$j] = $arr[$j + 1];
                    $arr[$j + 1] = $temp;
                }
            }
        }
    }
    public function AscendingSort(&$arr)
    {
        $n = count($arr);
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                if ($arr[$j]->priroty > $arr[$j + 1]->priroty) {
                    // swap arr[j+1] and arr[j]
                    $temp = $arr[$j];
                    $arr[$j] = $arr[$j + 1];
                    $arr[$j + 1] = $temp;
                }
            }
        }
        $this->ArrivalSort($this->process);
    }
    public function DescendingSort(&$arr)
    {
        $n = count($arr);
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                if ($arr[$j]->priroty < $arr[$j + 1]->priroty) {
                    // swap arr[j+1] and arr[j]
                    $temp = $arr[$j];
                    $arr[$j] = $arr[$j + 1];
                    $arr[$j + 1] = $temp;
                }
            }
        }
        $this->ArrivalSort($this->process);
    }
    public function FinalSort(&$arr)
    {
        $n = count($arr);
        for ($i = 0; $i < $n - 1; $i++) {
            for ($j = 0; $j < $n - $i - 1; $j++) {
                if ($arr[$j]->id > $arr[$j + 1]->id) {
                    // swap arr[j+1] and arr[j]
                    $temp = $arr[$j];
                    $arr[$j] = $arr[$j + 1];
                    $arr[$j + 1] = $temp;
                }
            }
        }
    }
    public function perform($p)
    {
        $processing = array();
        $finished = array();
        $time = array();
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
        $PT = array(
            3, 2, 1, 5, 7, 6, 9, 5, 7, 5
        );
        $this->process = array_fill(0, count($name), null);
        for ($i = 0; $i < count($name); $i++) {
            $this->process[$i] = new Process();
            $this->process[$i]->name = $name[$i];
            $this->process[$i]->at = $AT[$i];
            $this->process[$i]->st = $ST[$i];
            $this->process[$i]->remaining = $ST[$i];
            $this->process[$i]->priroty = $PT[$i];
            $this->process[$i]->processing = 0;
            $this->process[$i]->id = $i;
        }

        if ($p == 1) {
            $this->AscendingSort($this->process);
        } else {
            $this->DescendingSort($this->process);
        }
        for ($i = 0; $i < count($name); $i++) {
            array_push($this->perform, $this->process[$i]);
        }

        for ($i = 0; $i < 1000; $i++) {
            for ($j = 0; $j < count($name); $j++) {
                if ($this->process[$j]->processing == 0 && $this->process[$j]->at <= $i) {
                    array_push($processing, $this->process[$j]);
                    $this->process[$j]->processing = 1;
                }
            }

            for ($j = 0; $j < count($this->perform); $j++) {
                if ($this->perform[$j]->remaining <= 0) {
                    unset($this->perform[$j]);
                }
                $this->perform = array_values($this->perform);
            }

            
            if (isset($this->perform[0])) {
                if (in_array($this->perform[0], $processing)) {
                    $this->perform[0]->ct = (int)$i + $this->perform[0]->remaining;
                    $this->perform[0]->remaining = 0;
                    array_push($finished, $this->perform[0]);
                    array_push($time, $i);
                    $i = (int)($this->perform[0]->ct - 1);
                    array_push($time, $i + 1);
                } else {
                    $this->index = -1;
                    for ($j = 0; $j < count($this->perform); $j++) {
                        if (in_array($this->perform[$j], $processing)) {
                            $this->index = $j;
                            break;
                        }
                    }
                    if ($this->index != -1) {
                        $this->perform[$this->index]->remaining--;
                        $this->perform[$this->index]->ct = $i + 1;
                        array_push($finished, $this->perform[$this->index]);
                        array_push($time, $i);
                        array_push($time, $i + 1);
                    }
                }
            }
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

        echo("<table>");
        echo("<tr>");
        for ($i = 0; $i < count($finished); $i++) {
            echo("<th colspan='2'>". $finished[$i]->name . "</th>");
        }
        echo("</tr>");
        echo("<tr>");
        for ($i = 0; $i < count($time); $i = $i + 2) {
            echo("<td>".$time[$i] . "</td><td>" . $time[$i + 1]. "</td>");
        }
        echo("</tr>");

        echo("</table>");


        $this->FinalSort($this->process);
        echo "<br>","<br>";
        echo("<style>
        table, th, td {
          border:1px solid black;
        }
        </style>");

        echo("<table>");
        echo("<tr>");
        echo ("<th>Process</th><th>AT</th><th>ST</th><th>PT</th><th>CT</th><th>TAT</th><th>WT</th>");
        echo("</tr>");
        for ($i = 0; $i < count($name); $i++) {
            echo("<tr>");
            $this->process[$i]->tat = $this->process[$i]->ct - $this->process[$i]->at;
            $this->process[$i]->wt = $this->process[$i]->tat - $this->process[$i]->st;
            echo("<td>".$this->process[$i]->name . "</td><td>" . strval((int)$this->process[$i]->at) . "</td><td>" . strval((int)$this->process[$i]->st) . "</td><td>" . strval((int)$this->process[$i]->priroty) . "</td><td>" . strval((int)$this->process[$i]->ct) . "</td>");
            echo("<td>".strval((int)$this->process[$i]->tat) . "</td>");
            echo("<td>".(int)$this->process[$i]->wt."</td>");
            echo("</tr>");
        }
        $Atat = 0;
        $Awt = 0;
        for ($i = 0; $i < count($name); $i++) {
            $Atat = $this->process[$i]->tat + $Atat;
            $Awt = $this->process[$i]->wt + $Awt;
        }
        echo("<tr>");
        echo ("<td></td><td></td><td></td><td></td><td>Total</td><td>".$Atat."</td><td>".$Awt."</td>");
        echo("</tr>");
        echo("</table>");

        echo "<br>Average TAT = " . strval((int)$Atat) . "/" . strval(count($name)) . " = " . round($Atat / count($name), 2) . " ms","<br>";
        echo "Average WT = " . strval((int)$Awt) . "/" . strval(count($name)) . " = " . round($Awt / count($name), 2) . " ms","<br>";
    }
}
