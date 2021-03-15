/*global google,Modernizr,InfoBox,googlecode_regular_vars,jQuery,mapfunctions_vars,googlecode_regular_vars2,wpestate_setMarkers,wpestate_placeidx,wpestate_set_google_search*/
var gmarkers = [];
var current_place=0;
var actions=[];
var categories=[];
var map_open=0;
var pins='';
var markers='';
var infoBox = null;
var category=null;
var map;
var found_id;
var selected_id         =   '';
var javamap;
var oms;
var idx_place;
var bounds;
var external_action_ondemand=0;
var markers_cluster;
var panorama;
function wpresidence_initialize_map(){
    "use strict";
    var with_bound=0;
    
    if(  jQuery('#googleMap').length===0 &&  jQuery('#googleMapSlider').length===0   ){
        return;
    }
 
    wpresidence_map_general_start_map();
    

    if(googlecode_regular_vars.generated_pins==='0'){
        pins        =   googlecode_regular_vars.markers;
        markers     =   jQuery.parseJSON(pins);
    }else{
        if( typeof( googlecode_regular_vars2) !== 'undefined' && googlecode_regular_vars2.markers2.length > 2){          
            pins        =   googlecode_regular_vars2.markers2;
          
            markers     =   jQuery.parseJSON(pins); 
            with_bound  =   1;
        }           
    }
    
    
    
    if (markers.length>0){
        wpresidence_map_general_set_markers(map, markers,with_bound);
    }
   
    if(googlecode_regular_vars.idx_status==='1'){
        wpestate_placeidx(map,markers);
    }

    //set map cluster
     wpresidence_map_general_cluster();
  
   //fit bounds
   if(typeof(is_map_shortcode)!=='undefined'){
       with_bound=1;
   }
    wpresidence_map_general_fit_to_bounds(with_bound);
    
    //spider
    wpresidence_map_general_spiderfy();
   
 
   
   
}
///////////////////////////////// end wpresidece_initialize_map
/////////////////////////////////////////////////////////////////////////////////// 
 
if(typeof(is_map_shortcode)=='undefined'){
    if (typeof google === 'object' && typeof google.maps === 'object') {                                         
        google.maps.event.addDomListener(window, 'load', wpresidence_initialize_map);
    }else{
        wpresidence_initialize_map();
    }
}