<?php
/**
 * Flex @package Helix3 Framework
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\HTML\HTMLHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\Router\Route;

HTMLHelper::_('behavior.keepalive');
HTMLHelper::_('behavior.formvalidator');

if (JVERSION < 4) {
	// Joomla 3...
	// to load in our own version of registration.xml
	$this->form->loadFile( dirname(__FILE__) . '/' . "registration_J3.xml");
?>
<div class="row-fluid registration-wrapper">
<i class="pe pe-7s-users d-none d-lg-block"></i>
	<div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
		<div class="registration<?php echo $this->pageclass_sfx?>">
			<?php if ($this->params->get('show_page_heading')) : ?>
				<h1><?php echo $this->escape($this->params->get('page_heading')); ?></h1>
			<?php endif; ?>
            <form id="member-registration" action="<?php echo Route::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="form-validate" enctype="multipart/form-data">
			<?php // Iterate through the form fieldsets and display each one. ?>
            <?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
                <?php $fields = $this->form->getFieldset($fieldset->name); ?>
                <?php if (count($fields)) : ?>
                <fieldset class="clearfix">
					 <?php if (isset($fieldset->label)) : ?>
							<h2 class="title">
							<svg style="margin:-7px 0 0;vertical-align:middle;" width="1.22em" height="1.22em" viewBox="0 0 16 16" class="bi bi-person major_color-lighten-20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M13 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM3.022 13h9.956a.274.274 0 0 0 .014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 0 0 .022.004zm9.974.056v-.002.002zM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/></svg>
							<?php echo Text::_($fieldset->label); ?>
							</h2>
                    <?php endif; ?>
                    <div class="fieldset_name">
                        <div class="group-control">
                        <?php echo $this->form->renderFieldset($fieldset->name); ?>
                        </div>
                    </div>  
                </fieldset>    
                <?php endif; ?>
            <?php endforeach; ?>
            <div class="form-group clearfix my-3">
				<button type="submit" class="com-users-registration__register btn sppb-btn-3d btn-success validate px-5">
					<?php echo Text::_('JREGISTER'); ?>
				</button>
				<a class="btn sppb-btn-3d btn-danger mx-1 px-5" href="<?php echo Route::_(''); ?>" title="<?php echo Text::_('JCANCEL'); ?>">
					<?php echo Text::_('JCANCEL'); ?>
				</a>
                <input type="hidden" name="option" value="com_users" />
                <input type="hidden" name="task" value="registration.register" />
            </div>
            <?php echo HTMLHelper::_('form.token'); ?>
        </form>
		</div>
	</div>
</div>
<?php } else { 
	// to load in our own version of registration.xml
	$this->form->loadFile( dirname(__FILE__) . '/' . "registration_J4.xml");
?>
<div class="com-users-registration row registration-wrapper">
	<div class="col-12 col-md-8 offset-md-2 col-lg-6 offset-lg-3">
		<div class="page-header registration<?php echo $this->pageclass_sfx?>">
			<form id="member-registration" action="<?php echo Route::_('index.php?option=com_users&task=registration.register'); ?>" method="post" class="com-users-registration__form form-validate" enctype="multipart/form-data">
			<?php // Iterate through the form fieldsets and display each one. ?>
            <?php foreach ($this->form->getFieldsets() as $fieldset) : ?>
                <?php $fields = $this->form->getFieldset($fieldset->name); ?>
                <?php if (count($fields)) : ?>
                <fieldset>
                    <?php // If the fieldset has a label set, display it as the legend. ?>
                    <?php if (isset($fieldset->label)) : ?>
							<h2 class="title">
							<svg style="margin:-7px 0 0;vertical-align:middle;" width="1.22em" height="1.22em" viewBox="0 0 16 16" class="bi bi-person major_color-lighten-20" fill="currentColor" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M13 14s1 0 1-1-1-4-6-4-6 3-6 4 1 1 1 1h10zm-9.995-.944v-.002.002zM3.022 13h9.956a.274.274 0 0 0 .014-.002l.008-.002c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664a1.05 1.05 0 0 0 .022.004zm9.974.056v-.002.002zM8 7a2 2 0 1 0 0-4 2 2 0 0 0 0 4zm3-2a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/></svg>
							<?php echo Text::_($fieldset->label); ?>
							</h2>
                    <?php endif; ?>
                    <div class="fieldset_name">         
                        <?php echo $this->form->renderFieldset($fieldset->name); ?>
                    </div>
                </fieldset>    
                <?php endif; ?>
            <?php endforeach; ?>
			<div class="com-users-registration__submit control-group">
				<div class="controls">
					<button type="submit" class="com-users-registration__register btn sppb-btn-3d btn-success validate px-5">
						<?php echo Text::_('JREGISTER'); ?>
					</button>
					<a class="btn sppb-btn-3d btn-danger mx-1 px-5" href="<?php echo Route::_(''); ?>" title="<?php echo Text::_('JCANCEL'); ?>">
						<?php echo Text::_('JCANCEL'); ?>
					</a>
				</div>
                <input type="hidden" name="option" value="com_users" />
                <input type="hidden" name="task" value="registration.register" />
            </div>
			<?php echo HTMLHelper::_('form.token'); ?>
        </form>
		</div>
	</div>
</div>
<?php } ?>
