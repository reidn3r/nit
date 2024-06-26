<?php
/**
 * @package RSPageBuilder!
 * @copyright (C) 2016 - 2021 www.rsjoomla.com
 * @license GPL, http://www.gnu.org/licenses/gpl-3.0.html
 */

// No direct access
defined ('_JEXEC') or die ('Restricted access');
?>

<form action="<?php echo JRoute::_('index.php?option=com_rspagebuilder&layout=edit&id='.(int)$this->item->id); ?>" method="post" name="adminForm" id="adminForm" class="form-validate">
    <?php echo JLayoutHelper::render('joomla.edit.title_alias', $this); ?>
    <div class="form-horizontal">
		<?php
		$fieldsets = $this->form->getFieldsets();
		
		reset($fieldsets);
		$first_tab	= key($fieldsets);
		$tab_type	= ($this->jversion >= 4) ? 'uitab' : 'bootstrap';
		
		foreach ($fieldsets as $key => $attr) {
			if ($key === $first_tab) {
				echo JHtml::_($tab_type . '.startTabSet', 'page', array('active' => $attr->name));
			}
			echo JHtml::_($tab_type . '.addTab', 'page', $attr->name, JText::_($attr->label, true));
		?>
		<div class="rspbld row-fluid<?php echo ($this->jversion > 4 ? ' color-scheme-mode' : ''); ?>">
			<div class="span12">
				<?php if ($this->jversion >= 4 && $this->item->bootstrap_version != 5) { ?>
				<div class="alert alert-primary alert-dismissible fade show" role="alert">
					<?php echo JText::_('COM_RSPAGEBUILDER_BOOTSTRAP_VERSION_UPDATE'); ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
				<?php } ?>
				
				<?php
				$fields	= $this->form->getFieldset($attr->name);
				
				foreach ($fields as $field) {
				?>
				<div class="control-group">
					<div class="control-label"><?php echo $field->label; ?></div>
					<div class="controls"><?php echo $field->input; ?></div>
				</div>
				<?php
				}
				if ($key === $first_tab) {
					echo $this->loadTemplate('rows');
					
					// Row settings modal
					
					echo JHtml::_(
						'bootstrap.renderModal',
						'modal-row-settings',
						array(
							'title'       	=> JText::_('COM_RSPAGEBUILDER_ROW_SETTINGS'),
							'backdrop'    	=> 'static',
							'keyboard'    	=> false,
							'closeButton'	=> true,
							'modalWidth'  	=> '40',
							'footer'		=> '<button class="btn btn-success" id="save-row-settings" onclick="javascript:void(0)">'.JText::_('COM_RSPAGEBUILDER_SAVE').'</button>
												<button class="btn btn-danger" id="cancel-row-settings" type="button" '.RSPageBuilderHelper::getBootstrapElement('data', 0, 'dismiss').'="modal">'.JText::_('COM_RSPAGEBUILDER_CANCEL').'</button>'
						),
						$this->loadTemplate('row_settings')
					);
					
					// Column settings modal
					
					echo JHtml::_(
						'bootstrap.renderModal',
						'modal-column-settings',
						array(
							'title'       	=> JText::_('COM_RSPAGEBUILDER_COLUMN_SETTINGS'),
							'backdrop'    	=> 'static',
							'keyboard'    	=> false,
							'closeButton'	=> true,
							'modalWidth'  	=> '40',
							'footer'		=> '<button class="btn btn-success" id="save-column-settings">'.JText::_('COM_RSPAGEBUILDER_SAVE').'</button>
												<button class="btn btn-danger" id="cancel-column-settings" type="button" '.RSPageBuilderHelper::getBootstrapElement('data', 0, 'dismiss').'="modal">'.JText::_('COM_RSPAGEBUILDER_CANCEL').'</button>'
						),
						$this->loadTemplate('column_settings')
					);
					
					// Elements list modal
					
					echo JHtml::_(
						'bootstrap.renderModal',
						'modal-elements-list',
						array(
							'title'       	=> JText::_('COM_RSPAGEBUILDER_ELEMENTS_LIST'),
							'backdrop'    	=> 'static',
							'keyboard'    	=> false,
							'closeButton'	=> true,
							'modalWidth'  	=> '60'
						),
						$this->loadTemplate('elements_list')
					);
					
					// Element settings modal
					
					echo JHtml::_(
						'bootstrap.renderModal',
						'modal-element-settings',
						array(
							'title'       	=> '',
							'backdrop'    	=> 'static',
							'keyboard'    	=> false,
							'closeButton'	=> true,
							'modalWidth'  	=> '80',
							'footer'		=> '<button class="btn btn-success" id="save-element-settings">'.JText::_('COM_RSPAGEBUILDER_SAVE').'</button>
												<button class="btn btn-danger" id="cancel-element-settings" type="button" '.RSPageBuilderHelper::getBootstrapElement('data', 0, 'dismiss').'="modal">'.JText::_('COM_RSPAGEBUILDER_CANCEL').'</button>'
						),
						$this->loadTemplate('element_settings')
					);
					
					// Element view HTML modal
					
					echo JHtml::_(
						'bootstrap.renderModal',
						'modal-element-view-html',
						array(
							'title'       	=> '',
							'backdrop'    	=> 'static',
							'keyboard'    	=> false,
							'closeButton'	=> true,
							'modalWidth'  	=> '40',
							'footer'		=> '<button class="btn btn-danger" id="cancel-element-view-html" type="button" '.RSPageBuilderHelper::getBootstrapElement('data', 0, 'dismiss').'="modal">'.JText::_('COM_RSPAGEBUILDER_CANCEL').'</button>'
						),
						'<textarea onclick="this.focus();this.select()" readonly="readonly"></textarea>'
					);
					
					// Upload image modal
					
					if ($this->jversion >= 4) {
						echo JHtml::_(
							'bootstrap.renderModal',
							'modal-upload-image',
							array(
								'title'       	=> JText::_('JLIB_FORM_CHANGE_IMAGE'),
								'backdrop'    	=> 'static',
								'keyboard'    	=> false,
								'closeButton'	=> true,
								'modalWidth'  	=> '60',
								'footer'		=> '<button class="btn btn-success media-save">'.JText::_('COM_RSPAGEBUILDER_SAVE').'</button>
													<button class="btn btn-danger media-close" type="button">'.JText::_('COM_RSPAGEBUILDER_CLOSE').'</button>'
							)
						);
					} else {
						echo JHtml::_(
							'bootstrap.renderModal',
							'modal-upload-image',
							array(
								'title'       	=> JText::_('JLIB_FORM_CHANGE_IMAGE'),
								'backdrop'    	=> 'static',
								'keyboard'    	=> false,
								'closeButton'	=> true,
								'modalWidth'  	=> '60'
							)
						);
					}
					
					echo $this->loadTemplate('settings');
				}
				?>
			</div>
		</div>
		<?php
			echo JHtml::_($tab_type . '.endTab');
		}
        ?>
    </div>
    <input type="hidden" name="task" value="page.edit" />
    <?php echo JHtml::_('form.token'); ?>
</form>