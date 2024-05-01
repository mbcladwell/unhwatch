<?php

//for each name put the name nickname pair on one line
//James Jim, Jimmy, Jimbo ==>
//James Jim
//James Jimmy
//James Jimbo


$file_name = "nicknames.csv";
$out = "nicknamesmod.txt";
$d = file_get_contents($file_name);

$myfile = fopen($out, "a") or die("Unable to open file!");


if (($handle = fopen($file_name, "r")) !== false) {

    while (($data = fgetcsv($handle, 0, "\t")) !== false) {

        $data = fgetcsv($handle, 0, "\t");

        $nicks = explode(", ", $data[1] );
        $n = count($nicks);
        print_r($nicks);
        $i = 0;
        while ($i < $n){
        $txt = $data[0] .  "\t" . $nicks[$i] .  "\n";
        fwrite($myfile, $txt);
            
            $i++;
        }
        
    }

    // close file
    fclose($handle);
    fclose($myfile);
    
}




?>
