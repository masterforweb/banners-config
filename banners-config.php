<?php
/** 
Plugin Name: Banners Config
Description: Banners php сonfiguration
Version: 1.0
Author: AK Delfin

Сonfiguration file: /wp-content/banners-config.php

Add code to your template:

<?php 
    if (function_exists('banners_conf_display')){
        banners_conf_display( 'test_240x400' );
    }
?>

or unsafe

<?php banners_conf_display( 'test_240x400' );?>

*/

if ( !defined('ABSPATH') ) {
    exit; 
}


//load config banners
function banners_conf_get(){

    $f_banners_config = WP_CONTENT_DIR.'/banners-config.php';

    if (file_exists( $f_banners_config ) ){
        
        $config = include $f_banners_config;
        return $config;

    } 

    return null;

}


// helper banner
function banners_conf_display( $banner_name, $display = true ){

    static $banners = null;

    if ( $banners === null ) {
        $banners = banners_conf_get(); // загрузка конфигурации в память
    }


    if (!isset( $banners[$banner_name] )){ // no found banner
        return '';
    }


    if ( !isset( $banners[$banner_name]['active'])){ //no action
        return '';
    }

    
    if ( $banners[$banner_name]['active'] == 0){ // no action
        return ''; 
    } 
        
   
    $attachment_id = $banners[$banner_name]['id'];

    $attachment = get_post( $attachment_id  ); // Получение объекта медиафайла

    if ( $attachment ) {
        $imgurl = wp_get_attachment_url( $attachment_id ); // URL медиафайла
        //$caption = $attachment->post_excerpt; // Подпись к фото
        $alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ); // Значение атрибута alt

    }

    if (isset( $banners[$banner_name]['url'] ) && trim( $banners[$banner_name]['url'] ) !== ''){

        $url = $banners[$banner_name]['url'];

        if (isset( $banners[$banner_name]['erid']) AND $banners[$banner_name]['erid'] !== '' ){
            $url .= '?erid='.$banners[$banner_name]['erid'];
        }
    
        $result = '<a href="'.$url.'">';
    }

    
    if (isset( $banners[$banner_name]['version']) ){
        $imgurl .= '?ver='.$banners[$banner_name]['version'];
    }


    $result .= '<img src="'.$imgurl.'"';

    if (isset( $banners[$banner_name]['width']) ){
        $result .= ' width="'.$banners[$banner_name]['width'].'"';
    }

    if (isset( $banners[$banner_name]['height']) ){
        $result .= ' height="'.$banners[$banner_name]['height'].'"';
    }   
    
    if (isset($alt) AND $alt != ''){
        $result .= ' alt="'.$alt.'"';
    }    

    $result .= '>'; 

    if (isset($url)){
        $result .= '</a>'; 
    }
    

    if ( $display ) { // делать echo 
        echo $result;
        return;
    } else { // вернуть HTML
        return $result;
    } 
     
    
}


function banners_conf_plugin_activate() {
    
    $f_banners_config = WP_CONTENT_DIR . '/banners-config.php';

    if (!file_exists($f_banners_config)) {
       
        $file_content = "<?php 
        /** 
         * Add code to your template:
         * 
         * <?php if (function_exists( 'banners_conf_display' )){
         *   banners_conf_display( 'test_240x400' );
         *}?>
         *  
         * or unsafe
         * 
         * <?php banners_conf_display( 'test_240x400' );?>
         * 
        */
        return [
            'test_240x400' => [ # banner_name
                'id' => 1, # id mediafile   
                'url' => '".esc_url(get_site_url())."',
                'erid' => '',
                'width' => 240,
                'height' => 400,
                'active' => 1      
            ],
        ];";

        file_put_contents($f_banners_config, $file_content);
    }
    

}


register_activation_hook( __FILE__, 'banners_conf_plugin_activate' );
