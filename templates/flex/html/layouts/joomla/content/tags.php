<?php
/**
 * Flex @package Helix Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Router\Route;
use Joomla\Component\Tags\Site\Helper\RouteHelper;
use Joomla\Registry\Registry;
use Joomla\CMS\Language\Text;

$authorised = Factory::getUser()->getAuthorisedViewLevels();

if (JVERSION < 4) {
	JLoader::register('TagsHelperRoute', JPATH_BASE . '/components/com_tags/helpers/route.php');
}

$tag = '';

?>
<?php if (!empty($displayData)) : ?>
	<div class="tags clearfix w-100">
    	<?php // Tags or (one) tag
		foreach ($displayData as $n => $nmb) :
			if($n == 0) :
				$number_tags = '';
            else : 
				$number_tags = 's';
            endif;
		endforeach; ?>
        <span><i class="fas fa-tag<?php echo $number_tags; ?>" data-toggle="tooltip" title="<?php echo Text::_('HELIX_TAGS'); ?>"></i></span>   
		<?php foreach ($displayData as $i => $tag) : 
			if (JVERSION < 4) {
				$link = Route::_(TagsHelperRoute::getTagRoute($tag->tag_id . '-' . $tag->alias));
			} else {
				$link = Route::_(RouteHelper::getTagRoute($tag->tag_id . ':' . $tag->alias));
			}
			if (in_array($tag->access, $authorised)) : ?>
				<?php $tagParams = new Registry($tag->params); ?>
				<?php $link_class = $tagParams->get('tag_link_class'); ?>
				<a href="<?php echo $link; ?>" class="<?php echo $link_class; ?>" rel="tag"><?php echo $this->escape($tag->title); ?></a>
				<?php if ($link_class != 'label label-info') { 
					if($i != (count($displayData)-1)) echo ','; ?>	
				<?php } ?>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
<?php endif; ?>
