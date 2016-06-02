<?php 
/*
    Plugin Name: Videos responsive
    Plugin URI: http://www.andres-dev.com
    Description: Hacer que los videos agregados de Youtube, Vimeo y de las demas plataformas sean responsive.
    Author: Andrés Vega
    Version: 1.0
    Creación: 02/06/2016
    Author URI: http://www.andres-dev.com
    */

/*
Buscamos dentro de la página todos los iframes que contengan Yotube o Vimeo
*/

if(!function_exists('video_content_filter')) {

	 function video_content_filter($content) {
	 
		 $pattern = '/<iframe.*?src=".*?(vimeo|youtu\.?be).*?".*?<\/iframe>/';
		 preg_match_all($pattern, $content, $matches);
		 
		 foreach ($matches[0] as $match) {
			 // iFrame encontrado, ahora lo envolvemos en un div con la clase creada en nuestro archivo CSS en esta misma capeta.
			 $wrappedframe = '<div class="video-container">' . $match . '</div>';
			 
			 // Intercambia el original con el video, ahora encerrado
			 $content = str_replace($match, $wrappedframe, $content);
		 }
		 return $content;
	 }

	 add_filter( 'the_content', 'video_content_filter' );
	 add_filter( 'widget_text', 'video_content_filter' );
}

 ?>