<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_content
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;

// Create shortcut
$urls = json_decode($this->item->urls);

// Create shortcuts to some parameters.
$params = $this->item->params;
if ($urls && (!empty($urls->urla) || !empty($urls->urlb) || !empty($urls->urlc))) :
?>
<div class="content-links">
	<ul class="com-content-article__links content-list">
		<?php
			$urlarray = array(
			array($urls->urla, $urls->urlatext, $urls->targeta, 'a'),
			array($urls->urlb, $urls->urlbtext, $urls->targetb, 'b'),
			array($urls->urlc, $urls->urlctext, $urls->targetc, 'c')
			);
			foreach ($urlarray as $url) :
				$link = $url[0];
				$label = $url[1];
				$target = $url[2];
				$id = $url[3];

				if ( ! $link) :
					continue;
				endif;

				// If no label is present, take the link
				$label = ($label) ? $label : $link;

				// If no target is present, use the default
				$target = $target ? $target : $params->get('target' . $id);
				?>
			<li class="content-links-<?php echo $id; ?>">
				<?php
					// Compute the correct link
				
					if (JVERSION < 4) {
						// Joomla 3...
						
						switch ($target)
						{
							case 1:
								// open in a new window
								echo '<a href="' . htmlspecialchars($link) . '" target="_blank"  rel="nofollow">' .
									htmlspecialchars($label) . '</a>';
								break;

							case 2:
								// open in a popup window
								$attribs = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=600';
								echo "<a href=\"" . htmlspecialchars($link) . "\" onclick=\"window.open(this.href, 'targetWindow', '" . $attribs . "'); return false;\">" .
									htmlspecialchars($label) . '</a>';
								break;
							case 3:
								// open in a modal window
								JHtml::_('behavior.modal', 'a.modal');
								echo '<a class="modal" href="' . htmlspecialchars($link) . '"  rel="{handler: \'iframe\', size: {x:600, y:600}}">' .
									htmlspecialchars($label) . ' </a>';
								break;
							default:
								// open in parent window
								echo '<a href="' . htmlspecialchars($link) . '" rel="nofollow">' .
									htmlspecialchars($label) . ' </a>';
								break;
						}

					} else {
						
						// Joomla 4...
						switch ($target)
						{
							case 1:
								// Open in a new window
								echo '<a href="' . htmlspecialchars($link, ENT_COMPAT, 'UTF-8') . '" target="_blank" rel="nofollow noopener noreferrer">' .
									htmlspecialchars($label, ENT_COMPAT, 'UTF-8') . '</a>';
								break;

							case 2:
								// Open in a popup window
								$attribs = 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=600,height=600';
								echo "<a href=\"" . htmlspecialchars($link, ENT_COMPAT, 'UTF-8') . "\" onclick=\"window.open(this.href, 'targetWindow', '" . $attribs . "'); return false;\" rel=\"noopener noreferrer\">" .
									htmlspecialchars($label, ENT_COMPAT, 'UTF-8') . '</a>';
								break;
							case 3:
								echo '<a href="' . htmlspecialchars($link, ENT_COMPAT, 'UTF-8') . '" rel="noopener noreferrer" data-bs-toggle="modal" data-bs-target="#linkModal">' .
									htmlspecialchars($label, ENT_COMPAT, 'UTF-8') . ' </a>';
								echo HTMLHelper::_(
									'bootstrap.renderModal',
									'linkModal',
									array(
										'url'    => $link,
										'title'  => $label,
										'height' => '100%',
										'width'  => '100%',
										'modalWidth'  => '500',
										'bodyHeight'  => '500',
										'footer' => '<button type="button" class="btn btn-secondary" data-bs-dismiss="modal" aria-hidden="true">'
											. \Joomla\CMS\Language\Text::_('JLIB_HTML_BEHAVIOR_CLOSE') . '</button>'
									)
								);
								break;

							default:
								// Open in parent window
								echo '<a href="' . htmlspecialchars($link, ENT_COMPAT, 'UTF-8') . '" rel="nofollow">' .
									htmlspecialchars($label, ENT_COMPAT, 'UTF-8') . ' </a>';
								break;
						}

					}	
				?>
				</li>
		<?php endforeach; ?>
	</ul>
</div>
<?php endif; ?>
