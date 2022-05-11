<?php

    try {
        
        //reading input from csv line by line
        $csvFile = file('dsf.csv');
        $data = [];
        foreach ($csvFile as $line) {
            $data[] = str_getcsv($line);
        }

        //defining path to output csv
        $filename= "sqls.csv";
        $csv_output = "";

        #looping through input data and generating sqls and copying them to output variable
        for ($x = 1; $x < count($data); $x++) {
          echo "UPDATE platform SET name='".$data[$x][1]."' WHERE rowid=".$data[$x][0].";";
          $csv_output .=  "UPDATE platform SET name='".$data[$x][1]."' WHERE rowid=".$data[$x][0].";";
        }

        #writing csv output to the file
        if (is_writable(dirname($filename))) {
            if (!$handle = fopen($filename, 'w')) {
                echo "Cannot open file (".$filename.")";
                exit;
            }
            if (fwrite($handle, $csv_output) === FALSE) {
                echo "Cannot write to file (".$filename.")";
                exit;
            }       
            fclose($handle);
        } else {
            echo "The file ".$filename." is not writable! <br/>";
        }

        
        
    }
    catch (PDOException $e) {
        $dbh->rollBack();
        echo "Error!" . $e->getMessage() . "<br/>";
        fclose($handle);
        die();
    }

?>
