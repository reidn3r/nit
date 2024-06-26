<?php
/**
 * Flex @package Helix Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2020 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Language\Text;

$url  	=  Route::_(ContentHelperRoute::getArticleRoute($displayData->id . ':' . $displayData->alias, $displayData->catid, $displayData->language));
$root 	= Uri::base();
$root 	= new Uri($root);
$url  	= $root->getScheme() . '://' . $root->getHost() . $url;
$params = Factory::getApplication()->getTemplate(true)->params;

if( $params->get('social_share') ) { ?>
	<div class="helix-social-share">
		<div class="helix-social-share-blog helix-social-share-article">
			<ul>
				<?php if ($params->get('share_facebook', 1)) { ?>
				<li>
					<div class="facebook" data-toggle="tooltip" data-placement="top" title="<?php echo Text::_('HELIX_SHARE_FACEBOOK'); ?>">

						<a class="facebook" onClick="window.open('http://www.facebook.com/sharer.php?u=<?php echo $url; ?>','Facebook','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;" href="http://www.facebook.com/sharer.php?u=<?php echo $url; ?>">
							<i class="fab fa-facebook-square"></i> <?php echo  Text::_('HELIX_FACEBOOK'); ?>
						</a>

					</div>
				</li>
                <?php } ?>
				<?php if ($params->get('share_twitter', 1)) { ?>
				<li>
					<div class="twitter" data-toggle="tooltip" data-placement="top" title="<?php echo JText::_('HELIX_SHARE_TWITTER'); ?>">
						<a class="twitter" onClick="window.open('http://twitter.com/share?url=<?php echo $url; ?>&amp;text=<?php echo str_replace('  ', '%20', $displayData->title); ?>','Twitter share','width=600,height=300,left='+(screen.availWidth/2-300)+',top='+(screen.availHeight/2-150)+''); return false;" href="http://twitter.com/share?url=<?php echo $url; ?>&amp;text=<?php echo str_replace(' ', '%20', $displayData->title); ?>">
							<i class="fab fa-twitter-square"></i> <?php echo  Text::_('HELIX_TWITTER'); ?>
						</a>
					</div>
				</li>
                <?php } ?>
                <?php if ($params->get('share_linkedin', 1)) { ?>
				<li>
					<div class="linkedin">
						<a class="linkedin" data-toggle="tooltip" data-placement="top" title="<?php echo Text::_('HELIX_SHARE_LINKEDIN'); ?>" onClick="window.open('http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url; ?>','Linkedin','width=585,height=666,left='+(screen.availWidth/2-292)+',top='+(screen.availHeight/2-333)+''); return false;" href="http://www.linkedin.com/shareArticle?mini=true&url=<?php echo $url; ?>" >	
						<i class="fab fa-linkedin-in"></i></a>
					</div>
				</li>
                <?php } ?>
			</ul>
		</div>		
	</div> <!-- /.helix-social-share -->
<?php } ?>