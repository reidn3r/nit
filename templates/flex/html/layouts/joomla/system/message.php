<?php
/**
 * Flex @package Helix3 Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Application\CMSApplication;
use Joomla\CMS\Factory;
use Joomla\CMS\Language\Text;

/* @var $displayData array */
$msgList   = $displayData['msgList'];

if (JVERSION < 4) {
	// Joomla 3...
	?>
	<div id="system-message-container">
		<?php if (is_array($msgList) && !empty($msgList)) : ?>
			<div id="system-message">
				<?php foreach ($msgList as $type => $msgs) : ?>
					<div class="alert alert-<?php echo str_replace('alert-error', 'alert-error alert-danger', $type); ?>">
						<?php // This requires JS so we should add it trough JS. Progressive enhancement and stuff. ?>
						<a class="close" data-dismiss="alert">×</a>

						<?php if (!empty($msgs)) : ?>
							<h4 class="alert-heading"><?php echo JText::_($type); ?></h4>
							<div>
								<?php foreach ($msgs as $msg) : ?>
									<p><?php echo $msg; ?></p>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>
				<?php endforeach; ?>
			</div>
		<?php endif; ?>
	</div>
<?php 
} else {
	// Joomla 4...
	$document  = Factory::getDocument();
	$msgOutput = '';
	$alert     = [
		CMSApplication::MSG_EMERGENCY => 'danger',
		CMSApplication::MSG_ALERT     => 'danger',
		CMSApplication::MSG_CRITICAL  => 'danger',
		CMSApplication::MSG_ERROR     => 'danger',
		CMSApplication::MSG_WARNING   => 'warning',
		CMSApplication::MSG_NOTICE    => 'info',
		CMSApplication::MSG_INFO      => 'info',
		CMSApplication::MSG_DEBUG     => 'info',
		'message'                     => 'success'
	];

	// Load JavaScript message titles
	Text::script('ERROR');
	Text::script('MESSAGE');
	Text::script('NOTICE');
	Text::script('WARNING');

	// Load other Javascript message strings
	Text::script('JCLOSE');
	Text::script('JOK');
	Text::script('JOPEN');

	// Alerts progressive enhancement
	$document->getWebAssetManager()
		->useStyle('webcomponent.joomla-alert')
		->useScript('messages');

	if (is_array($msgList) && !empty($msgList))
	{
		$messages = [];

		foreach ($msgList as $type => $msgs)
		{
			// JS loaded messages
			$messages[] = [$alert[$type] ?? $type => $msgs];
			// Noscript fallback
			if (!empty($msgs)) {
				$msgOutput .= '<div class="alert alert-' . ($alert[$type] ?? $type) . '">';
				foreach ($msgs as $msg) :
					$msgOutput .= $msg;
				endforeach;
				$msgOutput .= '</div>';
			}
		}

		if ($msgOutput !== '')
		{
			$msgOutput = '<noscript>' . $msgOutput . '</noscript>';
		}

	$document->addScriptOptions('joomla.messages', $messages);
} ?>
	<div id="system-message-container" aria-live="polite"><?php echo $msgOutput; ?></div>
<?php } ?>
