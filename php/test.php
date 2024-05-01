<?php



$file_name = "d4UNHmod.txt";
$d4UNH = file_get_contents($file_name);


$url = "https://mobile.unh.edu/UNHMobile/directory/searchEmployees?search=";

if (($handle = fopen($file_name, "r")) !== false) {

    // loop through each row. The table has 4 columns. I want col 0
       while (($data = fgetcsv($handle, 0, "\t")) !== false) {

    $data = fgetcsv($handle, 0, "\t");
    
        $url2 = $url . urlencode( $data[0]);
        echo $data[0] . "\n";
        echo $url2 . "\n\n";
        $ch = curl_init();
        //set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL, $url2);
        curl_setopt($ch,CURLOPT_POST, true);
        //curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

//So that curl_exec returns the contents of the cURL; rather than echoing it
        curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

        //execute post
        $result = curl_exec($ch);
        if(strpos($result, "Dept</th><td>", 0) !== false){
        $start = strpos($result, "Dept</th><td>", 0) + 13;
        $end = strpos($result, "</td></tr>", $start);
        $dept = substr($result, $start, $end - $start);
        
        $start2 = strpos($result, "Title</th><td>", 0) + 14;
        $end2 = strpos($result, "</td></tr>", $start2);
        $title = substr($result, $start2, $end2 - $start2);


        echo $dept . "\n";
        echo $title . "\n\n";
        } else {echo "not found";}
        
        }

    // close file
    fclose($handle);
}




?>
