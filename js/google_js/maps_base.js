/*global google, $, Modernizr, InfoBox, window, alert, setTimeout,mapbase_vars*/

wp_estate_kind_of_map           =   parseInt(mapbase_vars.wp_estate_kind_of_map);
var lealet_map_move_on_hover    =   0;
var propertyMarker_submit       =   '';
var leaflet_map_move_flag       =   0;    
    



function wpresidence_map_general_start_map(page_map){
    "use strict";
    var zoom_level;
    if(page_map=='prop'){
        zoom_level=parseInt(googlecode_property_vars.page_custom_zoom, 10);
    }else{
        zoom_level=parseInt(googlecode_regular_vars.page_custom_zoom, 10);
    }
    
    
    if(jQuery('#wpestate_full_map_control_data').length >0 ){
        zoom_level=jQuery('#wpestate_full_map_control_data').attr('data-zoom');
    }
    
    
    if(wp_estate_kind_of_map===1){
        wpresidence_google_start_map(zoom_level);
    }else if(wp_estate_kind_of_map===2){
        wpresidence_leaflet_start_map(zoom_level);
    } 
}







function wpresidence_leaflet_start_map(zoom_level){
    "use strict";
//   ready
    
    if (typeof(curent_gview_long)==='undefined' || curent_gview_lat === '' || curent_gview_long === '0') {
        if( typeof(googlecode_property_vars)!=='undefined' ){
            curent_gview_lat = googlecode_property_vars.general_latitude;
        }
        
        if( typeof(googlecode_regular_vars)!=='undefined' ){
            curent_gview_lat = googlecode_regular_vars.general_latitude;
        }
    }

    if ( typeof(curent_gview_long)==='undefined' || curent_gview_long === '' || curent_gview_long === '0') {
        if( typeof(googlecode_property_vars)!=='undefined' ){
            curent_gview_long = googlecode_property_vars.general_longitude;
        }
        if( typeof(googlecode_regular_vars)!=='undefined' ){
            curent_gview_long = googlecode_regular_vars.general_longitude;
        }
    }
    
  
   
   
    var mapCenter = L.latLng( curent_gview_lat,curent_gview_long );
 
    if (document.getElementById('googleMap')) {
        
        map =  L.map( 'googleMap',{
            center: mapCenter, 
            zoom: zoom_level,
            
        }).on('load', function(e) {
            jQuery('#gmap-loading').remove();
        });
       
    } else if (document.getElementById('googleMapSlider')) {
        map =  L.map( 'googleMapSlider',{
            center: mapCenter, 
            zoom: zoom_level
        }).on('load', function(e) {
            jQuery('#gmap-loading').remove();
        });
        
    }else{
        return;
    }
    
 wpresidence_leaflet_initialize_map_common(map);
   
     
    
}



function wpresidence_leaflet_initialize_map_common(map){
    
    var tileLayer =  wpresidence_open_stret_tile_details();
    map.addLayer( tileLayer );
    
    map.scrollWheelZoom.disable();
    if ( Modernizr.mq('only all and (max-width: 768px)') ) {    
        map.dragging.disable();
    }
   // map.touchZoom.disable();
          
    map.on('popupopen', function(e) {
        lealet_map_move_on_hover=1;
     
        if( jQuery('#google_map_prop_list_wrapper').length==0 ){
            var px = map.project(e.popup._latlng); // find the pixel location on the map where the popup anchor is
            if( mapfunctions_vars.useprice === 'yes' ){
               px.y -= 115; // find the height of the popup container, divide by 2, subtract from the Y axis of marker location
            }else{
                px.y -= 320/2; // find the height of the popup container, divide by 2, subtract from the Y axis of marker location
            }
            map.panTo(map.unproject(px),{animate: true}); // pan to new center
        }
        
        lealet_map_move_on_hover=1;
    });
    
    jQuery('#gmap-loading').remove();
    map.on('load', function(e) {
        jQuery('#gmap-loading').remove();
    });
    //if (Modernizr.mq('only all and (max-width: 1025px)')) {  }
    

   if ( Modernizr.mq('only all and (max-width: 768px)') ) {        
            map.on('dblclick ', function(e) {
                if (map.dragging.enabled()) {
                     map.dragging.disable();
                    //map.touchZoom.disable();
                }else{
                    map.dragging.enable();
                    //map.touchZoom.enable();
                }
            });
        }

       
  
    
    
    
    markers_cluster=L.markerClusterGroup({

        iconCreateFunction: function(cluster) {
		return L.divIcon({ html: '<div class="leaflet_cluster" style="background-image: url('+images['cloud_pin']+')">' + cluster.getChildCount() + '</div>' });
	},       
    });

}


function  wpresidence_leaflet_map_cluster(){
    map.addLayer(markers_cluster);
}

function wprentals_map_general_map_pan_move(){
    if(wp_estate_kind_of_map===1){
        wprentals_google_map_pan_move();
    }else if(wp_estate_kind_of_map===2){
        wprentals_leaflet_map_pan_move();
    }else if(wp_estate_kind_of_map===3){
        
    }   
    
 
}


function wpresidence_open_stret_tile_details(){
      
    //  tile.openstreetmap.se/hydda/full/{z}/{x}/{y}.png
    //  tile.openstreetmap.se/hydda/full/{z}/{x}/{y}.png)
    //  https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png
    
    
    if( mapbase_vars.wp_estate_mapbox_api_key==='' ){
        var tileLayer = L.tileLayer(  'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        } );

    }else{
        var tileLayer = L.tileLayer( 'https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token='+mapbase_vars.wp_estate_mapbox_api_key, {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'your.mapbox.access.token'
            } 
        );
    }
    return tileLayer;
}


function wpresidence_google_start_map(zoom_level){
    "use strict";
    var mapOptions, styles;
    
    
    
    if(jQuery('#googleMap').hasClass('full_height_map')){
        var new_height = jQuery( window ).height() - jQuery('.master_header').height();
        jQuery('#googleMap,#gmap_wrapper').css('height',new_height);
    }
    
    
    
    if (typeof(curent_gview_long)==='undefined' || curent_gview_lat === ''  || curent_gview_lat === '0') {
        if( typeof(googlecode_property_vars)!=='undefined' ){
            curent_gview_lat = googlecode_property_vars.general_latitude;
        }
        
        if( typeof(googlecode_regular_vars)!=='undefined' ){
            curent_gview_lat = googlecode_regular_vars.general_latitude;
        }
    }

    if ( typeof(curent_gview_long)==='undefined' || curent_gview_long === '' || curent_gview_long === '0') {
        if( typeof(googlecode_property_vars)!=='undefined' ){
            curent_gview_long = googlecode_property_vars.general_longitude;
        }
        if( typeof(googlecode_regular_vars)!=='undefined' ){
            curent_gview_long = googlecode_regular_vars.general_longitude;
        }
    }
    
    if( typeof(googlecode_regular_vars)!=='undefined' ){
        var map_type =googlecode_regular_vars.type.toLowerCase();
    }else  if( typeof(googlecode_property_vars)!=='undefined' ){
        var map_type =googlecode_property_vars.type.toLowerCase();
    }
   
    
 
    var with_bound=0;
    var mapOptions = {
        flat:false,
        noClear:false,
        zoom: parseInt(zoom_level),
        scrollwheel: false,
        draggable: true,
        center: new google.maps.LatLng(curent_gview_lat,curent_gview_long),
        mapTypeId: map_type,
        streetViewControl:false,
        disableDefaultUI: true,
        gestureHandling: 'cooperative'
    };
    
     
         
         
         
 
   
 
    if(  document.getElementById('googleMap') ){
        map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);
    }else if( document.getElementById('googleMapSlider') ){
        map = new google.maps.Map(document.getElementById('googleMapSlider'), mapOptions);
    } else{
        return;
    }   
 
 
 
    google.maps.visualRefresh = true;
    
    if(mapfunctions_vars.show_g_search_status==='yes'){
        wpestate_set_google_search(map);
    }

    
    if(jQuery('#wpestate_full_map_control_data').length>0){
        
        var styles = ( jQuery('#wpestate_full_map_control_data').attr('data-map_style') );
        map.setOptions({styles: styles});
         
    }
    var styles ='';
      
    if(mapfunctions_vars.map_style !==''){
        var styles = JSON.parse ( mapfunctions_vars.map_style );
    }
    
    if(jQuery('#wpestate_full_map_control_data').length>0){
        
        if(map_style_shortcode !==''){
            styles = (map_style_shortcode );
        }
            
//        if(mapfunctions_vars.shortcode_map_style !==''){
//            var styles = JSON.parse ( mapfunctions_vars.shortcode_map_style );
//        }
    }
    
  
    if(styles!==''){
       map.setOptions({styles: styles});
    }
    
  
  
    google.maps.event.addListener(map, 'tilesloaded', function() {
        jQuery('#gmap-loading').remove();
    });


}



function wpresidence_map_general_set_markers(map, markers,with_bound){
    "use strict";
    wpresidence_google_setMarkers2(map, markers,with_bound);
}



function wpresidence_google_setMarkers2 (map, locations){
    "use strict";
    
    var map_open;          
    var myLatLng;
    var selected_id     =   parseInt( jQuery('#gmap_wrapper').attr('data-post_id') );
    if( isNaN(selected_id) ){
        selected_id     =   parseInt( jQuery('#googleMapSlider').attr('data-post_id'),10 );
    }
   
    var open_height     =   parseInt(mapfunctions_vars.open_height,10);
    var closed_height   =   parseInt(mapfunctions_vars.closed_height,10);
    var boxText         =   document.createElement("div");
    width_browser       =   jQuery(window).width();
    
    infobox_width   =   700;
    vertical_pan    =   -215;
    
    if (width_browser<900){
        infobox_width=500;
    }
    
    if (width_browser<600){
        infobox_width=400;
    }
    
    if (width_browser<400){
        infobox_width=200;
    }
    
    
    if(wp_estate_kind_of_map===1){
        bounds = new google.maps.LatLngBounds();
    }
 
 
    
     for (var i = 0; i < locations.length; i++) {
        var beach                       =   locations[i];
        var id                          =   beach[10];
        var lat                         =   beach[1];
        var lng                         =   beach[2];
        var title                       =   decodeURIComponent ( beach[0] );
        var pin                         =   beach[8];
        var counter                     =   beach[3];
        var image                       =   decodeURIComponent ( beach[4] );
        var price                       =   decodeURIComponent ( beach[5] );
        var single_first_type           =   decodeURIComponent ( beach[6] );          
        var single_first_action         =   decodeURIComponent ( beach[7] );
        var link                        =   decodeURIComponent ( beach[9] );
        var cleanprice                  =   beach[11];
        var rooms                       =   beach[12];
        var baths                       =   beach[13];
        var size                        =   beach[14];
        var single_first_type_name      =   decodeURIComponent ( beach[15] );
        var single_first_action_name    =   decodeURIComponent ( beach[16] );
        var pin_price                   =   decodeURIComponent ( beach[17] );
      
           
        
        // found the property
        if(selected_id===id){
            found_id=i;
        }
        
        if(wp_estate_kind_of_map===1){
            wpestate_createMarker ( pin_price,size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,rooms,baths,cleanprice,single_first_type_name, single_first_action_name);
        }else if(wp_estate_kind_of_map===2){
  
            wpresidence_createMarker_leaflet ( pin_price,size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,rooms,baths,cleanprice,single_first_type_name, single_first_action_name);
  
        }
      
    }//end for

}

function wpresidence_map_general_cluster(){
    "use strict";
      
    if(wp_estate_kind_of_map===1){
        wpestate_map_cluster();
    }else if(wp_estate_kind_of_map===2){
        wpresidence_leaflet_map_cluster();
    }
   
}

function wpresidence_map_general_fit_to_bounds(with_bound){
    "use strict";
      
    if(wp_estate_kind_of_map===1){
        wpresidence_google_fit_to_bounds(with_bound);
    }else if(wp_estate_kind_of_map===2){
        wpresidence_leaflet_fit_to_bounds(with_bound);
    }
  
}


function wpresidence_map_panorama(){
    "use strict";
    
    if( parseInt(mapbase_vars.wp_estate_kind_of_map) == 2){
        return;
    }
    var viewPlace=new google.maps.LatLng(curent_gview_lat,curent_gview_long);
    
    panorama = map.getStreetView();
    panorama.setPosition(viewPlace);
    heading  = parseInt(googlecode_property_vars.camera_angle);

    panorama.setPov(/** @type {google.maps.StreetViewPov} */({
        heading: heading,
        pitch: 0
    }));
  
    google.maps.event.addListener(panorama, "closeclick", function() {
        jQuery('#gmap-next,#gmap-prev ,#geolocation-button,#gmapzoomminus,#gmapzoomplus').show();
        jQuery('#street-view').removeClass('mapcontrolon');
    });
    
}



function wpresidence_google_fit_to_bounds(with_bound){
    "use strict";
      
    if (document.getElementById('google_map_prop_list')) {
       
       
    }else if (document.getElementById('googleMap')) {
        if(with_bound===1){
            if (typeof( bounds) !== 'undefined' && !bounds.isEmpty()) {

                wpestate_fit_bounds(bounds);
            }else{
                wpestate_fit_bounds_nolsit();
            }
        }     
    }
}





function wpresidence_map_general_spiderfy(){
    "use strict";
    if(wp_estate_kind_of_map===1){
        if( !jQuery('body').hasClass('single-estate_property') ){
            oms = new OverlappingMarkerSpiderfier(map, {markersWontMove: true, markersWontHide: true,keepSpiderfied :true,legWeight:2});
            wpestate_setOms(gmarkers); 
        }
    }else if(wp_estate_kind_of_map===2){
        // no school no job no problem
    }   
}
















function wpresidence_leaflet_fit_to_bounds(with_bound){
    if(with_bound===1){
    
        if (bounds_list.isValid()) {
       
            
            if(mapfunctions_vars.bypass_fit_bounds!=='1'){
                wpestate_fit_bounds_leaflet(bounds_list);
            }
        }else{
            wpestate_fit_bounds_nolsit_leaflet();
        }
    }
} 






function wpestate_fit_bounds_leaflet(bounds){
   
    is_fit_bounds_zoom=1;  

    if(placeCircle!=''){
        map.fitBounds(placeCircle.getBounds());// placecircle is google geolocation 
    }else{
        if(gmarkers.length===1){
            var center = gmarkers[0].getLatLng();
            map.panTo(center);
            map.setZoom(10);
            is_fit_bounds_zoom=0;  
   
        }else{
            map.fitBounds(bounds);
            is_fit_bounds_zoom=0;  
        }
    }

    
}


function wprentals_leaflet_map_pan_move(){
    if (googlecode_regular_vars.on_demand_pins==='yes' && mapfunctions_vars.is_tax!=1 && mapfunctions_vars.is_property_list==='1'){      
        map.on('moveend', function(e) {
            wpestate_ondenamd_map_moved_leaflet();
        });
        
    }
}









function wprentals_google_map_pan_move(){
    if (googlecode_regular_vars.on_demand_pins==='yes' && mapfunctions_vars.is_tax!=1 && mapfunctions_vars.is_property_list==='1'){
        map.addListener('idle', function() {
            wpestate_ondenamd_map_moved();
        });  
    }
}



function wpresidence_createMarker_leaflet ( pin_price,size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,rooms,baths,cleanprice,single_first_type_name, single_first_action_name){
    "use strict";
            

    var infoboxWrapper = document.createElement( "div" );
    infoboxWrapper.className = 'leafinfobox-wrapper';
    var infobox = "";
        
    var poss=0;
    var infobox_class=" price_infobox ";
    
    
    var price2=price;
    var my_custom_curr_pos     =   parseFloat( wpestate_getCookie_map('my_custom_curr_pos'));
    if (!isNaN(my_custom_curr_pos) && my_custom_curr_pos !== -1) {
        var converted_price= wpestate_get_price_currency(cleanprice,cleanprice);
        var testRE = price.match('</span>(.*)<span class=');
        if (testRE !== null ){
            price2=price.replace(testRE[1],converted_price);
        }
    }
    
    
    
    if( mapfunctions_vars.useprice === 'yes' ){
        infobox_class =' openstreet_map_price_infobox ';
    } 

                                
    var info_image='';        
    if (image === '') {
        info_image =  '<img width="400" height="161" src="'+mapfunctions_vars.path + '/idxdefault.jpg'+'" class="attachment-property_map1 size-property_map1 wp-post-image" alt="">';
    } else {
        info_image = image;
    }
    
    var category        = decodeURIComponent(single_first_type.replace(/-/g, ' '));
    var action          = decodeURIComponent(single_first_action.replace(/-/g, ' '));
    var category_name   = decodeURIComponent(single_first_type_name.replace(/-/g, ' '));
    var action_name     = decodeURIComponent(single_first_action_name.replace(/-/g, ' '));

    var in_type = mapfunctions_vars.in_text;
    if (category === '' || action === '') {
        in_type = " ";
    }
    in_type = " / ";
    var  infoguest,inforooms;
    
    var infobaths; 
    if(baths!=''){
        infobaths ='<span id="infobath">'+baths+' '+mapfunctions_vars.ba+'</span>';
    }else{
        infobaths =''; 
    }
        
        
    var inforooms;
    if(rooms!=''){
        inforooms='<span id="inforoom">'+rooms+' '+mapfunctions_vars.bd+'</span>';
    }else{
        inforooms=''; 
    }
           
    var infosize;
    if(size!=''){
        infosize ='<span id="infosize">'+size+'</span>';
    }else{
        infosize=''; 
    }
   
    var title=  title.substr(0, 30);
    if(title.length > 30){
        title=title+"...";
    }
    
   infobox +=  wpestate_generate_infobox_leaflet(infobox_class,title,link,info_image,price,cleanprice,infosize,infobaths,inforooms);
     
   var  markerOptions = {
        riseOnHover: true
    };
    
    var markerCenter    =   L.latLng( lat, lng );
    var propertyMarker  =   '';
    
    
    
    if( mapfunctions_vars.useprice === 'yes' ){
        
        var price2=price;
        var my_custom_curr_pos     =   parseFloat( wpestate_getCookie_map('my_custom_curr_pos'));
        if (!isNaN(my_custom_curr_pos) && my_custom_curr_pos !== -1) {
            var converted_price= wpestate_get_price_currency(cleanprice,cleanprice);
            var testRE = price.match('</span>(.*)<span class=');
            if (testRE !== null ){
                price2=price.replace(testRE[1],converted_price);
            }
        }
      
      
        var price_pin_class= 'wpestate_marker openstreet_price_marker '+wpestate_makeSafeForCSS(single_first_type_name.trim() )+' '+wpestate_makeSafeForCSS(single_first_action_name.trim()); 

        var pin_price_marker = '<div class="'+price_pin_class+'">';
        if (typeof(price) !== 'undefined') {
            if( mapfunctions_vars.use_price_pins_full_price==='no'){
                pin_price_marker +='<div class="interior_pin_price">'+pin_price+'</div>';
            }else{
                
                pin_price_marker +='<div class="interior_pin_price">'+price2+'</div>';
            }
        }
        pin_price_marker += '</div>';
        


        var myIcon = L.divIcon({ 
            className:'someclass',
            iconSize: new L.Point(0, 0), 
            html: pin_price_marker
        });
        propertyMarker  = L.marker( markerCenter, {icon: myIcon} );

    }else{    
       var markerImage     = {
            iconUrl: wprentals_custompin_leaflet(pin),
            iconSize: [44, 50],
            iconAnchor: [20, 50],
            popupAnchor: [1, -50]
        };
        markerOptions.icon  = L.icon( markerImage );
        propertyMarker      = L.marker( markerCenter, markerOptions );
    }
   
    propertyMarker.idul =   id;
    propertyMarker.pin  =   pin;
   
    if (mapfunctions_vars.user_cluster === 'yes') {
        markers_cluster.addLayer(propertyMarker);
    }else{
        propertyMarker.addTo( map );
    }
    
    gmarkers.push(propertyMarker);

    if (typeof (bounds_list) !== "undefined") {
        bounds_list.extend(propertyMarker.getLatLng());
    }else{
    
        bounds_list = L.latLngBounds( propertyMarker.getLatLng(),propertyMarker.getLatLng() );
    }

    infoboxWrapper.innerHTML = infobox;
    propertyMarker.bindPopup( infobox );
 
    
//    if (mapfunctions_vars.generated_pins !== '0') {
//        if(map_is_pan===0){
//            wpestate_pan_to_last_pin(markerCenter);
//        }
//        map_is_pan=1;
//    }
    
    

}











function wprentals_custompinchild_leaflet(image) {
    "use strict";
    var custom_img;
    var extension='';
    var ratio = jQuery(window).dense('devicePixelRatio');
    
    if(ratio>1){
        extension='_2x';
    }
    
    if (images['userpin'] === '') {
        custom_img = mapfunctions_vars.path + '/' + 'userpin' +extension+ '.png';
    } else {
        custom_img = images['userpin'];
        if(ratio>1){
            custom_img=wpestate_get_custom_retina_pin(custom_img);
        }
    }


    
    return custom_img;;
}

function wprentals_custompin_leaflet(image) {
    "use strict";
    if( mapfunctions_vars.useprice === 'yes' ){
        return mapfunctions_vars.path + '/pixel.png';
    }
    
    var custom_img  =   '';
    var extension   =   '';
    var ratio       =   jQuery(window).dense('devicePixelRatio');
  
    if(ratio>1){
        extension='_2x';
    }
       
    if(mapfunctions_vars.use_single_image_pin==='no'){

        if (image !== '') {
            if (images[image] === '') {
                custom_img = mapfunctions_vars.path + '/' + image + extension + '.png';
            } else {
                custom_img = images[image];
                if(ratio>1){
                    custom_img=wpestate_get_custom_retina_pin(custom_img);
                }
            }
        } else {
            custom_img = images['single_pin'];
        }
    }else{
        if(ratio>1){
            custom_img= wpestate_get_custom_retina_pin(  images['single_pin'] );
        }else{
            custom_img= images['single_pin']; 
        }
    }
        
        

    if (typeof (custom_img) === 'undefined') {
        custom_img =images['single_pin'];
    }
    return custom_img;
}

function wprentals_map_resize(){
    if(wp_estate_kind_of_map===1){
        google.maps.event.trigger(map, "resize");
    }else if(wp_estate_kind_of_map===2){
         map.invalidateSize();
    }else if(wp_estate_kind_of_map===3){
        
    }   
}












function wprentals_initialize_map_submit_leaflet(){
  
    
    var listing_lat = jQuery('#property_latitude').val();
    var listing_lon = jQuery('#property_longitude').val();

    if (listing_lat === '' || listing_lat === 0 || listing_lat === '0') {
        listing_lat = google_map_submit_vars.general_latitude;
    }

    if (listing_lon === '' || listing_lon === 0 || listing_lon === '0') {
        listing_lon = google_map_submit_vars.general_longitude;
    }
    
    var mapCenter = L.latLng( listing_lat,listing_lon );


    if (document.getElementById('googleMapsubmit')) {
        map =  L.map( 'googleMapsubmit',{
            center: mapCenter, 
            zoom: 17
        }).on('load', function(e) {
           
        });
        map_intern = 1;
    


        var tileLayer =  wpresidence_open_stret_tile_details();

        map.addLayer( tileLayer );
        map.on('click', function(e){
            map.removeLayer( propertyMarker_submit )
            var markerCenter        =   L.latLng( e.latlng);
            propertyMarker_submit   =   L.marker(e.latlng).addTo(map);;
            propertyMarker_submit.bindPopup('<div class="submit_leaflet_admin">Latitude: ' + e.latlng.lat + ' Longitude: ' + e.latlng.lng+'</div>').openPopup();
            jQuery("#property_latitude").val ( e.latlng.lat) ;
            jQuery("#property_longitude").val ( e.latlng.lng) ;
         
           
        });


        var markerCenter        =   L.latLng( listing_lat,listing_lon );
        propertyMarker_submit   =   L.marker( markerCenter ).addTo(map);
        propertyMarker_submit.bindPopup('<div class="submit_leaflet_admin">Latitude: ' + listing_lat + ' Longitude: ' + listing_lon+'</div>');
     
        setTimeout(function(){       propertyMarker_submit.openPopup(); }, 600);   
   }
}






function wpresidence_map_resise(){
    if(wp_estate_kind_of_map===1){
        google.maps.event.addListenerOnce(map, 'idle', function() {
            setTimeout(function(){google.maps.event.trigger(map, 'resize'); }, 600);        
        });

    }else if(wp_estate_kind_of_map===2){
        map.invalidateSize();
        setTimeout(function(){ map.invalidateSize(); }, 600);   
    }
}



function wpresidence_initialize_map_contact_leaflet(){
    "use strict";

    var mapCenter = L.latLng( mapbase_vars.hq_latitude, mapbase_vars.hq_longitude );
       map =  L.map( 'googleMap',{
           center: mapCenter, 
           zoom: parseInt(mapbase_vars.page_custom_zoom, 10),
       });

        var tileLayer =  wpresidence_open_stret_tile_details();
        map.addLayer( tileLayer );
        
        map.scrollWheelZoom.disable();
        if ( Modernizr.mq('only all and (max-width: 768px)') ) {    
            map.dragging.disable();
        }
        //map.touchZoom.disable();
        
        
    
        jQuery('#gmap-loading').remove();

        map.on('popupopen', function(e) {

            var px = map.project(e.popup._latlng); // find the pixel location on the map where the popup anchor is
            if( mapfunctions_vars.useprice === 'yes' ){
               px.y -= 115; // find the height of the popup container, divide by 2, subtract from the Y axis of marker location
            }else{
                px.y -= 120/2; // find the height of the popup container, divide by 2, subtract from the Y axis of marker location
            }
            map.panTo(map.unproject(px),{animate: true}); // pan to new center
        });

        var markerCenter    =   L.latLng( mapbase_vars.hq_latitude, mapbase_vars.hq_longitude );
        var markerImage     = {
            iconUrl: images['single_pin'],
            iconSize: [44, 50],
            iconAnchor: [20, 50],
            popupAnchor: [1, -50]
        };
        var markerOptions = {
            riseOnHover: true
        };
       // var infobox = '<div class="info_details contact_info_details leaflet_contact"><h2 id="contactinfobox">' +  mapbase_vars.title+ '</h2><div class="contactaddr">' + mapbase_vars.address + '</div></div>'


       markerOptions.icon  = L.icon( markerImage );
       var propertyMarker      = L.marker( markerCenter, markerOptions );
     //  propertyMarker.bindPopup( infobox );
       propertyMarker.addTo( map );

       propertyMarker.fire('click');
       
             
        if ( Modernizr.mq('only all and (max-width: 768px)') ) {        
            map.on('dblclick ', function(e) {
                if (map.dragging.enabled()) {
                     map.dragging.disable();
                    //map.touchZoom.disable();
                }else{
                    map.dragging.enable();
                    //map.touchZoom.enable();
                }
            });
        }


}




function wpresidence_initialize_map_contact(){
    "use strict";
    if(!document.getElementById('googleMap') ){
        return;
    }
    var mapOptions = {
        zoom: parseInt(mapbase_vars.page_custom_zoom),
        scrollwheel: false,
        center: new google.maps.LatLng(mapbase_vars.hq_latitude, mapbase_vars.hq_longitude),
        mapTypeId: mapbase_vars.type.toLowerCase(),
        streetViewControl:false,
        disableDefaultUI: true,
        gestureHandling: 'cooperative'
    };

    map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);

    

    google.maps.event.addListener(map, 'tilesloaded', function() {
        jQuery('#gmap-loading').remove();
    });


    var styles ='';
    if(mapfunctions_vars.map_style !==''){
       styles = JSON.parse ( mapfunctions_vars.map_style );
     
    }
    
    if(jQuery('#wpestate_full_map_control_data').length>0){
        if(map_style_shortcode !==''){
            styles = (map_style_shortcode );
        }
         if(mapfunctions_vars.shortcode_map_style !==''){}
    }
      map.setOptions({styles: styles});
    
    pins=mapbase_vars.markers;
    markers = jQuery.parseJSON(pins);
    wpestate_setMarkers_contact(map, markers);
    //google.maps.event.trigger(gmarkers[0], 'click');

  
}

 ////////////////////////////////////////////////////////////////////
 /// custom pin function
 //////////////////////////////////////////////////////////////////////
 
function wpestate_custompincontact(image){
    "use strict";
    image = {
        url:  images['single_pin'],
        size: new google.maps.Size(59, 59),
        origin: new google.maps.Point(0,0),
        anchor: new google.maps.Point(16,59 )
   };
   return image;
 }
  
 ////////////////////////////////////////////////////////////////////
 /// set markers function
 //////////////////////////////////////////////////////////////////////
 

function wpestate_setMarkers_contact(map, beach) {
    "use strict";
    var shape = {
        coord: [1, 1, 1, 38, 38, 59, 59 , 1],
        type: 'poly'
    };
    var title;
    var boxText = document.createElement("div");
    var myOptions = {
                      content: boxText,
                      disableAutoPan: true,
                      maxWidth: 500,
                      pixelOffset: new google.maps.Size(-90, -210),
                      zIndex: null,
                      closeBoxMargin: "-13px 0px 0px 0px",
                      closeBoxURL: "",
                      draggable: true,
                      infoBoxClearance: new google.maps.Size(1, 1),
                      isHidden: false,
                      pane: "floatPane",
                      enableEventPropagation: false
              };              
    infoBox = new InfoBox(myOptions);         
                

   

    var myLatLng = new google.maps.LatLng(mapbase_vars.hq_latitude, mapbase_vars.hq_longitude);
    var marker = new google.maps.Marker({
        position: myLatLng,
        map: map,
        icon: wpestate_custompincontact(beach[8]),
        shape: shape,
        title: decodeURIComponent(  beach[0].replace(/\+/g,' ')),
        zIndex: 1,
        image:beach[4],
        price:beach[5],
        type:beach[6],
        type2:beach[7],
        infoWindowIndex : 0 
    });

    gmarkers.push(marker);


//    google.maps.event.addListener(marker, 'click', function() { 
//        first_time=0;
//        title = this.title;
//        infoBox.setContent('<div class="info_details contact_info_details"><span id="infocloser" onClick=\'javascript:infoBox.close();\' ></span><h2 id="contactinfobox">'+title+'</h2><div class="contactaddr">'+mapbase_vars.address+'</div></div>' );
//  
//        infoBox.open(map, this);    
//        map.setCenter(this.position);      
//        map.panBy(0,-120);
//        
//        wpestate_close_adv_search();
//    });


}// end setMarkers

  