<?php
/*
Plugin Name: Hide my site
Plugin URI: http://www.jefs.com.br/hide-my-site
Description: Block access to your site fast way while this production. This is a great tool for someone setting up a development version of a wordpress site or anyone else looking to hide their site from the public.
Version: 1.0
Author: Jefs Pereira
Author URI: http://www.jefs.com.br
*/

@require_once( ABSPATH . "wp-includes/pluggable.php" );
$splash = $_POST['upload_image'];
function admin_register_head() {
    $siteurl = get_option('siteurl');
    $url = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/css/plug_style.css';
    $url2 = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/js/upload.js';
    echo "<link rel='stylesheet' type='text/css' href='".$url."' />";
    echo "<script src='".$url2."' ></script>";

}
add_action('admin_head', 'admin_register_head');

// cria area de configuração
function menu(){
	add_menu_page('Hide my site - Admin','Hide my site ',10,'wp-hide-my-site/configuration.php');
}
add_action('admin_menu','menu');

function redirect(){
ob_start();	
$siteurl = get_option('siteurl');
if (!is_user_logged_in()) {
  echo ' <script type="text/javascript">location.href="'.$siteurl.'/welcome.php";</script> ';
}
}
//add shortcodes
add_shortcode('redirect','redirect');

function wp_gear_manager_admin_scripts() {
wp_enqueue_script('media-upload');
wp_enqueue_script('thickbox');
wp_enqueue_script('jquery');
}

function wp_gear_manager_admin_styles() {
wp_enqueue_style('thickbox');
}

add_action('admin_print_scripts', 'wp_gear_manager_admin_scripts');
add_action('admin_print_styles', 'wp_gear_manager_admin_styles');


//cria tabela de que sera responsavel por armazenar configurações no banco de dados -----//
global $wpdb;
//verifica se atabela já não existe
if( !$wpdb->get_var("SHOW TABLES LIKE hiddenmysite") ){
    $sSqlTable = "CREATE TABLE hiddenmysite (
    new_id int(10) NOT NULL  PRIMARY KEY,
    url_image varchar(150),
	  background varchar(10));";
    $result = $wpdb->query($sSqlTable);
}

$siteurl = get_option('siteurl');
$logo = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/img/logo-hidden.png';

// consulta no banco ------------------------------------//
global $wpdb;
	$resultados = array();
	$resultados = $wpdb->get_results('SELECT * FROM hiddenmysite');
	if (!$resultados){
	// se o array estiver vazio preenche a tabela com valores padrao.	
	global $wpdb;
	$wpdb->query('INSERT INTO hiddenmysite (new_id, url_image,background) 
						  VALUES ("1","'.$logo.'" ,"#fff")');
}

// consulta no banco ------------------------------------//
global $wpdb;
$have_splash = $wpdb->get_results('SELECT * FROM hiddenmysite');
foreach($have_splash as $splash)
{
    $urlimage = $splash->url_image;
    $color = $splash->background;

// Definindo o nome do arquivo a ser criado.
$filename = "welcome.php";

//Adciona um texto na página
$script = "
<!doctype html>
<html lang='en'>
<head>
  <meta charset='UTF-8'>
  <title>". get_option('blogname')." - ".get_option('blogdescription')."</title>
  <style>
  body{
    background: ".$color.";
  }
  .content{
    margin: 150px auto;
    text-align:center;
  }
  </style>
</head>
<body>
  <div class='content'>
    <img src='".$urlimage."' >
  </div>
</body>
</html>";

//Escrevendo o texto na página
$file = @fopen($filename, "w+");
@fwrite($file, stripslashes($script));
@fclose($file);
}
?>