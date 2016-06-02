<?php 
	/*
    Plugin Name: Contador de visitas
    Plugin URI: http://www.andres-dev.com
    Description: Contador de visitas para cada articulo de Wordpress en cual lo muestra en el frontend y backend.
    Author: Andrés Vega
    Version: 1.0
    Creación: 02/06/2016
    Author URI: http://www.andres-dev.com
    */


/*
Cuenta el numero de visitas que hemos tenido en nuestro articulo
*/

function getPostViews($postID){
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);

		if($count==''){
			delete_post_meta($postID, $count_key);
			add_post_meta($postID, $count_key, '0');
			return "0 Visitas";
		}

	return $count.' Visitas';
}

function setPostViews($postID) {
	$count_key = 'post_views_count';
	$count = get_post_meta($postID, $count_key, true);

		if($count==''){
		$count = 0;
		delete_post_meta($postID, $count_key);
		add_post_meta($postID, $count_key, '0');

			}else{
			$count++;
			update_post_meta($postID, $count_key, $count);
			}
}

/*
Este código solo cuenta dentro de cada articulo las visitas y debe de agregare dentro del loop del archivo single.php dentro de etiquetas <?php  ?>
*/

setPostViews(get_the_ID()); 


/*
Si deseamos mostrar el el numero de visitas dentro de nuestro articulo agregamos el siguiente codigo tambien en el sigle.php
*/

echo getPostViews(get_the_ID());


/*
Ahora mostramos la estadistica para cada articulo dentro de nuestra administracion, generando una nueva columna donde se muestran el numero de visitas para cada articulo.
*/

function posts_column_views($defaults){
	$defaults['post_views'] = __('Visitas');
	return $defaults;
}
function posts_custom_column_views($column_name, $id){
	if($column_name === 'post_views'){
	echo getPostViews(get_the_ID());
	}
}

add_filter('manage_posts_columns', 'posts_column_views');
add_action('manage_posts_custom_column', 'posts_custom_column_views',5,2);


?>