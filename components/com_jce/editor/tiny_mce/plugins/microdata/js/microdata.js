/* jce - 2.9.39 | 2023-07-25 | https://www.joomlacontenteditor.net | Copyright (C) 2006 - 2023 Ryan Demmer. All rights reserved | GNU/GPL Version 2 or later - http://www.gnu.org/licenses/gpl-2.0.html */
var MicrodataDialog={settings:{},init:function(){function callback(values,parent){function getSubClassOf(cls,values){for(var i=values.length;i--;)if(values[i].resource===cls)return values[i].subClassOf;return!1}if($("#itemtype").prop("disabled",!1),!values)return!1;if($.each(values,function(i,value){if(!filter.length||$.inArray(value.resource,filter)!==-1){for(var subClassOf=value.subClassOf,ix=0;subClassOf&&subClassOf.length;)$.each(subClassOf,function(x,cls){subClassOf=getSubClassOf(cls,values),subClassOf&&subClassOf.length&&ix++});var opt=$('<option title="'+ed.dom.encode(value.comment)+'" value="'+value.resource+'">'+value.resource+"</option>").addClass(function(){return!(ix>0)&&"microdata-itemtype"}).addClass("microdata-itemtype-"+ix);$("#itemtype").each(function(){$(this.list).append(opt)})}}),parent){var itemtype=ed.dom.getAttrib(parent,"data-microdata-itemtype");itemtype=itemtype.substring(itemtype.lastIndexOf("/")+1),$("#itemtype").val(itemtype).trigger("change")}$("#itemtype").trigger("datalist:loading").trigger("datalist:update")}tinyMCEPopup.restoreSelection();var data,self=this,ed=tinyMCEPopup.editor,se=ed.selection,n=se.getNode(),update=!1;$("#insert").on("click",function(e){self.insert(),e.preventDefault()}),Wf.init(),$("input, select","#microdata_tab").prop("disabled",!0);var p=ed.dom.getParent(n,"[data-microdata-itemtype],[itemtype]");if(p&&(update=!0,$(".uk-button-text","#insert").text(tinyMCEPopup.getLang("update","Update",!0))),$(".itemtype-options").toggle(update),$("#itemtype-new, #itemtype-replace").prop("disabled",!update),window.sessionStorage){var schema=sessionStorage.getItem("wf-microdata-schema");schema&&(data=JSON.parse(schema),Array.isArray(data)||(data=null))}var filter=ed.getParam("microdata_filter",[]);$("#itemtype").on("change",function(){function getClassFromType(type){var match=!1;return $.each(data,function(i,item){if(type===item.resource)return match=item,!1}),match}if(""===$(this).val())return void $("#itemprop, #itemid","#microdata_tab").prop("disabled",!0);$("#itemprop, #itemid","#microdata_tab").prop("disabled",!1);var props={},type=$(this).val();if(data){var cls=getClassFromType(type);if(cls){props[type]=cls.domainIncludes;for(var subClassOf=cls.subClassOf;subClassOf&&subClassOf.length;)$.each(subClassOf,function(i,key){cls=getClassFromType(key),props[key]=cls.domainIncludes,subClassOf=cls.subClassOf})}$("#itemprop").each(function(){$(this.list).empty()}).trigger("datalist:clear"),$.each(props,function(key,val){if(val.length){var $optgroup=$('<optgroup label="'+key+'" />');$.each(val,function(i,opt){var option=new Option(opt.label,opt.label);$(option).attr("title",ed.dom.encode(opt.comment)),$optgroup.append(option)}),$("#itemprop").each(function(){$(this.list).append($optgroup)})}})}update&&($("#itemprop").val(ed.dom.getAttrib(n,"data-microdata-itemprop")),$("#itemid").val(ed.dom.getAttrib(n,"data-microdata-itemid")).trigger("change")),$("#itemprop").trigger("datalist:update")}),$("#itemtype").trigger("datalist:loading"),data?callback(data,p):Wf.JSON.request("getSchema",[],function(o){return o&&"string"!=typeof o||(o={error:"Unable to load schema"}),o.error?(Wf.Modal.alert(o.error),void callback(!1)):(callback(o,p),data=o,void(window.sessionStorage&&sessionStorage.setItem("wf-microdata-schema",JSON.stringify(o))))}),window.focus()},insert:function(){var ed=tinyMCEPopup.editor,se=ed.selection,n=se.getNode();tinyMCEPopup.restoreSelection();var isTextSelection=se.getContent()===se.getContent({format:"text"}),p=ed.dom.getParent(n,"[data-microdata-itemtype]"),itemtype=$("#itemtype").val();if(itemtype){var args={"data-microdata-itemprop":itemtype?$("#itemprop").val():null,"data-microdata-itemid":itemtype?$("#itemid").val():null},blocks=[];if($.each(ed.schema.getBlockElements(),function(k,v){return!!/\W/.test(k)||void blocks.push(k.toUpperCase())}),(!p||$("#itemtype-new:visible").is(":checked"))&&(p=ed.dom.getParent(n,blocks.join(",")),!p||ed.dom.is(p,"[data-microdata-itemtype]"))){var fmt=ed.schema.isValidChild(p,"div")?"div":"microdata";ed.formatter.apply(fmt,{id:"__mce_tmp"}),p=ed.dom.get("__mce_tmp"),ed.dom.setAttrib(p,"id",null),p.innerHTML="<span>"+p.innerHTML||"</span>",n=p.firstChild,isTextSelection=!1}isTextSelection?itemtype?ed.formatter.apply("microdata",args):(ed.formatter.remove("microdata-remove"),p&&ed.dom.setAttribs(p,{"data-microdata-itemscope":null,"data-microdata-itemtype":null})):ed.dom.setAttribs(n,args),ed.dom.setAttribs(p,{"data-microdata-itemscope":itemtype?"itemscope":null,"data-microdata-itemtype":"https://schema.org/"+itemtype})}else ed.formatter.remove("microdata-remove"),p&&ed.dom.setAttribs(p,{"data-microdata-itemscope":null,"data-microdata-itemtype":null});ed.undoManager.add(),tinyMCEPopup.close()}};tinyMCEPopup.onInit.add(MicrodataDialog.init,MicrodataDialog);