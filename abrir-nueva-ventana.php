<?php 
//Abrir en nueva ventana

function autoblank($text) {
	$return = str_replace('href=', 'target="_blank" href=', $text);
	return $return;
}

add_filter('the_content', 'autoblank');

?>