/* jce - 2.9.39 | 2023-07-25 | https://www.joomlacontenteditor.net | Copyright (C) 2006 - 2023 Ryan Demmer. All rights reserved | GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html */
!function($){function getRatio(o){return o.width/o.height}var oldSetOption=$.ui.resizable.prototype._setOption;$.ui.resizable.prototype._setOption=function(key,value){oldSetOption.apply(this,arguments),"aspectRatio"===key&&(this._aspectRatio=!!value)},$.widget("ui.resize",{options:{ratio:4/3,width:800,height:600},_init:function(){var self=this;this.width=$(this.element).width()||$(this.element).attr("width"),this.height=$(this.element).height()||$(this.element).attr("height");var pos={left:$(this.element).parent().innerWidth()/2-this.width/2,top:$(this.element).parent().innerHeight()/2-this.height/2},ratio=this.getRatio();this.element;$('<div id="resize-container" class="transform-widget"/>').appendTo($(this.element).parent()).append(this.element).css(pos).resizable({handles:"all",aspectRatio:getRatio(this.options),containment:"parent",start:function(){self._trigger("start",null)},resize:function(event,ui){var n=ui.element[0],w=Math.round(n.clientWidth),h=Math.round(n.clientHeight);$(self.element).css({width:w,height:h}),self._trigger("resize",null,{width:Math.round(ratio.x*w,1),height:Math.round(ratio.x*h,1)})},stop:function(event,ui){self._trigger("stop",null,ui.size)}}).draggable({containment:"parent"}),$(this.element).css({top:"",left:""}),$.support.cssFloat||$("#resize-container").attr("unselectable","on"),$("div.uk-resizable-handle.uk-resizable-se","#resize-container").removeClass("uk-icon uk-icon-gripsmall-diagonal-se")},_getPosition:function(width,height){var $parent=$("#resize-container").parent(),width=width||this.width,height=height||this.height;return{left:($parent.outerWidth()-width)/2,top:($parent.outerHeight()-height)/2}},setSize:function(w,h){var self=this,$parent=$("#resize-container").parent(),pw=(this._getPosition(w,h),$parent.outerWidth()),ph=$parent.outerHeight(),ratio=this.getRatio();w=Math.round(w/ratio.x,1),h=Math.round(h/ratio.y,1),$(this.element).animate({width:w,height:h},{step:function(now,fx){"width"==fx.prop&&$("#resize-container").css("left",(pw-now)/2),"height"==fx.prop&&$("#resize-container").css("top",(ph-now)/2),$("#resize-container").css(fx.prop,now)},complete:function(){self._trigger("stop",null)}})},setConstrain:function(s){var ratio=s;s&&(ratio=getRatio(s)),this.setRatio(ratio)},getRatio:function(){return{x:this.options.width/this.width,y:this.options.height/this.height}},setRatio:function(ratio){if("undefined"==$.type(ratio)){var r=this.getRatio();ratio=r.x/r.y}$("#resize-container").data("uiResizable")?$("#resize-container").resizable("option","aspectRatio",ratio):this.options.ratio=ratio},reset:function(){var pos=this._getPosition();$("#resize-container").css({top:pos.top,left:pos.left,width:"",height:""}),$(this.element).css({top:""}),this.setRatio(getRatio(this.options))},remove:function(){$("#resize-container").parent().append(this.element),$("#resize-container").remove(),this.destroy()},destroy:function(){$.Widget.prototype.destroy.apply(this,arguments)}}),$.widget("ui.rotate",{options:{},_init:function(){var $parent=$(this.element).parent();$(this.element).wrap('<div id="rotate-container"/>'),$("#rotate-container").css({top:($parent.height()-$(this.element).height())/2,left:($parent.width()-$(this.element).width())/2}),$.support.cssFloat||$("#rotate-container").attr("unselectable","on")},rotate:function(angle){var s;switch(angle){default:s="scaleY(1) scaleX(1)";break;case"0":case"90":case"-90":case"180":s="rotate("+angle+"deg)";break;case"vertical":s="scaleY(-1)";break;case"horizontal":s="scaleX(-1)";break;case"vertical|horizontal":s="scaleX(-1) scaleY(-1)"}$(this.element).animate({transform:s})},remove:function(){$(this.element).unwrap(),this.destroy()},destroy:function(){$.Widget.prototype.destroy.apply(this,arguments)}}),$.widget("ui.crop",{options:{ratio:4/3,width:800,height:600,selection:"",clone:null,handles:"all"},_init:function(){var self=this;this.width=$(this.element).width()||$(this.element).attr("width"),this.height=$(this.element).height()||$(this.element).attr("height");var $parent=$(this.element).parent(),top=$(this.element).css("top")||($parent.outerHeight()-this.height)/2;$(this.element).css({top:"",left:""});var $clone=this.options.clone?$(this.options.clone):$(this.element).clone();$clone.css("top",""),$('<div id="crop-container"></div>').appendTo($parent).append(this.element).append('<div id="crop-mask"/>').append('<div id="crop-window"/><div id="crop-widget" class="transform-widget"/>');var $crop=$("#crop-window"),$widget=$("#crop-widget");$crop.append($clone).css({width:this.width,height:this.height}),$widget.css({width:this.width,height:this.height}).resizable({handles:this.options.handles,aspectRatio:this.options.ratio,containment:"#crop-container",start:function(event,ui){self._trigger("start",null)},resize:function(event,ui){var n=ui.element[0],w=Math.round(n.clientWidth),h=Math.round(n.clientHeight);$clone.css({top:-n.offsetTop,left:-n.offsetLeft}),$crop.css({width:w,height:h,top:n.offsetTop,left:n.offsetLeft}),self._trigger("change",null,self.getArea())},stop:function(){self._trigger("stop",null,self.getArea())}}),$("#crop-window, #crop-widget").draggable({containment:"#crop-container",drag:function(event,ui){var top=ui.position.top,left=ui.position.left;$widget.css({top:top,left:left}),$crop.css({top:top,left:left}),$clone.css({top:-top,left:-left}),self._trigger("change",null,self.getArea())},stop:function(){self._trigger("stop",null,self.getArea())}}),$.support.cssFloat||$widget.attr("unselectable","on"),$("div.uk-resizable-handle.uk-resizable-se",$widget).removeClass("uk-icon uk-icon-gripsmall-diagonal-se"),$('<div id="crop-box"/>').css({width:this.width,height:this.height,top:top}).appendTo($parent).append($("#crop-container")),this.options.selection&&this.setArea(this.options.selection),$("#crop-widget").on("dblclick",function(){self.reset(),self._trigger("reset",null,self.getArea())})},setConstrain:function(s){var ratio=s;s&&(ratio=getRatio(s),this.setArea(s)),this.setRatio(ratio)},getRatio:function(){return{x:this.width/this.options.width,y:this.height/this.options.height}},setRatio:function(ratio){$("#crop-widget").resizable("option","aspectRatio",ratio)},setArea:function(o,update){var self=this,r=this.getRatio(),values={left:Math.round(o.x*r.x,1),top:Math.round(o.y*r.y,1),width:Math.round(o.width*r.x,1),height:Math.round(o.height*r.y,1)},data=this._calculateSelection(values,{width:this.width,height:this.height});for(var key in data)Number.isNaN(data[key])&&(data[key]=0);$("#crop-widget, #crop-window").animate(data,{step:function(now,fx){"crop-window"==fx.elem.id&&("left"!=fx.prop&&"top"!=fx.prop||$(fx.elem).children("img, canvas").css(fx.prop,0-now)),update&&self._trigger("change",null,{x:Math.round(data.left/r.x,1),y:Math.round(data.top/r.y,1),width:Math.round(data.width/r.x,1),height:Math.round(data.height/r.y,1)})},complete:function(){update&&self._trigger("stop",null,{x:Math.round(data.left/r.x,1),y:Math.round(data.top/r.y,1),width:Math.round(data.width/r.x,1),height:Math.round(data.height/r.y,1)})}})},getDimensions:function(){return{width:$("#crop-container").width(),height:$("#crop-container").height()}},_calculateSelection:function(dim,img){var x=parseInt(dim.left),y=parseInt(dim.top),w=parseInt(dim.width),h=parseInt(dim.height);return w=Math.min(w,this.options.width),h=Math.min(h,this.options.height),Number.isNaN(x)?w<=img.width&&(x=Math.floor((img.width-w)/2)):x+w>img.width&&(w=img.width-x),Number.isNaN(y)?h<=img.height&&(y=Math.floor((img.height-h)/2)):y+h>img.height&&(h=img.height-y),w=Math.min(w,Math.floor(img.width)),h=Math.min(h,Math.floor(img.height)),{left:Math.max(0,x),top:Math.max(0,y),width:w,height:h}},getArea:function(){var n=$("#crop-window").get(0),r=this.getRatio();return{x:Math.round(n.offsetLeft/r.x,1),y:Math.round(n.offsetTop/r.y,1),width:Math.round(n.clientWidth/r.x,1),height:Math.round(n.clientHeight/r.y,1)}},reset:function(){$("#crop-widget, #crop-window").css({width:this.width,height:this.height,left:0,top:0}),$("#crop-window").children().css({left:0,top:0});var ratio=this.width/this.height;this.setRatio(ratio)},remove:function(){var $parent=$("#crop-container").parent();$(this.element).css("top",$parent.css("top")).appendTo($parent.parent()),$parent.remove(),this.destroy()},destroy:function(){$.Widget.prototype.destroy.apply(this,arguments)}})}(jQuery);