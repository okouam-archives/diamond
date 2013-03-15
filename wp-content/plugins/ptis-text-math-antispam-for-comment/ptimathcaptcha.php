<?php
/*
Plugin Name: Pti's Text-Math Antispam for comment
Plugin URI: http://www.ptipti.ru/pti_math/
Description: A simple plugin displays a math question in the form of text while writing a comment
Author: Pti_the_Leader
Version: 1.4.2
Author URI: http://www.ptipti.ru/
*/

session_start();
//Подключаем файл локализации, если такавой имеется;
load_plugin_textdomain ('ptimathcaptcha', PLUGINDIR.'/'.dirname (plugin_basename(__FILE__)), dirname (plugin_basename(__FILE__)));

//Подключаем плугин к ядру Wordpress;
add_action ('comment_form', 'draw_form');
add_action ('comment_post', 'check_captcha');

//Настройки плагина;
register_activation_hook (__FILE__, 'set_pti_options');
register_deactivation_hook (__FILE__, 'unset_pti_options');
add_action ('admin_menu', 'modify_pti_plugin');
add_filter ('plugin_action_links', 'set_pti_plugin_meta', 10, 2);

//фанкшаны;
function draw_form ($id) {
	global $user_ID;
	//Показываем капчу только неавторизованным. Зареганые пользователи уже отмучались;
	if( $user_ID ) {
		return $id;
	} else {
		$a = rand (1, 9);
		$b = rand (1, 9);
		$mathaction = rand (0, 11);
		$question = __('Q:', 'ptimathcaptcha').' ';
		if ( $mathaction <= 4 ) { //Сумма;
			$result = $a+$b;
			$a = convert_to_text ($a);
			$b = convert_to_text ($b);
			$question .= $a.' '.__('plus', 'ptimathcaptcha').' '.$b;
		} elseif ( $mathaction <= 8 ) { //Вычитание;
			if ( $a > $b ) {
				$result = $a-$b;
				$a = convert_to_text ($a);
				$b = convert_to_text ($b);
				$question .= $a.' '.__('minus', 'ptimathcaptcha').' '.$b;
			} else {
				$result = $b-$a;
				$a = convert_to_text ($a);
				$b = convert_to_text ($b);
				$question .= $b.' '.__('minus', 'ptimathcaptcha').' '.$a;
			}
		} else { //Умножение;
			$result = $a*$b;
			$a = convert_to_text ($a);
			$b = convert_to_text ($b);
			$question .= $a.' '.__('multiplied by', 'ptimathcaptcha').' '.$b;
		}
		$question .=' '. __('is...', 'ptimathcaptcha');
		$_SESSION['qdata'] = $question;
		?>
        	<p id="pticaptcha"><input type="text" name="useranswer" maxlength="2" tabindex="3" class="tf"  size="22" /><?php if (get_option ('use_img')) { echo '<img src="'.get_option('siteurl').'/'.PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)).'/image.php" alt="'. __('Turn on pictures to see the captcha', 'ptimathcaptcha').'" />'; } else { echo '<label for="useranswer"><small>'.$question.'</small></label>'; } ?><span style="color:red; font-weight:bold"> *</span></p>
		<input type='hidden' name='question_id' value='<?php echo md5($result); ?>' />
<?php }

//Неудобство с расстановкой полей в ВП. Поле капчи появляется после поля ввода URL или Email, если удалён ввод URL;
?>
<script type="text/Javascript">
var uoeField = document.getElementById("url");
if ( !uoeField ) {
var uoeField = document.getElementById("email");
}
var captchaP = document.getElementById("pticaptcha");
var submitp = uoeField.parentNode;
submitp.appendChild(captchaP, uoeField);
</script><?php
}

function convert_to_text ($temp) {
$value = array( __('zero', 'ptimathcaptcha'), __('one', 'ptimathcaptcha'), __('two', 'ptimathcaptcha'), __('three', 'ptimathcaptcha'), __('four', 'ptimathcaptcha'), __('five', 'ptimathcaptcha'), __('six', 'ptimathcaptcha'), __('seven', 'ptimathcaptcha'), __('eight', 'ptimathcaptcha'), __('nine', 'ptimathcaptcha'));
return $value [$temp];
}

function check_captcha ($id) {
	global $user_ID;
	if ($user_ID){
		return $id;
	} else {
		if ( md5 ($_POST['useranswer']) != $_POST['question_id'] ){
			wp_set_comment_status ($id, 'spam'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<title><?php _e('Spam-comment detected!', 'ptimathcaptcha'); ?></title>
</head>
<body>
	<div align="center" style="background-color:#FFBFC1; border:solid 1px #B30004; color: #B30004; padding: 3px;"><?php _e('Stop spam to this site or use a calculator.', 'ptimathcaptcha'); ?></div>
</body>
</html><?php
			exit();
		}
	}
}

function set_pti_options () {
add_option ('use_img', 'TRUE', '', 'yes');
}

function unset_pti_options () {
delete_option ('use_img');
}

function modify_pti_plugin () {
add_options_page ( __('Changing Ptis Antispam Plugin Options', 'ptimathcaptcha'), __('Antispam options', 'ptimathcaptcha'), 'manage_options', __FILE__, 'admin_antispam_options');
}

function admin_antispam_options () {
echo '<div class="wrap"><h2>'. __('Changing Ptis Antispam Plugin Options', 'ptimathcaptcha').'</h2>';
if ($_REQUEST ['submit']) { update_pti_options (); }

$array = file (ABSPATH.'/'.PLUGINDIR.'/'.dirname (plugin_basename(__FILE__)).'/image.php');

echo '<form method="post"><label for="use_img_post"><input type="checkbox" '; if (get_option ('use_img')) { echo 'CHECKED '; } echo 'name="use_img_post" value="use_img_post" onClick="showHide(\'imgsttngs\');" /> '. __('Convert sentenses to image', 'ptimathcaptcha').'</label><br /><div id="imgsttngs" style="display:'; if (get_option ('use_img')) { echo 'block'; } else { echo 'none';} echo '"><br />'. __('Image background color (RGB)', 'ptimathcaptcha').'<br />'.get_colors ($array, 'bg', 'bgColor = imagecolorallocate').'<br /><br />'. __('Text color in image (RGB)', 'ptimathcaptcha').'<br />'.get_colors ($array, 'im', 'textColor = imagecolorallocate').'</div><br /><input type="submit" name="submit" value="'. __('Submit', 'ptimathcaptcha').'" /></form>';
echo '
<script type="text/Javascript">
function showHide ($id) {
	if (document.getElementById($id).style.display == \'none\') {
		document.getElementById($id).style.display = \'block\';
	} else {
		document.getElementById($id).style.display = \'none\';
	}
}
</script>';
}

function update_pti_options () {
	if ($_REQUEST ['use_img_post']) { $use_img_to = TRUE; } else { $use_img_to = FALSE;}
	if (get_option ('use_img') != $use_img_to) {
		if (update_option ('use_img', $use_img_to)) {
			$OK_message = '<div id="message" class="updated fade" align="center"><p><strong>'. __('Options updated.', 'ptimathcaptcha').'</strong></p></div>';
		} else {
			$OK_error = '<div id="message" class="error fade" align="center"><p><strong>'. __('Failed to update options!', 'ptimathcaptcha').'</strong></p></div>';
		}
	}

	$array = file (ABSPATH.'/'.PLUGINDIR.'/'.dirname (plugin_basename(__FILE__)).'/image.php');
	$CollectBgColors = '('.$_REQUEST ['bgR'].', '.$_REQUEST ['bgG'].', '.$_REQUEST ['bgB'].')';
	$CollectImColors = '('.$_REQUEST ['imR'].', '.$_REQUEST ['imG'].', '.$_REQUEST ['imB'].')';
	if ($CollectBgColors != get_colors ($array, 'no_html', 'bgColor = imagecolorallocate') || $CollectImColors != get_colors ($array, 'no_html', 'textColor = imagecolorallocate')) {
		$file = ABSPATH.'/'.PLUGINDIR.'/'.dirname (plugin_basename(__FILE__)).'/image.php';
		$data = '<?php
session_start();
$qdata = $_SESSION[\'qdata\'];
$question = iconv (\'utf-8\', \'windows-1251\', $qdata);
$image = imageCreate (strlen ($question)*7, 9);
$bgColor = imagecolorallocate ($image, '.$_REQUEST ['bgR'].', '.$_REQUEST ['bgG'].', '.$_REQUEST ['bgB'].');
$textColor = imagecolorallocate ($image, '.$_REQUEST ['imR'].', '.$_REQUEST ['imG'].', '.$_REQUEST ['imB'].');
$mf = imageloadfont (\'./myfont.phpfont\');
imagestring ($image, $mf, 1, 1, $question, $textColor);
header (\'Content-type: image\/jpeg\');
imagejpeg ($image);
?>';
		if ($fp = @fopen($file, 'wb')) {
            	@fwrite($fp, $data, strlen($data));
            	@fclose($fp);
			$OK_message = '<div id="message" class="updated fade" align="center"><p><strong>'. __('Options updated.', 'ptimathcaptcha').'</strong></p></div>';
		} else {
			$OK_error = '<div id="message" class="error fade" align="center"><p><strong>'. __('Failed write to file!', 'ptimathcaptcha').'</strong></p></div>';
		}
	}
if ($OK_error) echo $OK_error;
if ($OK_message) echo $OK_message;
}

function set_pti_plugin_meta ($links, $file) {
if ( $file != plugin_basename( __FILE__ )) { return $links; }
	$pti_settings_link = '<a href="options-general.php?page='.dirname (plugin_basename(__FILE__)).'/ptimathcaptcha.php">'. __('Antispam options', 'ptimathcaptcha').'</a>';
	array_push ($links, $pti_settings_link);
 	return $links;
}

function get_colors ($array, $prefix, $value) {
	for ($i=0; $i<count ($array); $i++) {
		if (strstr ($array[$i], $value)) {
			preg_match('/(\d{1,3}), (\d{1,3}), (\d{1,3})\)/', $array[$i], $matches);
			if ($prefix == 'no_html') {
				return '('.$matches[1].', '.$matches[2].', '.$matches[3].')';
			} else {
				return '<span  style="color:red">R</span>&nbsp;<input type="text" name="'.$prefix.'R" value="'.$matches[1].'" size="3" MAXLENGTH="3" style="color:red" />&nbsp;&nbsp;+&nbsp;&nbsp;<span  style="color:green">G</span>&nbsp;<input type="text" name="'.$prefix.'G" value="'.$matches[2].'" size="3" MAXLENGTH="3" style="color:green" />&nbsp;&nbsp;+&nbsp;&nbsp;<span  style="color:blue">B</span>&nbsp;<input type="text" name="'.$prefix.'B" value="'.$matches[3].'" size="3" MAXLENGTH="3" style="color:blue" />&nbsp;&nbsp;=&nbsp;&nbsp;<span style="background-color: rgb('.$matches[1].', '.$matches[2].', '.$matches[3].');border:1px solid black">&nbsp;&nbsp;&nbsp;</span>';
			}
			break;
		}
	}
}
?>