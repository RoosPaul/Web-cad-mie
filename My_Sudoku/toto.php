<?php

function toto($nbr) { 
	$res = 0;
		if ($nbr >= 1) {
			$res = toto($nbr - 1);
		}
	$res += $nbr * $nbr;
	return $res;
}

var_dump(toto(3));