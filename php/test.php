<?php



$file_name = "../data/d4UNHmod.txt";
//$d4UNH = file_get_contents($file_name);


if (($handle = fopen($file_name, "r")) !== false) {

    // loop through each row. The table has 4 columns. I want col 0
       while (($data = fgetcsv($handle, 0, "\t")) !== false) {

           //echo "-----------------";
           //echo $data[0] . "\n";

           $fl = getFirstLast($data[0]);
           $fl2 = appendNicknames($fl);
           print_r($fl2);
           // $url2 = $url . urlencode( $data[0]);
           //print_r($fl) . "\n";
           //echo $fl[0] . " " . $fl[1] . "\n";
           // echo $url2 . "\n\n";
           // $ch = curl_init();
           // //set the url, number of POST vars, POST data
           // curl_setopt($ch,CURLOPT_URL, $url2);
           // curl_setopt($ch,CURLOPT_POST, true);
           // //curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

           // //So that curl_exec returns the contents of the cURL; rather than echoing it
           // curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 
           
           // //execute post
           // $result = curl_exec($ch);
           // if(strpos($result, "Dept</th><td>", 0) !== false){
           //     $start = strpos($result, "Dept</th><td>", 0) + 13;
           //     $end = strpos($result, "</td></tr>", $start);
           //     $dept = substr($result, $start, $end - $start);
               
           //     $start2 = strpos($result, "Title</th><td>", 0) + 14;
           //     $end2 = strpos($result, "</td></tr>", $start2);
           //     $title = substr($result, $start2, $end2 - $start2);
               
               
           //     echo $dept . "\n";
           //     echo $title . "\n\n";
           // } else {echo "not found";}
           
        }

    // close file
    fclose($handle);
}


//function getDeptTitle($first, $last){
//   $url = "https://mobile.unh.edu/UNHMobile/directory/searchEmployees?search=";


    
//}

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
    $results[0] = $first;
    $results[1] = $last;
    return $results;
}

function appendNicknames($a){
    $nicknames = "../data/nicknamesmod.txt";
    //$a is the first, last array
    if (($handle = fopen($nicknames, "r")) !== false) {
        $results = [];
        $counter = 0;
        // loop through each row. col 0 is regular name
        while (($data = fgetcsv($handle, 0, "\t")) !== false) {
            if ($data[0] === $a[0]){$results[$counter] = $data[1];
                $counter++;}           
        }
        fclose($handle);     
        return array_merge($a, $results);
    }    
}



?>
