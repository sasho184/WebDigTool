<?php

function dig($domain, $type)
{

	if (isset($domain)) {

	 #If contains space, its invalid
		if (preg_match("*[[:space:]]*", $domain)) {
		echo "invalid domain!";
		return 0;
    }


	$com_type = constant("DNS_" . $type);

	$output = dns_get_record($domain, $com_type);

	echo "<div class='answer' id='" . $type . "'>";
        echo "<span>" . $type . ": </br>";

	foreach($output as $ar){

		switch($com_type){
		
		case DNS_A:
			print_r($ar['ip']);
			break;
		case DNS_AAAA:
			print_r($ar['ipv6']);
			break;
		case DNS_CNAME:
			print_r($ar['target']);
			find($ar['target']);
			break;
		case DNS_MX:
			print_r($ar['target']);
			find($ar['target']);
			break;
		case DNS_NS:
			print_r($ar['target']);
			break;
		case DNS_TXT:
			print_r("\"" . $ar['txt'] . "\"");
			break;
		default:
			print_r("DNS record not compatible");
		}
		echo "</br>";
	}
        echo "</span></div>";
    }

}

function find($domain){
	$output = dns_get_record($domain, DNS_A);

	foreach($output as $ar){
		echo "</br>";
		print_r($ar['ip']);
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
