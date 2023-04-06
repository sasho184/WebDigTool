<?php

function dig($domain, $type)
{

    // if contains space, its invalid
    //if (preg_match("*[[:space:]]*", $domain)) {
    //    echo "invalid domain!";
    //    return 0;
    //}

    if (isset($domain)) {

        $resolver = "8.8.8.8";

        $command = 'dig ' . $domain . " " . $type . " " . ' +short @' . $resolver;

        $escaped_command = escapeshellcmd($command);

        $output = shell_exec($escaped_command);

        echo "<div class='answer' id='" . $type . "'>";
        echo "<span>";

        if (preg_match("/[a-z]/i", $output) && $type == "A") {
            $arr = explode("\n", $output);
            echo "CNAME: ";
            if (!empty($output)) {

                for ($i = 0; $i <= 3; $i++) {
                    if (!empty($arr[$i])) {
                        echo $arr[$i];
                        echo "<br>";
                    }
                }
            } else {
                $output = "No results.";
            }

        } else {
            if (empty($output)) {
                $output = "No results.";
            }
            echo $type . ": <br>";


            //If it has multiple records of newline character we loop
            if (strstr($output, "\n")) {
                $arr = explode("\n", $output);
                for ($i = 0; $i <= 3; $i++) {
                    if (!empty($arr[$i])) {
                        echo $arr[$i];

                        // If type is MX record we cut the priority numbers and execute dig on just the MX.
                        if($type == "MX"){
                            echo "<br>";
                            $mx_command = "echo \"" . $arr[$i] . "\" | cut -f2 -d\" \" | xargs dig +short @" . $resolver;
 

                            //$escaped_mx_command = escapeshellcmd($mx_command);
                            $mx_output = shell_exec($mx_command);

//If MX record has multiple A records, we loop
if (!empty($mx_output) && strstr($mx_output, "\n")) {
                $marr = explode("\n", $mx_output);
                for ($j = 0; $j <= 3; $j++) {
                    if (!empty($marr[$j])) {
                            echo $marr[$j];

                            if($i < 3 && $j < 3){           
                                echo "<br>";
                            }

                    }
                }
                //If it doesn't have multiple A records, we don't loop
            } else {
                            echo $mx_output;
                            }      
                        }
                        echo "<br>";
                    }
                }
            } else {
                echo $output;
            }
        }

        echo "</span>";
        echo "</div>";
    }

}

function ischecked($recType, $value)
{
    foreach ($recType as $type) {
        if ($type == $value) {
            echo "checked='checked'";
        }
    }
}

?>
