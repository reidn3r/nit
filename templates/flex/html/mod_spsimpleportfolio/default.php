<?php
/**
 * Flex @package Helix Framework
 * Template Name - Flex
 * @author Aplikko http://www.aplikko.com
 * @copyright Copyright (c) 2022 Aplikko
 * @license http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 or later
*/

defined('_JEXEC') or die;

use Joomla\CMS\Factory;
use Joomla\CMS\Uri\Uri;
use Joomla\CMS\Filesystem\File;
use Joomla\CMS\Component\ComponentHelper;
use Joomla\CMS\Language\Text;
use Joomla\CMS\HTML\HTMLHelper;


//Load the method jquery script.
HTMLHelper::_('jquery.framework');
$doc = Factory::getDocument();

//First unset default files
unset($doc->_styleSheets[ Uri::root(true) . '/components/com_spsimpleportfolio/assets/css/featherlight.min.css' ]);
unset($doc->_styleSheets[ Uri::root(true) . '/components/com_spsimpleportfolio/assets/css/spsimpleportfolio.css' ]);
unset($doc->_scripts[ Uri::root(true) . '/components/com_spsimpleportfolio/assets/js/jquery.shuffle.modernizr.min.js' ]);
unset($doc->_scripts[ Uri::root(true) . '/components/com_spsimpleportfolio/assets/js/featherlight.min.js' ]);
unset($doc->_scripts[ Uri::root(true) . '/components/com_spsimpleportfolio/assets/js/spsimpleportfolio.js' ]);


//Add updated js and css files
$doc->addStylesheet( Uri::root(true) . '/templates/flex/html/com_spsimpleportfolio/assets/css/featherlight.css' );
$doc->addStylesheet( Uri::root(true) . '/templates/flex/html/com_spsimpleportfolio/assets/css/featherlight.gallery.css' );
$doc->addStylesheet( Uri::root(true) . '/templates/flex/html/com_spsimpleportfolio/assets/css/spsimpleportfolio.css' );
$doc->addScript( Uri::root(true) . '/templates/flex/html/com_spsimpleportfolio/assets/js/jquery.shuffle.modernizr.min.js' );
$doc->addScript( Uri::root(true) . '/templates/flex/html/com_spsimpleportfolio/assets/js/spsimpleportfolio.js' );
$doc->addScript( Uri::root(true) . '/templates/flex/html/com_spsimpleportfolio/assets/js/featherlight.min.js' );
$doc->addScript( Uri::root(true) . '/templates/flex/html/com_spsimpleportfolio/assets/js/featherlight.gallery.min.js' );

$layout_type = $params->get('layout_type', 'default');
$column_bg = $params->get('column_bg');
$show_view_button = $params->get('show_view_button', 1);
$show_zoom_button = $params->get('show_zoom_button', 1);
$show_tags = $params->get('show_tags', 1);
$show_filter = $params->get('show_filter');
$filter_divider = $params->get('filter_divider');
$filter_style = $params->get('filter_style');
$show_all_txt = $params->get('show_all_txt');
$filter_margin = $params->get('filter_margin');
$video_width = $params->get('video_width');
$video_height = $params->get('video_height');

//Params
$square = strtolower( $params->get('square', '600x600') );
$rectangle = strtolower( $params->get('rectangle', '600x400') );
$tower = strtolower( $params->get('tower', '600x800') );

$filter_divider != '' ? $filter_divider = '<span class="simple-divider">'.$filter_divider.'</span>' : '';
$filter_style == 'simple' ? $simple_style = $filter_divider : $simple_style = '';

$showbtns = '';
if($show_zoom_button==0 && $show_view_button==0 && $layout_type=='default') { 
   $showbtns = '.sp-simpleportfolio .sp-simpleportfolio-item .sp-simpleportfolio-overlay-wrapper .sp-simpleportfolio-overlay {background:transparent}';
}

$addstyle = 'body.rtl .sp-simpleportfolio .sp-simpleportfolio-filter > ul > li:first-child {'
	. 'margin-left:'.$filter_margin.'px;margin-right:0;'
	. '}'
	. $showbtns
	; 
$doc->addStyleDeclaration( $addstyle );

$i = 0;
//Sizes
$sizes = array(
	$rectangle,
	$tower,
	$square,

	$tower,
	$rectangle,
	$square,

	$square,
	$rectangle,
	$tower,

	$square,
	$tower,
	$rectangle
	);

?>
<div id="mod-sp-simpleportfolio-<?php echo $module->id; ?>" class="sp-simpleportfolio sp-simpleportfolio-view-items layout-<?php echo str_replace('_', '-', $layout_type); ?> <?php echo $moduleclass_sfx; ?>">
	
	<?php if($params->get('show_filter', 1)) { ?>
		<div class="sp-simpleportfolio-filter">
			<ul<?php echo ($params->get('filter_style') == 'simple') ? ' class="simple"' : ' class="flex"'; ?>>
				<li class="active<?php if($params->get('filter_margin') == 0) { ?> no-margin<?php } ?>" data-group="all"><a href="#"><?php if($params->get('show_all_txt') != '') { echo $show_all_txt;
                 } else { echo Text::_('MOD_SPSIMPLEPORTFOLIO_SHOW_ALL');} ?></a></li>
				<?php foreach ($tagList as $filter) { ?><li<?php echo ($params->get('filter_margin') == 0) ? ' class="no-margin" ' : ' style="margin-left:'.$filter_margin.'px;" '; ?>data-group="<?php echo $filter->alias; ?>"><?php echo $simple_style; ?><a href="#"><?php echo $filter->title; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	<?php } 
	
	$video_width != '' ? $video_width : $video_width = '700';
	$video_height != '' ? $video_height : $video_height = '400';
	$column_bg != '' ? $column_background = ' style="background-color:'.$column_bg.'"' : $column_background = '';
		//Videos
		foreach ($items as $item) {

			if($item->video) {
				$video = parse_url($item->video);

				switch($video['host']) {
					case 'youtu.be':
					$video_id 	= trim($video['path'],'/');
					$video_src 	= '//www.youtube.com/embed/' . $video_id;
					break;

					case 'www.youtube.com':
					case 'youtube.com':
					parse_str($video['query'], $query);
					$video_id 	= $query['v'];
					$video_src 	= '//www.youtube.com/embed/' . $video_id;
					break;

					case 'vimeo.com':
					case 'www.vimeo.com':
					$video_id 	= trim($video['path'],'/');
					$video_src 	= "//player.vimeo.com/video/" . $video_id;
				}
				echo '<iframe class="sp-simpleportfolio-lightbox" src="'. $video_src .'" width="'. $video_width .'" height="'. $video_height .'" id="sp-simpleportfolio-video'.$item->spsimpleportfolio_item_id.'" style="border:none;" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
			}
		}
	?>
	<div class="sp-simpleportfolio-items sp-simpleportfolio-columns-<?php echo $params->get('columns', 3); ?>">
		<?php foreach ($items as $item) { ?>
			<div<?php echo $column_background; ?> class="sp-simpleportfolio-item" data-groups='[<?php echo $item->groups; ?>]'>
				<?php //$item->url = JRoute::_('index.php?option=com_spsimpleportfolio&view=item&id='.$item->spsimpleportfolio_item_id.':'.$item->alias. ModSpsimpleportfolioHelper::getItemid()); ?>
				<div class="sp-simpleportfolio-overlay-wrapper clearfix">	
					<?php if($item->video) { ?>
						<span class="sp-simpleportfolio-icon-video"></span>
					<?php } 
					if($item->thumbnail) { ?>
                        <img class="sp-simpleportfolio-img" src="<?php echo $item->thumb; ?>" alt="<?php echo $item->title; ?>">
					<?php } else {
					if($params->get('thumbnail_type', 'masonry') == 'masonry') { ?>
						<img class="sp-simpleportfolio-img" src="<?php echo Uri::base(true) . '/images/spsimpleportfolio/' . $item->alias . '/' . File::stripExt(basename($item->image)) . '_' . $sizes[$i] . '.' . File::getExt($item->image); ?>" alt="<?php echo $item->title; ?>">
					<?php } else if($params->get('thumbnail_type', 'masonry') == 'rectangular') { ?>
						<img class="sp-simpleportfolio-img" src="<?php echo Uri::base(true) . '/images/spsimpleportfolio/' . $item->alias . '/' . File::stripExt(basename($item->image)) . '_'. $rectangle .'.' . File::getExt($item->image); ?>" alt="<?php echo $item->title; ?>">
					<?php } else { ?>
						<img class="sp-simpleportfolio-img" src="<?php echo Uri::base(true) . '/images/spsimpleportfolio/' . $item->alias . '/' . File::stripExt(basename($item->image)) . '_'. $square .'.' . File::getExt($item->image); ?>" alt="<?php echo $item->title; ?>">
					<?php } 
					}
										 
					$popup_image = $params->get('popup_image', 'default');
                    if($popup_image == 'quare') {
                        $item->popup_img_url = Uri::base(true) . '/images/spsimpleportfolio/' . $item->alias . '/' . File::stripExt(File::getName($item->image)) . '_'. $square .'.' . File::getExt($item->image);
                    } else if($popup_image == 'rectangle') {
                        $item->popup_img_url = Uri::base(true) . '/images/spsimpleportfolio/' . $item->alias . '/' . File::stripExt(File::getName($item->image)) . '_'. $rectangle .'.' . File::getExt($item->image);
                    } else if($popup_image == 'tower') {
                        $item->popup_img_url = Uri::base(true) . '/images/spsimpleportfolio/' . $item->alias . '/' . File::stripExt(File::getName($item->image)) . '_'. $tower .'.' . File::getExt($item->image);
                    } else {
                        $item->popup_img_url = Uri::base() . $item->image;
                    } 
					?>
					<div class="sp-simpleportfolio-overlay">
						<div class="sp-vertical-middle">
							<div>
								<div class="sp-simpleportfolio-btns">
									<?php if($show_view_button!=0) { ?> 
                                         <?php if( $item->video ) { ?>
											 <?php if($show_zoom_button!=0) { ?>
                                                <a class="btn-zoom gallery-<?php echo $module->id; ?>" href="#" data-featherlight="#sp-simpleportfolio-video<?php echo $item->spsimpleportfolio_item_id; ?>"><?php echo Text::_('MOD_SPSIMPLEPORTFOLIO_WATCH'); ?></a>
                                                <a class="btn-view" href="<?php echo $item->url; ?>"><?php echo Text::_('MOD_SPSIMPLEPORTFOLIO_VIEW'); ?></a>
                                                <?php } else { ?>
                                             <a class="btn-view-only" href="<?php echo $item->url; ?>"><i class="fas fa-link"></i></a>
                                             <?php } ?>    
                                        <?php } else { ?>
                                          <?php if($show_zoom_button!=0) { ?>
                                            <a class="btn-zoom gallery-<?php echo $module->id; ?>" href="<?php echo $item->popup_img_url; ?>" data-featherlight="image"><?php echo Text::_('MOD_SPSIMPLEPORTFOLIO_ZOOM'); ?></a>
                                            <a class="btn-view" href="<?php echo $item->url; ?>"><?php echo Text::_('MOD_SPSIMPLEPORTFOLIO_VIEW'); ?></a>  
                                           <?php } else { ?>
                                        	<a class="btn-view-only" href="<?php echo $item->url; ?>"><i class="fas fa-link"></i></a> 
                                        <?php } ?> 
                                       <?php } ?> 
                                     <?php } else { ?>
                                      <?php if($show_zoom_button!=0) { ?>
                                        <?php if( $item->video ) { ?>
                                            <a class="btn-zoom-icon gallery-<?php echo $module->id; ?>" href="#" data-featherlight="#sp-simpleportfolio-video<?php echo $item->spsimpleportfolio_item_id; ?>"><i class="fas fa-search"></i></a>
                                        <?php } else { ?>
                                          <a class="btn-zoom-icon gallery-<?php echo $module->id; ?>" href="<?php echo $item->popup_img_url; ?>" data-featherlight="image"><i class="fas fa-search"></i></a>
                                        <?php } ?>
                                      <?php } ?>
                                    <?php } ?>
								</div>
								<?php if($layout_type!='default') { ?>
								<h3 class="sp-simpleportfolio-title">
									<a href="<?php echo $item->url; ?>">
										<?php echo $item->title; ?>
									</a>
								</h3>
									<?php if($show_tags!=0) { ?>
                                        <div class="sp-simpleportfolio-tags">
                                            [ <?php echo implode(', ', $item->tags); ?> ]
                                        </div>
                                    <?php } ?>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<?php if($layout_type=='default') { ?>
					<div class="sp-simpleportfolio-info">
						<h3 class="sp-simpleportfolio-title">
							<a href="<?php echo $item->url; ?>">
								<?php echo $item->title; ?>
							</a>
						</h3>
						<?php if($show_tags!=0) { ?>
                            <div class="sp-simpleportfolio-tags">
                                <?php echo (count($item->tags) > 1) ? '<i class="fas fa-tags"></i>' : '<i class="fas fa-tag"></i>'; ?><?php echo implode(', ', $item->tags); ?>
                            </div>
                        <?php } ?>
					</div>
				<?php } ?>
			</div>
			<?php
			$i++;
			if($i==11) {
				$i = 0;
			}
			?>
		<?php } ?>
	</div>
</div>
<script type="text/javascript">function r(f){/in/.test(document.readyState)?setTimeout(r,9,f):f()}r(function(){jQuery('.sp-simpleportfolio-btns .gallery-<?php echo $module->id; ?>').featherlightGallery({previousIcon: '<i class="arrow-previous-thin"></i>',nextIcon: '<i class="arrow-next-thin"></i>'});});</script>
