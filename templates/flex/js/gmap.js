function initSPPageBuilderGMap(e){jQuery(".sppb-addon-gmap-canvas",e).each(function(t){var o=jQuery(this).attr("id"),r=Number(jQuery(this).attr("data-mapzoom")),a=jQuery(this).attr("data-infowindow"),l="true"===jQuery(this).attr("data-mousescroll"),i=jQuery(this).attr("data-maptype"),s={lat:Number(jQuery(this).attr("data-lat")),lng:Number(jQuery(this).attr("data-lng"))},n=jQuery(this).data("map_type_control"),y=jQuery(this).data("street_view_control"),p=jQuery(this).data("fullscreen_control"),m=jQuery(this).data("tmpl_url"),u=new google.maps.Map(e.getElementById(o),{zoom:r,center:s,panControl:!1,zoomControl:!1,scaleControl:!1,overviewMapControl:!1,mapTypeControl:n,mapTypeControlOptions:{style:google.maps.MapTypeControlStyle.DROPDOWN_MENU,position:google.maps.ControlPosition.TOP_RIGHT},fullscreenControl:p,fullscreenControlOptions:{position:google.maps.ControlPosition.RIGHT_TOP},streetViewControl:y,scrollwheel:l});u.setMapTypeId(google.maps.MapTypeId[i]);var c=navigator.userAgent.toLowerCase().indexOf("trident")>-1?m+"gmap-marker.png":m+"gmap-marker.svg",d=new google.maps.Marker({position:s,map:u,visible:!0,icon:c});var g=document.createElement("div");g.className="gm-zoom-wrapper";new function(e,t){var o=document.createElement("div");o.className="gm-zoom-in",e.appendChild(o);var r=document.createElement("div");r.className="gm-zoom-out",e.appendChild(r),o.addEventListener("click",function(){t.setZoom(t.getZoom()+1)});r.addEventListener("click",function(){t.setZoom(t.getZoom()-1)})}(g,u);u.controls[google.maps.ControlPosition.TOP_LEFT].push(g);var f=jQuery(this).attr("data-show_transit"),h=jQuery(this).attr("data-show_poi"),T=jQuery(this).attr("data-water_color"),_=jQuery(this).attr("data-highway_stroke_color"),v=jQuery(this).attr("data-highway_fill_color"),j=jQuery(this).attr("data-local_stroke_color"),w=jQuery(this).attr("data-local_fill_color"),Q=jQuery(this).attr("data-poi_fill_color"),b=jQuery(this).attr("data-administrative_color"),C=jQuery(this).attr("data-landscape_color"),k=jQuery(this).attr("data-road_text_color"),P=[{featureType:"water",elementType:"geometry.fill",stylers:[{color:T}]},{featureType:"poi",elementType:"labels",stylers:[{visibility:h}]},{featureType:"transit",stylers:[{visibility:f}]},{featureType:"road.highway",elementType:"geometry.stroke",stylers:[{visibility:"on"},{color:_}]},{featureType:"road.highway",elementType:"geometry.fill",stylers:[{color:v}]},{featureType:"road.local",elementType:"geometry.stroke",stylers:[{color:j}]},{featureType:"road.local",elementType:"geometry.fill",stylers:[{visibility:"on"},{color:w},{weight:1.8}]},{featureType:"administrative",elementType:"geometry",stylers:[{color:b}]},{featureType:"landscape",elementType:"geometry.fill",stylers:[{visibility:"on"},{color:C}]},{featureType:"road",elementType:"labels.text.fill",stylers:[{color:k}]},{featureType:"road",elementType:"labels.text.stroke",stylers:[{visibility:"on"},{color:j},{saturation:-25},{weight:1.6}]},{featureType:"poi",elementType:"labels.text.fill",stylers:[{visibility:"on"},{color:k},{saturation:-50}]},{featureType:"poi",elementType:"labels.text.stroke",stylers:[{visibility:"on"},{color:j},{saturation:-25},{weight:2.8}]},{featureType:"poi",elementType:"geometry.fill",stylers:[{visibility:"on"},{color:Q}]},{featureType:"road.arterial",elementType:"geometry.fill",stylers:[{color:jQuery(this).attr("data-road_arterial_fill_color")}]},{featureType:"road.arterial",elementType:"geometry.stroke",stylers:[{color:jQuery(this).attr("data-road_arterial_stroke_color")}]}];if(u.setOptions({styles:P}),a){a=new google.maps.InfoWindow({content:atob(a)});d.addListener("click",function(){a.open(u,d)})}})}jQuery(window).on("load", function(){initSPPageBuilderGMap(document)});
/*
DEPRECATED (deprecated on Apr 7, 2022):
google.maps.event.addDomListener(o,"click",function(){t.setZoom(t.getZoom()+1)}),
google.maps.event.addDomListener(r,"click",function(){t.setZoom(t.getZoom()-1)})

CHANGES TO:
o.addEventListener("click",function(){t.setZoom(t.getZoom()+1)});
r.addEventListener("click",function(){t.setZoom(t.getZoom()-1)})
*/