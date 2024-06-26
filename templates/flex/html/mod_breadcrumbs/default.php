<?php
/**
 * Flex @package Helix Ultimate Framework
 * Template Name - Flex
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
*/

// no direct access
defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\WebAsset\WebAssetManager;

//JHtml::_('bootstrap.tooltip');
$moduleclass_sfx = '';

?>
<nav class="mod-breadcrumbs__wrapper" aria-label="<?php echo htmlspecialchars($module->title, ENT_QUOTES, 'UTF-8'); ?>">
	<ol itemscope itemtype="https://schema.org/BreadcrumbList" class="mod-breadcrumbs breadcrumb<?php echo $moduleclass_sfx; ?>">
		<?php
		
		if ($params->get('showHere', 1)) {
			echo '<span>' . Text::_('MOD_BREADCRUMBS_HERE') . '&#160;</span>';
		} else {
			if (htmlspecialchars($params->get('homeText'), ENT_COMPAT, 'UTF-8') != '') {
				echo '';
			} else {
				echo '<li><i class="fas fa-home"></i></li>';
			}
		}
		
		// Get rid of duplicated entries on trail including home page when using multilanguage
		for ($i = 0; $i < $count; $i++)
		{
			if ($i === 1 && !empty($list[$i]->link) && !empty($list[$i - 1]->link) && $list[$i]->link === $list[$i - 1]->link)
			{
				unset($list[$i]);
			}
		}

		// Find last and penultimate items in breadcrumbs list
		end($list);
		$last_item_key = key($list);
		prev($list);
		$penult_item_key = key($list);

		// Make a link if not the last item in the breadcrumbs
		$show_last = $params->get('showLast', 1);

		$class   = null;

		//JPath::clean($separator);
		$lang = Factory::getLanguage();

			// If a custom separator has not been provided we try to load a template
			// specific one first, and if that is not present we load the default separator

				if ($lang->isRtl())
				{
					$separator = htmlspecialchars(' \ ', ENT_COMPAT, 'UTF-8');
				}
				else
				{
					$separator = htmlspecialchars(' / ', ENT_COMPAT, 'UTF-8');
				}


			//return $_separator;
		// Generate the trail
		
		foreach ($list as $key => $item) :
			if ($key !== $last_item_key) :
				if (!empty($item->link)) :
					$breadcrumbItem = HTMLHelper::_('link', Route::_($item->link), '<span itemprop="name">' . $item->name . '</span>', ['class' => 'pathway']);
				else :
					$breadcrumbItem = '<span itemprop="name">' . $item->name . '</span>';
				endif;
		        
				if (($key !== $penult_item_key) || $show_last) :
					if (htmlspecialchars($params->get('separator'), ENT_COMPAT, 'UTF-8') != '') :
						$breadcrumbSeparator = '<span class="text_separator">'. $separator .'</span>';
                    else :
                        $breadcrumbSeparator = '<span class="breadcrumb_divider">'. $separator .'<span>';
                    endif; 
				endif;
                 		
				echo '<li class="mod-breadcrumbs__item breadcrumb-item' . $class . '" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">' . $breadcrumbItem . $breadcrumbSeparator .'<meta itemprop="position" content="'. ( $key + 1 ) .'"></li>';

			elseif ($show_last) :
				// Render last item if required.
				$breadcrumbItem = '<span itemprop="name">' . $item->name . '</span>';
				$class          = ' active';
				echo '<li class="mod-breadcrumbs__item breadcrumb-item' . $class . '" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">' . $breadcrumbItem . '<meta itemprop="position" content="'. ( $key + 1 ) .'"></li>';
			endif;
		endforeach;
		?>
	</ol>
	<?php
	// Structured data as JSON
	$data = [
			'@context'        => 'https://schema.org',
			'@type'           => 'BreadcrumbList',
			'itemListElement' => []
	];

	foreach ($list as $key => $item)
	{
		// Only add item to JSON if it has a valid link, otherwise skip it.
		if (!empty($item->link))
		{
			$data['itemListElement'][] = [
					'@type'    => 'ListItem',
					'position' => $key + 1,
					'item'     => [
							'@id'  => Route::_($item->link, true, Route::TLS_IGNORE, true),
							'name' => $item->name,
					],
			];
		}
		elseif ($key === $last_item_key)
		{
			// Add the last item (current page) to JSON, but without a link.
			// Google accepts items without a URL only as the current page.
			$data['itemListElement'][] = [
					'@type'    => 'ListItem',
					'position' => $key + 1,
					'item'     => [
							'name' => $item->name,
					],
			];
		}
	}
	if (JVERSION < 4) {
		// Joomla 3...
	} else {
		// Joomla 4...	
		/** @var WebAssetManager $wa */
		$wa = $app->getDocument()->getWebAssetManager();
		$wa->addInline('script', json_encode($data, JSON_UNESCAPED_UNICODE), [], ['type' => 'application/ld+json']);
	}	
	?>
</nav>
