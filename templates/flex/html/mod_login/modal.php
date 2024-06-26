<?php
/**
 * Flex @package Helix Ultimate Framework
 * Template Name - Flex
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
*/

// no direct access
defined('_JEXEC') or die;

use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Plugin\PluginHelper;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Factory;

if (JVERSION < 4) {
	//JLoader::register('UsersHelperRoute', JPATH_SITE . '/components/com_users/helpers/route.php');
	HTMLHelper::_('behavior.keepalive');
	HTMLHelper::_('bootstrap.tooltip');
} else {
	$app->getDocument()->getWebAssetManager()
	->useScript('core')
	->useScript('keepalive')
	->useScript('field.passwordview');

	Text::script('JSHOWPASSWORD');
	Text::script('JHIDEPASSWORD');
}

$doc = Factory::getDocument();
$user = Factory::getUser();
?>
<div class="modal-login-wrapper p-0">
	<?php // <span class="top-divider"></span> ?>
    <div class="ap-modal-login login">
        <span class="ap-login">
            <a id="modal-<?php echo $module->id; ?>-launch" class="p-0" href="javascript:void(0)" role="button">
                <i class="pe pe-7s-user"></i>
                <span class="info-content"><?php echo Text::_('FLEX_LOGIN'); ?></span>
            </a>  
        </span>
        <?php // Flex Modal ?>
        	<div id="fm-<?php echo $module->id; ?>" class="flex-modal modal-login" aria-labelledby="<?php echo $module->id; ?>-ModalLabel" aria-hidden="true" role="dialog" tabindex="-1">
                <div class="flex-modal-content modal-content" role="document">
                     <button type="button" class="fm-<?php echo $module->id; ?>-close fm-close close" aria-label="Close" data-dismiss="flex-modal" aria-hidden="true"><i class="pe pe-7s-close-circle"></i></button>
                    <div class="flex-modal-header modal-header">
                    	<h2 id="<?php echo $module->id; ?>-ModalLabel" class="title">
                        <svg style="margin:-7px 0 0;vertical-align:middle;" width="1.22em" height="1.22em" viewBox="0 0 16 16" class="bi bi-person major_color-lighten-20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M13 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM3.022 13h9.956a.274.274 0 0 0 .014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 0 0 .022.004zm9.974.056v-.002.002zM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/></svg>
                        <?php echo ($user->id>0) ? Text::_('MY_ACCOUNT') : Text::_('JLOGIN'); ?></h2>
                    </div>
                    <div class="flex-modal-body modal-body">
						
						<?php if (JVERSION < 4) { ?>
							<form action="<?php echo Route::_(htmlspecialchars(Uri::getInstance()->toString()), true, $params->get('usesecure')); ?>" method="post" id="login-form-<?php echo $module->id; ?>">
						<?php } else { ?>
							<form id="login-form-<?php echo $module->id; ?>" class="mod-login" action="<?php echo Route::_('index.php', true); ?>" method="post">
						<?php } ?>
                            <?php if ($params->get('pretext')): ?>
                                <div class="pretext">
                                    <p><?php echo $params->get('pretext'); ?></p>
                                </div>
                            <?php endif; ?>
                            <fieldset class="userdata">
                                <input id="modallgn-username-<?php echo $module->id; ?>" placeholder="<?php echo Text::_('MOD_LOGIN_VALUE_USERNAME') ?>" type="text" name="username" class="input-block-level" required="required"  />
                                <input id="modallgn-passwd-<?php echo $module->id; ?>" type="password" placeholder="<?php echo Text::_('JGLOBAL_PASSWORD') ?>" name="password" class="input-block-level" required="required" />
								
                                <div class="clearfix"></div>
                                <?php if (PluginHelper::isEnabled('system', 'remember')) : ?>
                                    <div class="modlgn-remember remember-wrap pb-0 mb-0">
                                        <input id="modallgn-remember-<?php echo $module->id; ?>" type="checkbox" name="remember" class="inputbox" value="yes"/>
                                        <label for="modallgn-remember-<?php echo $module->id; ?>"><?php echo Text::_('MOD_LOGIN_REMEMBER_ME') ?></label>
                                    </div>
                                <?php endif; ?>
								
								<?php if (JVERSION < 4) {
									// Joomla 3...
								} else {
									// Joomla 4...
									foreach ($extraButtons as $button) :
										$dataAttributeKeys = array_filter(array_keys($button), function ($key) {
											return substr($key, 0, 5) == 'data-';
										});
										?>
										<div class="mod-login__submit form-group mt-0 mb-2 mb-sm-3">
											<button type="button" style="" 
													class="btn btn-secondary sppb-btn-3d btn-xs-block web-auth-btn py-1 w-100 <?php echo $button['class'] ?? '' ?>"
													<?php foreach ($dataAttributeKeys as $key) : ?>
														<?php echo $key ?>="<?php echo $button[$key] ?>"
													<?php endforeach; ?>
													<?php if ($button['onclick']) : ?>
													onclick="<?php echo $button['onclick'] ?>"
													<?php endif; ?>
													title="<?php echo Text::_($button['label']) ?>"
													id="<?php echo $button['id'] ?>"
													>
												<?php if (!empty($button['icon'])) : ?>
													<span class="<?php echo $button['icon'] ?>"></span>
												<?php elseif (!empty($button['image'])) : ?>
													<?php echo $button['image']; ?>
												<?php elseif (!empty($button['svg'])) : ?>
													<?php echo $button['svg']; ?>
												<?php endif; ?>
												<?php echo Text::_($button['label']) ?>
											</button>
										</div>
									<?php endforeach; 
								} ?>
								
                                <div class="button-wrap d-sm-block col-12 col-sm-4"><input type="submit" name="Submit" class="btn btn-primary sppb-btn-3d d-sm-block w-100 text-shadow px-5" value="<?php echo Text::_('JLOGIN') ?>" /></div>
                                <div class="forget-name-link d-sm-block col-12 col-sm-7 mx-auto mt-2 mt-sm-0">
                                    <?php echo Text::_('MOD_LOGIN_FORGOT'); ?> <a href="<?php echo Route::_('index.php?option=com_users&view=remind'); ?>">
                                    <?php echo Text::_('MOD_LOGIN_FORGOT_USERNAME'); ?></a> <?php echo Text::_('MOD_LOGIN_OR'); ?> <a href="<?php echo Route::_('index.php?option=com_users&view=reset'); ?>">
                                    <?php echo Text::_('MOD_LOGIN_FORGOT_PASSWORD'); ?></a> <?php echo Text::_('FLEX_QUESTION_MARK'); ?>
                                </div>
                                <input type="hidden" name="option" value="com_users" />
                                <input type="hidden" name="task" value="user.login" />
                                <input type="hidden" name="return" value="<?php echo $return; ?>" />
								<?php echo HTMLHelper::_('form.token'); ?>
								
                            </fieldset>
                            <?php if ($params->get('posttext')): ?>
                                <div class="posttext">
                                    <p><?php echo $params->get('posttext'); ?></p>
                                </div>
                            <?php endif; ?>
                        </form>
                    </div>
                    <?php
				    $usersConfig = ComponentHelper::getParams('com_users');
						
					if ($usersConfig->get('allowUserRegistration')) : ?>
					 <div class="modal-footer mt-1 mb-2">
						<div class="container align-self-center centered"><?php echo Text::_('MOD_NEW_REGISTER'); ?>
						<a href="<?php echo Route::_('index.php?option=com_users&view=registration'); ?><?php //echo Route::_($registerLink); ?>">
							<?php echo Text::_('MOD_LOGIN_REGISTER'); ?>
							<i class="fas fa-arrow-alt-circle-right" aria-hidden="true"></i>
						</a>
						</div>
					 </div>
					<?php endif; ?>
                </div>
            </div>
       <?php // END Flex Modal ?>
    </div>
</div>
<?php 
	// Add JS and minify
	// setTimeout( function(){ removed...
	$js ='
		function r(f){/in/.test(document.readyState)?setTimeout(\'r(\'+f+\')\',9):f()}

		r(function(){
		
			var modalFlex = document.getElementById("fm-'. $module->id .'");
			var launch_btn = document.getElementById("modal-'. $module->id .'-launch");
			var close_btn = document.getElementsByClassName("fm-'. $module->id .'-close")[0];
		
			function closingdown() {
				modalFlex.classList.remove("open-modal");
			}
			
			launch_btn.addEventListener("click", function(event) {
				modalFlex.classList.add("open-modal");
				
			});
			
			close_btn.addEventListener("click", function(event) {
				 closingdown()
			});
			
			window.addEventListener("click", function(event) {
				if (event.target == modalFlex) {
					closingdown()
				}
			});
		});	
		';
	$js = preg_replace(array('/([\s])\1+/', '/[\n\t]+/m'), '', $js); // Remove whitespace
	$doc->addScriptdeclaration($js);

	//Add css
	if (($params->get('pretext') && $params->get('posttext'))) {
		$style = '.flex-modal .flex-modal-content {top:10vh;}';	
	} else {
		$style = '';	
	}	
	$doc->addStyleDeclaration($style);
?>