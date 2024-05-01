<?php


$file_name = "https://mobile.unh.edu/UNHMobile/directory/searchEmployees?search=robinson,%20brett";

//https://mobile.unh.edu/UNHMobile/directory/facultystaff.jsp
$url = $file_name;

//The data you want to send via POST
// $fields = [
//     '__VIEWSTATE '      => $state,
//     '__EVENTVALIDATION' => $valid,
//     'btnSubmit'         => 'Submit'
// ];

// //url-ify the data for the POST
// $fields_string = http_build_query($fields);

//open connection
$ch = curl_init();

//set the url, number of POST vars, POST data
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, true);
//curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);

//So that curl_exec returns the contents of the cURL; rather than echoing it
curl_setopt($ch,CURLOPT_RETURNTRANSFER, true); 

//execute post
$result = curl_exec($ch);

$start = strpos($result, "Dept</th><td>", 0) + 13;
$end = strpos($result, "</td></tr>", $start);
$dept = substr($result, $start, $end - $start);

$start2 = strpos($result, "Title</th><td>", 0) + 14;
$end2 = strpos($result, "</td></tr>", $start2);
$title = substr($result, $start2, $end2 - $start2);


echo $start;
echo $title;







?>
