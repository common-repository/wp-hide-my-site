<?php
//recebe link da imagem de splash
$splash = $_POST['upload_image'];
$color = $_POST['color'];
$acao = $_POST['acao'];

if (isset($_POST['default'])){
plugdefault();
}

if($acao == "salvar"){
		
    	global $wpdb;
		$wpdb->query('UPDATE hiddenmysite SET new_id =  1 ,url_image = "'.$splash.'", background = "'.$color.'" WHERE 1');
		$wpdb->show_errors = TRUE;

		if ($wpdb->last_error) {
  		die('error=' . var_dump($wpdb->last_query) . ',' . var_dump($wpdb->error));
		}
		}

//default configurates of plugin
function plugdefault(){
$siteurl = get_option('siteurl');
$defaulturl = $siteurl . '/wp-content/plugins/' . basename(dirname(__FILE__)) . '/img/logo-hidden.png';
$defaultcolor = "#fff";

global $wpdb;
		$wpdb->query('UPDATE hiddenmysite SET new_id =  1 ,url_image = "'.$defaulturl.'", background = "'.$defaultcolor.'" WHERE 1');
		$wpdb->show_errors = TRUE;

		if ($wpdb->last_error) {
  		die('error=' . var_dump($wpdb->last_query) . ',' . var_dump($wpdb->error));
		}
		

}
 // consulta no banco ------------------------------------//
global $wpdb;
$have_splash = $wpdb->get_results('SELECT * FROM hiddenmysite');
foreach($have_splash as $splash)
{
    $urlimage = $splash->url_image;
    $color = $splash->background;
}
if(empty($gearimage)){
	$valor = $urlimage;
}else{
	$valor = $gearimage;
}

?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Hide my site</title>
	<script>
	function plugdefault() {
	var	form = document.getElementById("form1");
	form.action="options-general.php?page=wp-hide-my-site/configuration.php";
	form.submit();
	}
</script>
	</script>
</head>

<body>
	<div class="master">
	<div class="titulo">
	<h1 class="opt">Options</h1>
	<h1 class="prev">Preview</h1>
	</div>
	
	<div class="fomr">
	<form action="options-general.php?page=wp-hide-my-site/configuration.php" method="POST">
	<input type="hidden" name="acao" value="salvar">
	<label style="display: inherit;" class="descp1">Splash image</label><br/>
	<input class="short" id="upload_image" type="text" size="36" name="upload_image" value="<?php echo $valor; ?>" placeholder="Enter an URL or upload an image splash for your site. " style="width: 300px!important;"required/>
	<input class="upload" id="upload_image_button" type="button" value="Upload Image" />
	<br/><br/><br/>
	<label class="descp1" for="short">Custom background page.</label><br><br>
	<input class="short" name="color"type="text" value="<?php echo $color; ?>">
	<br/><br/><br/>	
	<label class="descp1" for="short">Insert code in the first line of the file "header.php" of your theme.</label><br><br>
	<input class="short" name="short"type="text" value="<?php echo "<?php do_shortcode('[redirect]'); ?>"?>">
	<br> <br><br><br>
		<label class="descp1" for="short"><a href="#" onClick="plugdefault()">Default options</a></label>
	<input class="save" type="submit" value="Save changes">

</form >

<form id="form1" method="POST">
	<input type="hidden" name="default" value="default">
</form>
<div class="donate">
	I and my girlfriend will get engaged soon.
	<!-- INICIO FORMULARIO BOTAO PAYPAL -->
<form class="paypal" action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="XBX3VDEW2HNXE">
<input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
<img alt="" border="0" src="https://www.paypalobjects.com/pt_BR/i/scr/pixel.gif" width="1" height="1">
</form>

<!-- INICIO FORMULARIO BOTAO PAGSEGURO -->
<form target="pagseguro" action="https://pagseguro.uol.com.br/checkout/v2/donation.html" method="post">
<!-- NÃO EDITE OS COMANDOS DAS LINHAS ABAIXO -->
<input type="hidden" name="receiverEmail" value="ola@jefs.com.br" />
<input type="hidden" name="currency" value="BRL" />
<input type="image" src="https://p.simg.uol.com.br/out/pagseguro/i/botoes/doacoes/209x48-doar-assina.gif" name="submit" alt="Pague com PagSeguro - é rápido, grátis e seguro!" />
</form>
<!-- FINAL FORMULARIO BOTAO PAGSEGURO -->
</div></div>
<div class="preview" style="background:<?php echo $color; ?>;">
		<?php echo '<img src="'.$urlimage.'" class="thumb">';?>
</div>
</div>
</body>
</html>