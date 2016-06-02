<?php
/*
    Plugin Name: Paginación para las entradas
    Plugin URI: http://www.andres-dev.com
    Description: Generamos la paginación para nuestras entradas
    Author: Andrés Vega
    Version: 1.0
    Creación: 02/06/2016
    Author URI: http://www.andres-dev.com
    */


/*
Creamos la funcion para procesar la páginación
*/

function wp_corenavi() {
	global $wp_query, $wp_rewrite;
	$pages = " ";
	$max = $wp_query->max_num_pages;

		if (!$current = get_query_var('paged')) $current = 1;
		$a['base'] = str_replace(999999999, '%#%', get_pagenum_link(999999999));
		$a['total'] = $max;
		$a['current'] = $current;

	$total = 1; //1 – muestra el texto “Página N de N”, 0 – para no mostrar nada
	$a['mid_size'] = 5; //cuantos enlaces a mostrar a izquierda y derecha del actual
	$a['end_size'] = 1; //cuantos enlaces mostrar al comienzo y al fin
	$a['prev_text'] = '&laquo; Anterior'; //texto para el enlace “Página siguiente”
	$a['next_text'] = 'Siguiente &raquo;'; //texto para el enlace “Página anterior”

		if ($max > 1) echo '<div class="navigation">';

		if ($total == 1 && $max > 1) $pages = '<span class="pages">Página ' . $current . ' de ' . $max . '</span>'."\r\n";

		echo $pages . paginate_links($a);
		if ($max > 1) echo '</div>';
}

/*
Llamamos esta funcion donde deseamos mostrar nuestra paginación dentro de las etiquetas de php <?php ?>
*/

if (function_exists('wp_corenavi')) wp_corenavi();

?>