<?php
//adds the department to the UNH data

$file_name = "../data/d4UNH.txt";
//$d4UNH = file_get_contents($file_name);
$out =  fopen("../data/d5UNH.txt", "a") ;

if (($handle = fopen($file_name, "r")) !== false) {
    // loop through each row. The table has 4 columns. I want col 0
       while (($data = fgetcsv($handle, 0, "\t")) !== false) {
           $fl = getFirstLast($data[0]);
           $fl2 = appendNicknames($fl);
           $num_firsts = count($fl2);
           $flag = false; //true when department found
           $first_counter = 1;
           while ( ($first_counter < $num_firsts) and (!$flag)){
               $dt = getDeptTitle($fl2[0], $fl2[$first_counter]);
               if (strlen($dt[0]) < 100){$flag = true;}//have dept and title
               if (($first_counter === $num_firsts - 1) and !$flag){$dt[0] = "fail";}        
               $first_counter++;
           }
           print_r($dt);
           fwrite( $out, $data[0] . "\t" . $data[1] . "\t" . $data[2] . "\t" . $data[3] . "\t" . $dt[0] . "\n");
       }
       // close file
       fclose($handle);
       fclose($out);
}

function getFirstLast($s){
    //comes in as maybe Last, First M.
    $break1 = strpos($s, ",");
    $secondSpace = strpos($s, " ", $break1 + 2);
    $last = substr($s, 0, $break1); //break1 position is NOT included
    $length = $secondSpace - $break1 - 2;
    if ($length > 0) {$first = substr($s, $break1 + 2, $length);}
                          else
                          {$first = substr($s, $break1 + 2);} //break1 + 2 is included
    $results = [];
    $results[0] = $last;
    $results[1] = $first;
    return $results;
}

function appendNicknames($a){
    $nicknames = "../data/nicknamesmod.txt";
    //$a is the last, firt array
    if (($handle = fopen($nicknames, "r")) !== false) {
        $results = [];
        $counter = 0;
        // loop through each row. col 0 is regular name
        while (($data = fgetcsv($handle, 0, "\t")) !== false) {           
            if ($data[0] === $a[1]){$results[$counter] = $data[1];
                $counter++;}           
        }
        fclose($handle);
        return array_merge($a, $results);
    }    
}


function getDeptTitle($last, $first){
    $urlpre = "https://mobile.unh.edu/UNHMobile/directory/searchEmployees?search=";
    $urlsuffix = urlencode($last . " " . $first);
    $urlfinal = $urlpre . $urlsuffix;
    $ch = curl_init();

    //set the url, number of POST vars, POST data
    curl_setopt($ch,CURLOPT_URL, $urlfinal);
    curl_setopt($ch,CURLOPT_POST, true);
    curl_setopt($ch,CURLOPT_VERBOSE, false);
    // curl_setopt($ch,CURLOPT_STDERR, );
    //curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);
    
    //So that curl_exec returns the contents of the cURL; rather than echoing it
    curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
    
    //execute post
    //$result = curl_exec($ch);
    if( ! $result = curl_exec($ch)){
        //   throw new Exception(curl_error($ch));
    }
    $a = [];
    $start = strpos($result, "Dept</th><td>", 0) + 13;
    $end = strpos($result, "</td></tr>", $start);
    $dept = substr($result, $start, $end - $start);
    
    $start2 = strpos($result, "Title</th><td>", 0) + 14;
    $end2 = strpos($result, "</td></tr>", $start2);
    $title = substr($result, $start2, $end2 - $start2);
    $a[0] = $dept;
    $a[1] = $title;
    return  $a;
    
}



?>
