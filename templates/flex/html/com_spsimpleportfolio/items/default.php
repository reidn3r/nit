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

$config = Factory::getConfig();
$sitename = $config->get('sitename');

//opengraph
$doc->addCustomTag('<meta property="og:url" content="'. Uri::current() . '" />');
$doc->addCustomTag('<meta property="og:site_name" content="'. htmlspecialchars($sitename) .'" />');
$doc->addCustomTag('<meta property="og:type" content="page" />');
if ($this->params->get('page_heading')) {
$doc->addCustomTag('<meta property="og:title" content="'. $this->params->get('page_heading') .'" />');
}
// Twitter
$doc->addCustomTag('<meta name="twitter:card" content="summary" />');
$doc->addCustomTag('<meta name="twitter:site" content="'. htmlspecialchars($sitename) .'" />');
$doc->addCustomTag('<meta name="twitter:title" content="'. $this->params->get('page_heading') .'" />');

$layout_type = $this->params->get('layout_type', 'default');
$column_bg = $this->params->get('column_bg');
$show_view_button = $this->params->get('show_view_button', 1);
$show_zoom_button = $this->params->get('show_zoom_button', 1);
$show_tags = $this->params->get('show_tags', 1);
$show_filter = $this->params->get('show_filter');
$filter_divider = $this->params->get('filter_divider');
$filter_style = $this->params->get('filter_style');
$show_all_txt = $this->params->get('show_all_txt');
$filter_margin = $this->params->get('filter_margin');
$video_width = $this->params->get('video_width');
$video_height = $this->params->get('video_height');

// Sizes
$square = strtolower($this->params->get('square', '600x600'));
$rectangle = strtolower($this->params->get('rectangle', '600x400'));
$tower = strtolower($this->params->get('tower', '600x800'));
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

if( $this->params->get('show_page_heading') && $this->params->get( 'page_heading' ) ) {
	echo "<h1 class='page-header'>" . $this->params->get( 'page_heading' ) . "</h1>";
}

$showbtns = '';

$filter_divider != '' ? $filter_divider = '<span class="simple-divider">'.$filter_divider.'</span>' : $filter_divider = '';
$filter_style == 'simple' ? $simple_style = $filter_divider : $simple_style = '';

if($show_zoom_button==0 && $show_view_button==0 && $layout_type=='default') { 
   $showbtns = '.sp-simpleportfolio .sp-simpleportfolio-item .sp-simpleportfolio-overlay-wrapper .sp-simpleportfolio-overlay {background:transparent}';
}

$addstyle = 'body.rtl .sp-simpleportfolio .sp-simpleportfolio-filter > ul > li:first-child {'
	. 'margin-left:'.$filter_margin.'px;margin-right:0;'
	. '}'
	. $showbtns
	; 
$doc->addStyleDeclaration( $addstyle );

//random ID number to avoid conflict if there is more then one galleries on the same page
$randomid = rand(1,1000);

$i = 0;
?>
<div id="sp-simpleportfolio-<?php echo $this->item->spsimpleportfolio_item_id; ?>" class="sp-simpleportfolio sp-simpleportfolio-view-items layout-<?php echo $this->layout_type; ?>">
	<?php if($this->params->get('show_filter', 1)) { ?>
		<div class="sp-simpleportfolio-filter">
			<ul<?php echo ($this->params->get('filter_style') == 'simple') ? ' class="simple"' : ' class="flex"'; ?>>
				<li class="active<?php if($this->params->get('filter_margin') == 0) { ?> no-margin<?php } ?>" data-group="all"><a href="#"><?php if($this->params->get('show_all_txt') != '') { echo $show_all_txt;
                 } else { echo Text::_('COM_SPSIMPLEPORTFOLIO_SHOW_ALL');} ?></a></li>
				<?php foreach ($this->tagList as $filter) { ?><li<?php echo ($this->params->get('filter_margin') == 0) ? ' class="no-margin" ' : ' style="margin-left:'.$filter_margin.'px;" '; ?>data-group="<?php echo $filter->alias; ?>"><?php echo $simple_style; ?><a href="#"><?php echo $filter->title; ?></a></li>
				<?php } ?>
			</ul>
		</div>
	<?php } 
	
	$video_width != '' ? $video_width : $video_width = '700';
	$video_height != '' ? $video_height : $video_height = '400';
	$column_bg != '' ? $column_background = ' style="background-color:'.$column_bg.'"' : $column_background = '';
	
		//Videos
		foreach ($this->items as $key => $this->item) {

			if($this->item->video) {
				$video = parse_url($this->item->video);

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

				echo '<iframe class="sp-simpleportfolio-lightbox" src="'. $video_src .'" width="'. $video_width .'" height="'. $video_height .'" id="sp-simpleportfolio-video'.$this->item->spsimpleportfolio_item_id.'" style="border:none;" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
			}
		}
	?>
	<div class="sp-simpleportfolio-items sp-simpleportfolio-columns-<?php echo $this->params->get('columns', 3); ?>">
		<?php foreach ($this->items as $this->item) { ?>
			<div class="sp-simpleportfolio-item" data-groups='[<?php echo $this->item->groups; ?>]'>
				<div class="sp-simpleportfolio-overlay-wrapper clearfix">
					<?php if($this->item->video) { ?>
						<span class="sp-simpleportfolio-icon-video"></span>
					<?php } 
					if($this->item->thumbnail) { ?>
						<img class="sp-simpleportfolio-img" src="<?php echo $this->item->thumb; ?>" alt="<?php echo $this->item->title; ?>">
					<?php } else {
						$thumb_type = $this->params->get('thumbnail_type', 'masonry');
						if($thumb_type == 'masonry') { ?><img class="sp-simpleportfolio-img" src="<?php echo Uri::base(true) . '/images/spsimpleportfolio/' . $this->item->alias . '/' . File::stripExt(basename($this->item->image)) . '_' . $sizes[$i] . '.' . File::getExt($this->item->image); ?>" alt="<?php echo $this->item->title; ?>">
						<?php } else if($thumb_type == 'rectangular') { ?><img class="sp-simpleportfolio-img" src="<?php echo Uri::base(true) . '/images/spsimpleportfolio/' . $this->item->alias . '/' . File::stripExt(basename($this->item->image)) . '_'. $rectangle .'.' . File::getExt($this->item->image); ?>" alt="<?php echo $this->item->title; ?>">
						<?php } else if($thumb_type == 'tower') { ?><img class="sp-simpleportfolio-img" src="<?php echo Uri::base(true) . '/images/spsimpleportfolio/' . $this->item->alias . '/' . File::stripExt(basename($this->item->image)) . '_'. $tower .'.' . File::getExt($this->item->image) ?>" alt="<?php echo $this->item->title; ?>">
						<?php } else { ?><img class="sp-simpleportfolio-img" src="<?php echo Uri::base(true) . '/images/spsimpleportfolio/' . $this->item->alias . '/' . File::stripExt(basename($this->item->image)) . '_'. $square .'.' . File::getExt($this->item->image); ?>" alt="<?php echo $this->item->title; ?>">
						<?php } 
					}
					// Popup Image (default = "original image", square, rectangle, tower)
                    $popup_image = $this->params->get('popup_image', 'default');
                    if($popup_image == 'quare') {
                        $this->item->popup_img_url = Uri::base(true) . '/images/spsimpleportfolio/' . $this->item->alias . '/' . File::stripExt(File::getName($this->item->image)) . '_'. $square .'.' . File::getExt($this->item->image);
                    } else if($popup_image == 'rectangle') {
                        $this->item->popup_img_url = Uri::base(true) . '/images/spsimpleportfolio/' . $this->item->alias . '/' . File::stripExt(File::getName($this->item->image)) . '_'. $rectangle .'.' . File::getExt($this->item->image);
                    } else if($popup_image == 'tower') {
                        $this->item->popup_img_url = Uri::base(true) . '/images/spsimpleportfolio/' . $this->item->alias . '/' . File::stripExt(File::getName($this->item->image)) . '_'. $tower .'.' . File::getExt($this->item->image);
                    } else {
                        $this->item->popup_img_url = Uri::base() . $this->item->image;
                    } 
					$i++;
					if($i==11) {
						$i = 0;
					}
					?><div class="sp-simpleportfolio-overlay">
						<div class="sp-vertical-middle">
							<div>
								<div class="sp-simpleportfolio-btns">
									<?php if($show_view_button!=0) {
                                        if( $this->item->video ) {
											 if($show_zoom_button!=0) { ?><a class="btn-zoom gallery-<?php echo $randomid; ?>" href="#" data-featherlight="#sp-simpleportfolio-video<?php echo $this->item->spsimpleportfolio_item_id; ?>"><?php echo Text::_('COM_SPSIMPLEPORTFOLIO_WATCH'); ?></a><a class="btn-view" href="<?php echo $this->item->url; ?>"><?php echo Text::_('COM_SPSIMPLEPORTFOLIO_VIEW'); ?></a>       
                                                <?php } else { ?><a class="btn-view-only" href="<?php echo $this->item->url; ?>"><i class="fas fa-link"></i></a>
                                             <?php }        
                                         } else { 
                                            if($show_zoom_button!=0) { ?><a class="btn-zoom gallery-<?php echo $randomid; ?>" href="<?php echo $this->item->popup_img_url; ?>" data-featherlight="image"><?php echo Text::_('COM_SPSIMPLEPORTFOLIO_ZOOM'); ?></a>
                                            <a class="btn-view" href="<?php echo $this->item->url; ?>"><?php echo Text::_('COM_SPSIMPLEPORTFOLIO_VIEW'); ?></a>       
                                         <?php } else { ?><a class="btn-view-only" href="<?php echo $this->item->url; ?>"><i class="fas fa-link"></i></a>
                                         <?php }
                                        	} 
										} else { 
											if($show_zoom_button!=0) {
                                            if( $this->item->video ) { ?><a class="btn-zoom-icon gallery-<?php echo $randomid; ?>" href="#" data-featherlight="#sp-simpleportfolio-video<?php echo $this->item->spsimpleportfolio_item_id; ?>"><i class="fas fa-search"></i></a>
                                        <?php } else { ?><a class="btn-zoom-icon gallery-<?php echo $randomid; ?>" href="<?php echo $this->item->popup_img_url; ?>" data-featherlight="image"><i class="fas fa-search"></i></a>
                                        <?php } 
										} 
									} ?></div>
								<?php if($layout_type!='default') { ?><h3 class="sp-simpleportfolio-title">
									<a href="<?php echo $this->item->url; ?>"><?php echo $this->item->title; ?></a>
									</h3>
									<?php if($show_tags!=0) { ?><div class="sp-simpleportfolio-tags">[ <?php echo implode(', ', $this->item->tags); ?> ]</div>
                                    <?php } ?>
								<?php } ?>
							</div>
						</div>
					</div>
				</div>
				<?php if($layout_type=='default') { ?>
					<div<?php echo $column_background; ?> class="sp-simpleportfolio-info">
						<h3 class="sp-simpleportfolio-title">
							<a href="<?php echo $this->item->url; ?>"><?php echo $this->item->title; ?></a>
						</h3>
                        <?php if($show_tags!=0) { ?>
                            <div class="sp-simpleportfolio-tags"><?php echo (count($this->item->tags) > 1) ? '<i class="fas fa-tags"></i>' : '<i class="fas fa-tag"></i>'; ?><?php echo implode(', ', $this->item->tags); ?></div>
                        <?php } ?>
					</div>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
	<?php if ($this->pagination->pagesTotal > 1) { ?>
	<div style="margin:25px auto 15px;" class="pagination clearfix">
		<?php echo $this->pagination->getPagesLinks(); ?>
	</div>
	<?php } ?>
</div>
<script type="text/javascript">function r(f){/in/.test(document.readyState)?setTimeout(r,9,f):f()}r(function(){jQuery('.gallery-<?php echo $randomid; ?>').featherlightGallery({previousIcon:'<i class="arrow-previous-thin"></i>',nextIcon:'<i class="arrow-next-thin"></i>'})});</script>
