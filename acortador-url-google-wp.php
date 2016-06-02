<?php 
    /*
    Plugin Name: Acortador Url Googl
    Plugin URI: http://www.andres-dev.com
    Description: Acortador de url con la API de Google (https://goo.gl/), antes de implemntarlo se debe de crear una llave desde la API de Google
    Author: Andrés Vega
    Version: 1.0
    Creación: 02/06/2016
    Author URI: http://www.andres-dev.com
    */


/*
Se genera el codigo cada ves que se publique un post 
*/

function save_short_url() {
   global $wpdb, $post;
        if (!$post_id) $post_id = $_POST['post_ID'];
        if (!$post_id) return $post;

        $keyShortener='XXXXXX'; //Agregar KEY generado desde https://console.developers.google.com/
        $urlShare=get_permalink($post_id );

        $result = wp_remote_post(
            'https://www.googleapis.com/urlshortener/v1/url?key='.$keyShortener,
            array(
                'body' => json_encode(array('longUrl' => esc_url_raw($urlShare))),
                'headers' => array( 'Content-Type' => 'application/json')
            )
        );

        if(!is_wp_error($result)){
            $result = json_decode($result['body']);
            $shortlink = $result->id;
        }else{
            $shortlink=$urlShare;
        }

        update_post_meta($post_id, 'short_url', $shortlink);
}

add_action('publish_post', 'save_short_url');
add_action('publish_portfolio', 'save_short_url');


/*
Añadimos una columna en el listado de entradas o custom post type 
*/

function googl_post_columns($columns) {
    $columns['shortlink'] = 'Shortlink';
    return $columns;
}

function googl_custom_columns($column) {
    global $post;
    if ('shortlink' == $column)
    {
        $shorturl = get_post_meta($post->ID, 'short_url', true);
        $shorturl_caption = str_replace('http://', '', $shorturl);
        $shorturl_info = str_replace('goo.gl/', 'goo.gl/info/', $shorturl);
        echo "<a href='{$shorturl}'>{$shorturl_caption}</a> (<a href='{$shorturl_info}' target='_blank'>info</a>)";
    }
}

add_action('manage_posts_custom_column', 'googl_custom_columns');
add_filter('manage_edit-post_columns', 'googl_post_columns');
add_action('manage_portfolio_custom_column', 'googl_custom_columns');
add_filter('manage_edit-portfolio_columns', 'googl_post_columns');

?>
