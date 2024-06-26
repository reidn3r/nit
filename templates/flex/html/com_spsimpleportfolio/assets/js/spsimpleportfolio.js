/**
 * @package SP Simple Portfolio for Flex (Dec 2022)
 * Fixed for J4 and added imagesLoaded script
 */
jQuery((function(e){var i=e(".sp-simpleportfolio-items"),s=i.find(".shuffle__sizer");i.imagesLoaded((function(){i.shuffle({itemSelector:".sp-simpleportfolio-item",speed:600,easing:"cubic-bezier(0.635, 0.010, 0.355, 1.000)",sequentialFadeDelay:150,sizer:s}),e(".sp-simpleportfolio-filter li a").on("click",(function(i){i.preventDefault();var s=e(this),l=e(this).parent();l.hasClass("active")||(s.closest("ul").children().removeClass("active"),s.parent().addClass("active"),s.closest(".sp-simpleportfolio").children(".sp-simpleportfolio-items").shuffle("shuffle",l.data("group")))}))}))}));