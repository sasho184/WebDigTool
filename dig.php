<?php

function dig($domain, $type)
{

    // if contains space, its invalid
    if (preg_match("*[[:space:]]*", $domain)) {
        echo "invalid domain!";
        return 0;
    }

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

            if (strstr($output, "\n")) {
                $arr = explode("\n", $output);
                for ($i = 0; $i <= 3; $i++) {
                    if (!empty($arr[$i])) {
                        echo $arr[$i];
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