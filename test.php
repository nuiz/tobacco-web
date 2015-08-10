<?php

$ip = $_SERVER['REMOTE_ADDR'];
$regex = <<<REGEX
/^((172)|(192)|(203\.209\.122\.219))/
REGEX;

if(preg_match($regex, $ip)){
	echo "local network";
}
else {
	echo "ip access: ". $ip;

	$regex = <<<REGEX
	/^((.*))/
REGEX;

}