<?php
/**
 * Flex @package Helix Ultimate Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Factory;

$doc = Factory::getDocument();
$app = Factory::getApplication();

//Load Helix
$helix3_path = JPATH_PLUGINS.'/system/helix3/core/helix3.php';

if (file_exists($helix3_path)) {
    require_once($helix3_path);
    $this->helix3 = Helix3::getInstance();
} else {
    die('Please install and activate helix plugin');
}

// Remove the generator meta tag
if($this->helix3->getParam('remove_joomla_generator')) {
  $doc->setGenerator(null);
}

$offline_date = explode('-', $this->params->get("offline_date"));

require_once JPATH_ADMINISTRATOR . '/components/com_users/helpers/users.php';

$twofactormethods = UsersHelper::getTwoFactorMethods();
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language; ?>" dir="<?php echo $this->direction; ?>">
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
    if($favicon = $this->params->get('favicon')) {
        $doc->addFavicon( Uri::base(true) . '/' .  $favicon);
    } else {
        $doc->addFavicon( $this->baseurl . '/templates/'. $this->template .'/images/favicon.ico' );
    }
	
	$this->helix3->addCSS('bootstrap.min.css, template.css, font-awesome.min.css')
    	->addJS('bootstrap.min.js, main.js, jquery.countdown.min.js');

	//Custom CSS
	if ($custom_css = $this->helix3->getParam('custom_css')) {
		$doc->addStyledeclaration($custom_css);
	}

	//Custom JS
	if ($custom_js = $this->helix3->getParam('custom_js')) {
		$doc->addScriptdeclaration($custom_js);
	}
	//Custom background image
	if($offline_bg_image = $this->helix3->getParam('offline_bg_image')) {
		
		$offline_bg = 'background-color: transparent;';
		$offline_bg .= 'background-image: url(' . Uri::base(true ) . '/' . $offline_bg_image . ');';
		$offline_bg .= 'background-repeat: no-repeat;';
		$offline_bg .= 'background-size: cover;';
		$offline_bg .= 'background-attachment: fixed;';
		$offline_bg .= 'background-position: 50% 50%;';
		$offline_bg = 'body {' . $offline_bg . '}'; 
	
		$doc->addStyledeclaration( $offline_bg );
	}
	
	//Body Font
	$webfonts = array();
	
	if( $this->params->get('enable_body_font') ) {
		$webfonts['.offline-container'] = $this->params->get('body_font');
	}
	//Heading1 Font
	if( $this->params->get('enable_h1_font') ) {
		$webfonts['h1'] = $this->params->get('h1_font');
	}
	
	$this->helix3->addGoogleFont($webfonts);
	
	if($offline_bg_image = $this->helix3->getParam('offline_bg_image')) {
		$style = ' style="box-shadow: 0 3px 20px rgba(10,10,10,.2);"';
	} else {
		$style = '';
	}
    ?>
<jdoc:include type="head" /> 
<body>
	<div class="container-fluid offline-container">
		<div class="row-fluid">
			<div class="col-sm-8">
				<div<?php echo $style; ?> class="offline-inner">
					<jdoc:include type="message" />

					<div id="frame" class="outline">
						<?php if ($app->get('offline_image') && file_exists($app->get('offline_image'))) { ?>
                        	<div class="centered-logo">
								<img src="<?php echo $app->get('offline_image'); ?>" alt="<?php echo htmlspecialchars($app->get('sitename')); ?>" />
                            </div>
						<?php } else { ?>
						<h1 style="text-align:center;">
							<?php echo htmlspecialchars($app->get('sitename')); ?>
						</h1>
                        <?php } ?>
                       
						<?php if ($app->get('display_offline_message', 1) == 1 && str_replace(' ', '', $app->get('offline_message')) != '') : ?>
							<div class="offline_message">
								<?php echo $app->get('offline_message'); ?>
							</div>
						<?php elseif ($app->get('display_offline_message', 1) == 2 && str_replace(' ', '', Text::_('JOFFLINE_MESSAGE')) != '') : ?>
							<p style="text-align:center;"><?php echo Text::_('JOFFLINE_MESSAGE'); ?></p>
						<?php endif; ?>
                
						<form action="<?php echo Route::_('index.php', true); ?>" method="post" id="form-login">
							<div class="form-group" id="form-login-username">
								<input name="username" id="username" type="text" class="form-control" placeholder="<?php echo Text::_('JGLOBAL_USERNAME'); ?>" size="18" />
							</div>
							<div class="form-group" id="form-login-password">
								<input type="password" name="password" class="form-control" size="18" placeholder="<?php echo Text::_('JGLOBAL_PASSWORD'); ?>" id="passwd" />
							</div>
							<?php if (count($twofactormethods) > 1) : ?>
							<div class="form-group" id="form-login-secretkey">
								<input type="text" name="secretkey" class="form-control" size="18" placeholder="<?php echo Text::_('JGLOBAL_SECRETKEY'); ?>" id="secretkey" />
							</div>
							<?php endif; ?>
							<div class="form-group" id="submit-buton">
								<input type="submit" name="Submit" class="btn btn-readmore login" value="<?php echo Text::_('JLOGIN'); ?>" />
							</div>
							
							<input type="hidden" name="option" value="com_users" />
							<input type="hidden" name="task" value="user.login" />
							<input type="hidden" name="return" value="<?php echo base64_encode(Uri::base()); ?>" />
							<?php echo HTMLHelper::_('form.token'); ?>
							
						</form>
					</div>
                    <?php if( $this->params->get('comingsoon_counter') ) { ?>
                    <hr />
					<div class="sp-comingsoon-content">
						<?php echo $this->params->get('offline_content'); ?>
					</div>
               	    <div id="sp-comingsoon-countdown" class="sp-comingsoon-countdown"></div>
					<?php } ?>		

				</div>
			</div>
		</div>
	</div>
    <script type="text/javascript">
		jQuery(function($) {
			$('#sp-comingsoon-countdown').countdown('<?php echo trim($offline_date[2]); ?>/<?php echo trim($offline_date[1]); ?>/<?php echo trim($offline_date[0]); ?>', function(event) {
			    $(this).html(event.strftime('<div class="days"><span class="number">%-D</span><span class="string">%!D:<?php echo Text::_("HELIX_DAY"); ?>,<?php echo Text::_("HELIX_DAYS"); ?>;</span></div><div class="hours"><span class="number">%H</span><span class="string">%!H:<?php echo Text::_("HELIX_HOUR"); ?>,<?php echo Text::_("HELIX_HOURS"); ?>;</span></div><div class="minutes"><span class="number">%M</span><span class="string">%!M:<?php echo Text::_("HELIX_MINUTE"); ?>,<?php echo Text::_("HELIX_MINUTES"); ?>;</span></div><div class="seconds"><span class="number">%S</span><span class="string">%!S:<?php echo Text::_("HELIX_SECOND"); ?>,<?php echo Text::_("HELIX_SECONDS"); ?>;</span></div>'));
			});
		});
	</script>
</body>
</html>

