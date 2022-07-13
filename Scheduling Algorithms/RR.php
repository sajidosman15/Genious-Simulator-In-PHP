<?php

class RR
{
    public $process;
    // LinkedList<Process> processing = new LinkedList();
    public $queue = array();
    public $finished = array();
    public $time = array();
    public $qtime = array();
    public $qtime2 = array();
    public function perform()
    {
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
        // QT value is 1
        $this->process = array_fill(0, count($name), null);
        for ($i = 0; $i < count($name); $i++) {
            $this->process[$i] = new Process();
            $this->process[$i]->name = $name[$i];
            $this->process[$i]->at = $AT[$i];
            $this->process[$i]->st = $ST[$i];
            $this->process[$i]->remaining = $ST[$i];
            $this->process[$i]->processing = 0;
        }

        for ($i = 0; $i < 1000; $i++) {
            $performed = new Process();
            if (count($this->queue)>0) {
                $performed = array_shift($this->queue);
                $performed->executed = 1;
                $performed->remaining--;
                array_push($this->time, $i - 1);
                array_push($this->finished, $performed);
            }
            for ($j = 0; $j < count($name); $j++) {
                if ($this->process[$j]->processing == 0 && $this->process[$j]->at <= $i) {
                    array_push($this->queue, $this->process[$j]);
                    $this->process[$j]->processing = 1;
                }
            }
            if ($performed->executed == 1) {
                if ($performed->remaining != 0) {
                    array_push($this->queue, $performed);
                } else {
                    for ($j = 0; $j < count($name); $j++) {
                        if ((strcmp($this->process[$j]->name, $performed->name)==0)) {
                            $this->process[$j]->ct = $i;
                            break;
                        }
                    }
                }
            }
        }


        echo("<table>");
        echo("<tr>");
        for ($i = 0; $i < count($this->finished); $i++) {
            echo("<th colspan='2'>". $this->finished[$i]->name . "</th>");
        }
        echo("</tr>");
        echo("<tr>");
        for ($i = 0; $i < count($this->finished); $i++) {
            echo("<td>".($this->time[$i]) . "</td><td>" . strval(($this->time[$i] + 1)) . "</td>");
        }
        echo("</tr>");

        echo("</table>");


        echo "<br><br>Queue<br>","<br>";
        for ($i = 0; $i < count($this->finished); $i++) {
            array_push($this->qtime, (int)$this->finished[$i]->st);
            $this->finished[$i]->st--;
            array_push($this->qtime2, (int)$this->finished[$i]->st);
        }

        echo("<table>");
        echo("<tr>");
        for ($i = 0; $i < count($this->finished); $i++) {
            echo("<td>".$this->qtime2[$i]."</td>");
        }
        echo("</tr>");
        echo("<tr>");
        for ($i = 0; $i < count($this->finished); $i++) {
            echo("<th>". $this->finished[$i]->name . "</th>");
        }
        echo("</tr>");
        echo("<tr>");
        for ($i = 0; $i < count($this->finished); $i++) {
            echo("<td>".$this->qtime[$i]."</td>");
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
        echo("<th>Process</th><th>AT</th><th>ST</th><th>CT</th><th>TAT</th><th>WT</th>");
        echo("</tr>");
        for ($i = 0; $i < count($name); $i++) {
            echo("<tr>");
            $this->process[$i]->tat = $this->process[$i]->ct - $this->process[$i]->at;
            $this->process[$i]->wt = $this->process[$i]->tat - $ST[$i];
            echo("<td>".$this->process[$i]->name . "</td><td>" . strval((int)$this->process[$i]->at) . "</td><td>" . strval((int)$ST[$i]) . "</td><td>" . strval((int)$this->process[$i]->ct) . "</td>");
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
        echo("<td></td><td></td><td></td><td>Total</td><td>".$Atat."</td><td>".$Awt."</td>");
        echo("</tr>");
        echo("</table>");
        echo "<br>Average TAT = " . strval((int)$Atat) . "/" . strval(count($name)) . " = " . round($Atat / count($name), 2) . " ms","<br>";
        echo "Average WT = " . strval((int)$Awt) . "/" . strval(count($name)) . " = " . round($Awt / count($name), 2) . " ms","<br>";
    }
}
