<?php



$file_name = "nicknames.csv";
$d = file_get_contents($file_name);



if (($handle = fopen($file_name, "r")) !== false) {

    // loop through each row. The table has 4 columns. I want col 0
       while (($data = fgetcsv($handle, 0, "\t")) !== false) {

    $data = fgetcsv($handle, 0, "\t");

    echo $data[0]. "\n";
        echo $data[1]  . "\n\n";
        
        }

    // close file
    fclose($handle);
}




?>
