<?php
/**
 * @package     Joomla.Site
 * @subpackage  Layout
 *
 * @copyright   (C) 2016 Open Source Matters, Inc. <https://www.joomla.org>
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

$article = $displayData['article'];
$tooltip = $displayData['tooltip'];
$nowDate = strtotime(Factory::getDate());

$icon = $article->state ? 'edit' : 'eye-slash';
$currentDate   = Factory::getDate()->format('Y-m-d H:i:s');
$isUnpublished = ($article->publish_up > $currentDate)
	|| !is_null($article->publish_down) && ($article->publish_down < $currentDate);

if ($isUnpublished)
{
	$icon = 'eye-slash';
}
$aria_described = 'editarticle-' . (int) $article->id;

?>
<button style="box-shadow: 0 3px 1px rgba(0,0,0,0.25);" id="<?php echo $aria_described; ?>" class="d-flex btn sppb-btn-default" data-toggle="tooltip" data-bs-html="true" title="<?php echo Text::_('JGLOBAL_EDIT') .' '. $tooltip; ?>">
<span class="icon-<?php echo $icon; ?> pt-1 pe-2" aria-hidden="true"></span>
	<?php echo Text::_('JGLOBAL_EDIT'); ?> 
</button>
