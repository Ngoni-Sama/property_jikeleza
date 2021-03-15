/*global $,oms,WpstateMarker,wpestate_start_filtering_ajax,control_vars,googlecode_regular_vars,wpestate_custom_search_start_filtering_ajax,ajaxcalls_vars,MarkerClusterer,map,google,OverlappingMarkerSpiderfier,gmarkers, Modernizr , InfoBox,google_map_submit_vars ,mapfunctions_vars, googlecode_home_vars,jQuery,googlecode_property_vars*/
var pin_images=mapfunctions_vars.pin_images;
var images = jQuery.parseJSON(pin_images);
var ipad_time=0;
var infobox_id=0;
var shape = {
        coord: [1, 1, 1, 38, 38, 59, 59 , 1],
        type: 'poly'
    };

var mcOptions;
var mcluster;
var clusterStyles;
var pin_hover_storage;
var first_time_wpestate_show_inpage_ajax_half=0;
var panorama;
var infoBox_sh=null;
var poi_marker_array=[];
var poi_type='';
var placeCircle='';
var initialGeop=0;
var heading=0;
var width_browser=null;
var infobox_width=null;
var wraper_height=null;
var info_image=null;
var vertical_pan=-190;
var vertical_off=150;
var curent_gview_lat = jQuery('#gmap_wrapper').attr('data-cur_lat');
var curent_gview_long = jQuery('#gmap_wrapper').attr('data-cur_long');
var bounds_list;
var circleLayer='';

function wpestate_agency_map_function(){
    "use strict";
    var curent_gview_lat    =   jQuery('#agency_map').attr('data-cur_lat');
    var curent_gview_long   =   jQuery('#agency_map').attr('data-cur_long');
    
 
    
    if(mapfunctions_vars.geolocation_type==1){
    

        var mapOptions_intern = {
            flat:false,
            noClear:false,
            zoom:  15,
            scrollwheel: false,
            draggable: true,
            center: new google.maps.LatLng(curent_gview_lat,curent_gview_long ),
            streetViewControl:false,
            disableDefaultUI: true,
            mapTypeId: mapfunctions_vars.type.toLowerCase(),
            gestureHandling: 'cooperative'
        };


        var    map_agency= new google.maps.Map(document.getElementById('agency_map'), mapOptions_intern);
        if(mapfunctions_vars.map_style !==''){
           var styles = JSON.parse ( mapfunctions_vars.map_style );
           map_agency.setOptions({styles: styles});
        }

        google.maps.visualRefresh = true;
        google.maps.event.trigger(map_agency, 'resize');



        var myLatLng = new google.maps.LatLng(curent_gview_lat, curent_gview_long);
        var marker = new google.maps.Marker({
            position: myLatLng,
            map: map_agency,
            icon: wpesate_custompin_agency(),
            shape: shape,
            title: 'we are here',
            zIndex: 1,
            infoWindowIndex : 0 
         });
 
    }else{
        wpresidence_agency_dev_map(curent_gview_lat,curent_gview_long,'agency_map');
    }



}



function wpresidence_agency_dev_map(latitude,longitude,map_name){
    "use strict";

    var mapCenter = L.latLng(latitude, longitude );
var    map =  L.map( map_name,{
        center: mapCenter, 
        zoom:7,
    });

    var tileLayer =  wpresidence_open_stret_tile_details();
    map.addLayer( tileLayer );

   
    var markerCenter    =   L.latLng( latitude, longitude );
    var markerImage     = {
        iconUrl:  images['single_pin'],
        iconSize: [44, 50],
        iconAnchor: [20, 50],
        popupAnchor: [1, -50]
    };
    var markerOptions = {
        riseOnHover: true
    };
        

    markerOptions.icon  = L.icon( markerImage );
    var propertyMarker      = L.marker( markerCenter, markerOptions );

    propertyMarker.addTo( map );

      
}






function wpesate_custompin_agency(){
    "use strict";
    var image = {
        url:  images['single_pin'], 
        size: new google.maps.Size(59, 59),
        origin: new google.maps.Point(0,0),
        anchor: new google.maps.Point(16,59 )
    };

    return image;
}


function wpestate_map_shortcode_function(){
    "use strict";


    var selected_id         =   parseInt( jQuery('#googleMap_shortcode').attr('data-post_id'),10 );
    var curent_gview_lat    =   jQuery('#googleMap_shortcode').attr('data-cur_lat');
    var curent_gview_long   =   jQuery('#googleMap_shortcode').attr('data-cur_long');
    var zoom;
    var map2='';
    var gmarkers_sh = [];

    if (typeof googlecode_property_vars === 'undefined') {
        zoom=5;
        heading=0;
    }else{
        zoom    =   googlecode_property_vars.page_custom_zoom;
        heading =   parseInt(googlecode_property_vars.camera_angle);
    }

     var i = 1;
     
    var id                          =   selected_id;
    var lat                         =   curent_gview_lat;
    var lng                         =   curent_gview_long;
    var title                       =   decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-title') ); 
    var pin                         =   jQuery('#googleMap_shortcode').attr('data-pin');
    var counter                     =   1;
    var image                       =   decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-thumb' ));
    var price                       =   decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-price' ));
    var single_first_type           =   decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-single-first-type') );        
    var single_first_action         =   decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-single-first-action') );
    var link                        =   decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-prop_url' ));
    var city                        =   '';
    var area                        =   '';
    var rooms                       =   decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-rooms')) ;
    var baths                       =   decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-bathrooms')) ;
    var size                        =   decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-size') );
    var single_first_type_name      =   decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-single-first-type') );  
    var single_first_action_name    =   decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-single-first-action') );
    var agent_id                    =   '' ;   
    var county_state                =   '' ;  
    var price_pin                   =   decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-pin_price' )); 
    var cleanprice                 =   decodeURIComponent ( jQuery('#googleMap_shortcode').attr('data-clean_price' ));


    if (wp_estate_kind_of_map==2){
        
        var mapCenter = L.latLng( curent_gview_lat,curent_gview_long );
   
        
        map2 =  L.map( 'googleMap_shortcode',{
            center: mapCenter, 
            zoom: zoom
        }).on('load', function(e) {
            jQuery('#gmap-loading').remove();
        });


        wpresidence_leaflet_initialize_map_common(map2);


        wpestate_createMarker_sh_leaflet (price_pin,infoBox_sh,gmarkers_sh,map2,county_state, size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice,single_first_type_name, single_first_action_name );
       
   

    }else{
    
        if( jQuery('#googleMap_shortcode').length > 0){


          
            var mapOptions_intern = {
                flat:false,
                noClear:false,
                zoom:  parseInt(zoom),
                scrollwheel: false,
                draggable: true,
                center: new google.maps.LatLng(curent_gview_lat,curent_gview_long ),
                streetViewControl:false,
                disableDefaultUI: true,
                mapTypeId: mapfunctions_vars.type.toLowerCase(),
                gestureHandling: 'cooperative'
            };

            map2= new google.maps.Map(document.getElementById('googleMap_shortcode'), mapOptions_intern);


            google.maps.visualRefresh = true;
            google.maps.event.trigger(map2, 'resize');


            width_browser       =   jQuery(window).width();

            infobox_width=700;
            vertical_pan=-215;
            if (width_browser<900){
              infobox_width=500;
            }
            if (width_browser<600){
              infobox_width=400;
            }
            if (width_browser<400){
              infobox_width=200;
            }
           var boxText         =   document.createElement("div");

            var myOptions = {
                content: boxText,
                disableAutoPan: true,
                maxWidth: infobox_width,
                boxClass:"mybox",
                zIndex: null,			
                closeBoxMargin: "-13px 0px 0px 0px",
                closeBoxURL: "",
                infoBoxClearance: new google.maps.Size(1, 1),
                isHidden: false,
                pane: "floatPane",
                enableEventPropagation: true                   
            };              
            infoBox_sh = new InfoBox(myOptions);    


            if(mapfunctions_vars.map_style !==''){
               var styles = JSON.parse ( mapfunctions_vars.map_style );
               map2.setOptions({styles: styles});
            }
           
            
            wpestate_createMarker_sh (price_pin,infoBox_sh,gmarkers_sh,map2,county_state, size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice,single_first_type_name, single_first_action_name );


            var viewPlace   =   new google.maps.LatLng(curent_gview_lat,curent_gview_long);
            if(typeof (panorama_sh)==='undefined'){
                var panorama_sh;
            }
            panorama_sh        =   map2.getStreetView();
            panorama_sh.setPosition(viewPlace);


            panorama_sh.setPov(/** @type {google.maps.StreetViewPov} */({
                heading: heading,
                pitch: 0
            }));

            jQuery('#slider_enable_street_sh').on( 'click', function() {
                var cur_lat     =   jQuery('#googleMap_shortcode').attr('data-cur_lat');
                var cur_long    =   jQuery('#googleMap_shortcode').attr('data-cur_long');
                var myLatLng    =   new google.maps.LatLng(cur_lat,cur_long);

                panorama_sh.setPosition(myLatLng);
                panorama_sh.setVisible(true); 
                jQuery('#gmapzoomminus_sh,#gmapzoomplus_sh,#slider_enable_street_sh').hide();

            });

            google.maps.event.addListener(panorama_sh, "closeclick", function() {
                jQuery('#gmapzoomminus_sh,#gmapzoomplus_sh,#slider_enable_street_sh').show();
            });


          

            



            google.maps.event.trigger(gmarkers_sh[0], 'click');  
            setTimeout(function(){
                google.maps.event.trigger(map2, "resize"); 
                map2.setCenter(gmarkers_sh[0].position);  
//                    switch (infobox_width){
//                        case 700:
//                            map2.panBy(100,-150);
//                            vertical_off=0;
//                            break;
//                        case 500: 
//                            map2.panBy(50,-120);
//                            break;
//                        case 400: 
//                            map2.panBy(100,-220);
//                            break;
//                        case 200: 
//                            map2.panBy(20,-170);
//                            break;               
//                    }
            }, 300);



            wpestate_initialize_poi(map2,2);
        }
    }
    
    
    if(  document.getElementById('gmapzoomplus_sh') ){
        jQuery('#gmapzoomplus_sh').on('click',function(){   
            "use strict";
          
            var current= parseInt( map2.getZoom(),10);
            current++;
            if(current>20){
                current=20;
            }
            map2.setZoom(current);
        });  
    }

    if(  document.getElementById('gmapzoomminus_sh') ){
        jQuery('#gmapzoomminus_sh').on('click',function(){
            "use strict";
            var current= parseInt( map2.getZoom(),10);
            current--;
            if(current<0){
                current=0;
            }
            map2.setZoom(current);
        });  
    }

    if (wp_estate_kind_of_map==2){
        setTimeout(function(){ map2.invalidateSize(); }, 1000); 
    }else{
        setTimeout(function(){ google.maps.event.trigger(map2, "resize"); }, 1000); 
           
    }
    
    jQuery('.shtabmap,.shacctab').on( 'click', function(event) {

        if (wp_estate_kind_of_map==2){
         
            setTimeout(function(){ map2.invalidateSize(); }, 100); 
        }else{
            setTimeout(function(){ google.maps.event.trigger(map2, "resize"); }, 100); 

        }
    });
}




function wpestate_createMarker_sh_leaflet (pin_price,infoBox_sh,gmarkers_sh,map2,county_state, size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice,single_first_type_name, single_first_action_name ){
    "use strict";
 
    var infoboxWrapper = document.createElement( "div" );
    infoboxWrapper.className = 'leafinfobox-wrapper';
    var infobox = "";
        
    var poss=0;
    var infobox_class=" price_infobox ";
    
    
    
    
    
    
    if( mapfunctions_vars.useprice === 'yes' ){
        infobox_class =' openstreet_map_price_infobox ';
    } 

                                
    var info_image='';        
    if (image === '') {
        info_image =  mapfunctions_vars.path + '/idxdefault.jpg';
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
        var price_pin_class= 'wpestate_marker openstreet_price_marker '+wpestate_makeSafeForCSS(single_first_type_name.trim() )+' '+wpestate_makeSafeForCSS(single_first_action_name.trim()); 

        var pin_price_marker = '<div class="'+price_pin_class+'">';
        if (typeof(price) !== 'undefined') {
            if( mapfunctions_vars.use_price_pins_full_price==='no'){
                pin_price_marker +='<div class="interior_pin_price">'+pin_price+'</div>';
            }else{
                pin_price_marker +='<div class="interior_pin_price">'+price+'</div>';
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
   
    
    propertyMarker.addTo( map2 );
    
    
    gmarkers_sh.push(propertyMarker);

    if (typeof (bounds_list) !== "undefined") {
        bounds_list.extend(propertyMarker.getLatLng());
    }else{
    
        bounds_list = L.latLngBounds( propertyMarker.getLatLng(),propertyMarker.getLatLng() );
    }

    infoboxWrapper.innerHTML = infobox;
    propertyMarker.bindPopup( infobox );
    
    
     
      propertyMarker.fire('click').openPopup();
    
}






function wpestate_createMarker_sh (pin_price,infoBox_sh,gmarkers_sh,map2,county_state, size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,city,area,rooms,baths,cleanprice,single_first_type_name, single_first_action_name ){
    "use strict";
    var new_title   =   '';
    var myLatLng    =   new google.maps.LatLng(lat,lng);
    var poss=0;
    var infobox_class=" price_infobox ";
    if(mapfunctions_vars.useprice === 'yes'){
 

        myLatLng        =   new google.maps.LatLng(lat,lng);
        var Titlex          =   jQuery('<textarea />').html(title).text();
      
        var infoWindowIndex =   999;
        poss=11;
 
        var price2=price;
        var my_custom_curr_pos     =   parseFloat( wpestate_getCookie_map('my_custom_curr_pos'));
        if (!isNaN(my_custom_curr_pos) && my_custom_curr_pos !== -1) {
                 
            var converted_price= wpestate_get_price_currency(cleanprice,cleanprice);
            var testRE = price.match('</span>(.*)<span class=');
            if (testRE !== null ){
                price2=price.replace(testRE[1],converted_price);
            }
        }
            
     
        marker= new WpstateMarker(
            poss,
            myLatLng, 
            map2, 
            Titlex,
            counter,
            image,
            id,
            
            price2,
            pin_price,
            single_first_type,
            single_first_action,
            link,
            i,
            rooms,
            baths,
            cleanprice,
            size,
            single_first_type_name,
            single_first_action_name,
            pin,
            infoWindowIndex
        );
        
    
    }else{
        infobox_class=" classic_info ";
        var marker = new google.maps.Marker({
               position: myLatLng,
               map: map2,
               icon: wpestate_custompin(pin),
               shape: shape,
               title: title,
               zIndex: counter,
               image:image,
               idul:id,
               price:price,
               category:single_first_type,
               action:single_first_action,
               link:link,
               city:city,
               area:area,
               infoWindowIndex : i,
               rooms:rooms,
               baths:baths,
               cleanprice:cleanprice,
               size:size,
               county_state:county_state,
               category_name:single_first_type_name,
               action_name:single_first_action_name
              });
    }
    
    gmarkers_sh.push(marker);
 
    google.maps.event.addListener(marker, 'click', function() {

            if(this.image===''){
                info_image='<img src="' + mapfunctions_vars.path + '/idxdefault.jpg"  />';
            }else{
                info_image=this.image;
            }
            
            var category         =   decodeURIComponent ( this.category.replace(/-/g,' ') );
            var action           =   decodeURIComponent ( this.action.replace(/-/g,' ') );
            var category_name    =   decodeURIComponent ( this.category_name.replace(/-/g,' ') );
            var action_name      =   decodeURIComponent ( this.action_name.replace(/-/g,' ') );
            var in_type          =   mapfunctions_vars.in_text;
            if(category==='' || action===''){
                in_type=" ";
            }
            
           var infobaths; 
            if(this.baths!=''){
                infobaths ='<span id="infobath">'+this.baths+' '+mapfunctions_vars.ba+'</span>';
            }else{
                infobaths =''; 
            }

            var inforooms;
            if(this.rooms!=''){
                inforooms='<span id="inforoom">'+this.rooms+' '+mapfunctions_vars.bd+'</span>';
            }else{
                inforooms=''; 
            }
           
            var infosize;
            if(this.size!=''){
                 infosize ='<span id="infosize">'+this.size;
                 infosize =infosize+'</span>';
            }else{
                infosize=''; 
            }
        

            var title=  this.title.substr(0, 30);
            if(this.title.length > 30){
                title=title+"...";
            }

            infoBox_sh.setContent( wpestate_generate_infobox_sh(infobox_class,title,link,info_image,price,cleanprice,infosize,infobaths,inforooms));
            infoBox_sh.open(map2, this);    
            map2.setCenter(this.position);   

            
           

            if (control_vars.show_adv_search_map_close === 'no') {
                $('.search_wrapper').addClass('adv1_close');
                wpestate_adv_search_click();
            }
            
             wpestate_close_adv_search();
            });/////////////////////////////////// end event listener
            
         
        
}



/////////////////////////////////////////////////////////////////////////////////////////////////
// change map
/////////////////////////////////////////////////////////////////////////////////////////////////  

function  wpestate_change_map_type(map_type){
    "use strict";
    if(map_type==='map-view-roadmap'){
         map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
    }else if(map_type==='map-view-satellite'){
         map.setMapTypeId(google.maps.MapTypeId.SATELLITE);
    }else if(map_type==='map-view-hybrid'){
         map.setMapTypeId(google.maps.MapTypeId.HYBRID);
    }else if(map_type==='map-view-terrain'){
         map.setMapTypeId(google.maps.MapTypeId.TERRAIN);
    }
   
}

/////////////////////////////////////////////////////////////////////////////////////////////////
//  set markers... loading pins over map
/////////////////////////////////////////////////////////////////////////////////////////////////  

function wpestate_setMarkers(map, locations, with_bound) {
    "use strict";
    var map_open;          
     
    var myLatLng;
    var selected_id     =   parseInt( jQuery('#gmap_wrapper').attr('data-post_id') );
    if( isNaN(selected_id) ){
        selected_id     =   parseInt( jQuery('#googleMapSlider').attr('data-post_id'),10 );
    }
   
    var open_height     =   parseInt(mapfunctions_vars.open_height,10);
    var closed_height   =   parseInt(mapfunctions_vars.closed_height,10);

    width_browser       =   jQuery(window).width();
    
    infobox_width=700;
    vertical_pan=-215;
    if (width_browser<900){
      infobox_width=500;
    }
    if (width_browser<600){
      infobox_width=400;
    }
    if (width_browser<400){
      infobox_width=200;
    }
 
 
      
                                
    bounds = new google.maps.LatLngBounds();

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
      
           
        wpestate_createMarker ( pin_price,size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,rooms,baths,cleanprice,single_first_type_name, single_first_action_name);
        
        // found the property
        if(selected_id===id){
            found_id=i;
        }
       
      
    }//end for

  
    wpestate_map_cluster();
    if( !jQuery('body').hasClass('single-estate_property') ){
        oms = new OverlappingMarkerSpiderfier(map, {markersWontMove: true, markersWontHide: true,keepSpiderfied :true,legWeight:2});
        wpestate_setOms(gmarkers); 
    }

    if(with_bound===1){
        if (!bounds.isEmpty()) {
          
            wpestate_fit_bounds(bounds);
        }else{
            wpestate_fit_bounds_nolsit();
        }
    }          
    
    // pan to the latest pin for taxonmy and adv search  
    if(mapfunctions_vars.generated_pins!=='0'){
        myLatLng  = new google.maps.LatLng(lat, lng);
    }
    
  
   
   
}// end wpestate_setMarkers


/////////////////////////////////////////////////////////////////////////////////////////////////
//  create marker
/////////////////////////////////////////////////////////////////////////////////////////////////  


function   wpestate_createMarker ( pin_price,size, i,id,lat,lng,pin,title,counter,image,price,single_first_type,single_first_action,link,rooms,baths,cleanprice,single_first_type_name, single_first_action_name){
        
    "use strict";
    var myLatLng        =   new google.maps.LatLng(lat,lng);
    var Titlex          =   jQuery('<textarea />').html(title).text();
    var poss            =   0;
    var infobox_class   =   " price_infobox ";
    var boxText         =   document.createElement("div");
    
    var myOptions = {
        content: boxText,
        disableAutoPan: true,
        maxWidth: infobox_width,
        boxClass:"mybox",
        zIndex: null,			
        closeBoxMargin: "-13px 0px 0px 0px",
        closeBoxURL: "",
        infoBoxClearance: new google.maps.Size(1, 1),
        isHidden: false,
        pane: "floatPane",
        enableEventPropagation: true                   
    };              
    infoBox = new InfoBox(myOptions);      
    
    
 
    if(mapfunctions_vars.useprice === 'yes'){
   

   
        var price2=price;
        var my_custom_curr_pos     =   parseFloat( wpestate_getCookie_map('my_custom_curr_pos'));
        if (!isNaN(my_custom_curr_pos) && my_custom_curr_pos !== -1) {
            var converted_price= wpestate_get_price_currency(cleanprice,cleanprice);
            var testRE = price.match('</span>(.*)<span class=');
            if (testRE !== null ){
                price2=price.replace(testRE[1],converted_price);
            }
        }
      
       
	var myLatlng = new google.maps.LatLng(lat,lng);
        marker= new WpstateMarker( 
            poss,
            myLatlng, 
            map, 
            Titlex,
            counter,
            image,
            id,
    
            price2,
            pin_price,
            single_first_type,
            single_first_action,
            link,
            i,
            rooms,
            baths,
            cleanprice,
            size,
            single_first_type_name,
            single_first_action_name,
            pin,
            i
        );
    }else{
        infobox_class=" classic_info ";
        var marker = new google.maps.Marker({
            position:           myLatLng,
            map:                map,
            icon:               wpestate_custompin(pin),
            shape:              shape,
            title:              Titlex,
            zIndex:             counter,
            image:              image,
            idul:               id,
            price:              price,
            category:           single_first_type,
            action:             single_first_action,
            link:               link,
            infoWindowIndex :   i,
            rooms:              rooms,
            baths:              baths,
            cleanprice:         cleanprice,
            size:               size,
            category_name:      single_first_type_name,
            action_name:        single_first_action_name
        });

    }           
    
   
    gmarkers.push(marker);
    bounds.extend(marker.getPosition());
    google.maps.event.addListener(marker, 'click', function(event) {
            
        //  wpestate_new_open_close_map(1);
     
        if( typeof(is_map_shortcode) ==="undefined" ){
            wpestate_map_callback( wpestate_new_open_close_map );
            google.maps.event.trigger(map, 'resize');
        }

        if(this.image===''){
            info_image='<img src="' + mapfunctions_vars.path + '/idxdefault.jpg" />';
        }else{
            info_image=this.image;
        }

        var category         =   decodeURIComponent ( this.category.replace(/-/g,' ') );
        var action           =   decodeURIComponent ( this.action.replace(/-/g,' ') );
        var category_name    =   decodeURIComponent ( this.category_name.replace(/-/g,' ') );
        var action_name      =   decodeURIComponent ( this.action_name.replace(/-/g,' ') );
        var in_type          =   mapfunctions_vars.in_text;
        if(category==='' || action===''){
            in_type=" ";
        }

        var infobaths; 
        if(this.baths!=''){
            infobaths ='<span id="infobath">'+this.baths+' '+mapfunctions_vars.ba+'</span>';
        }else{
            infobaths =''; 
        }

        var inforooms;
        if(this.rooms!=''){
            inforooms='<span id="inforoom">'+this.rooms+' '+mapfunctions_vars.bd+'</span>';
        }else{
            inforooms=''; 
        }
           
        var infosize;
        if(this.size!=''){
            infosize ='<span id="infosize">'+this.size;

            infosize =infosize+'</span>';
        }else{
            infosize=''; 
        }
        
        
        var title=  this.title.substr(0, 30);
        if(this.title.length > 30){
            title=title+"...";
        }
        
        
        infoBox.setContent( wpestate_generate_infobox(infobox_class,title,link,info_image,price,cleanprice,infosize,infobaths,inforooms));
        infoBox.open(map, this);    
        map.setCenter(this.position);   

            
           
    


//        switch (infobox_width){
//            case 700:
//               
//                if(mapfunctions_vars.listing_map === 'top'){
//                    map.panBy(100,-110);
//                }else{
//                    if(mapfunctions_vars.small_slider_t==='vertical'){
//                        map.panBy(300,-300);
//
//                    }else{
//                        map.panBy(10,-110);
//                    }    
//                }
//
//                vertical_off=0;
//                break;
//            case 500: 
//                map.panBy(50,-120);
//                break;
//            case 400: 
//                map.panBy(20,-150);
//                break;
//            case 200: 
//                map.panBy(20,-170);
//                break;               
//            }
            
       
            if (control_vars.show_adv_search_map_close === 'no') {
                $('.search_wrapper').addClass('adv1_close');
                wpestate_adv_search_click();
            }
            
            wpestate_close_adv_search();
    });/////////////////////////////////// end event listener
            
         
        
}

function  wpestate_pan_to_last_pin(myLatLng){
    "use strict";
    map.setCenter(myLatLng);   
}


function wpestate_generate_infobox(infobox_class,title,link,info_image,price,cleanprice,infosize,infobaths,inforooms){
 
    var infobox= '<div class="info_details '+infobox_class+'"><span id="infocloser" onClick=\'javascript:infoBox.close();\' ></span>';
    infobox = infobox+ '<div class="infobox_wrapper_image"> <a href="'+link+'">'+info_image+'</a></div>';
    infobox = infobox+ '<div class="infobox_title"><a href="'+link+'" id="infobox_title">'+title+'</a></div>';
    infobox = infobox+ '<div class="prop_pricex">'+price+'</div>';
    infobox = infobox+ '<div class="infobox_details">'+inforooms+' '+infobaths+' '+infosize+'</div></div>';
    
    return infobox;
     
}

function wpestate_generate_infobox_sh(infobox_class,title,link,info_image,price,cleanprice,infosize,infobaths,inforooms){
     
    var infobox= '<div class="info_details '+infobox_class+'"><span id="infocloser" onClick=\'javascript:infoBox_sh.close();\' ></span>';
    infobox = infobox+ '<div class="infobox_wrapper_image"> <a href="'+link+'">'+info_image+'</a></div>';
    infobox = infobox+ '<div class="infobox_title"><a href="'+link+'" id="infobox_title">'+title+'</a></div>';
    infobox = infobox+ '<div class="prop_pricex">'+price+'</div>';
    infobox = infobox+ '<div class="infobox_details">'+inforooms+' '+infobaths+' '+infosize+'</div></div>';
    
    return infobox;
     
}


function wpestate_generate_infobox_leaflet(infobox_class,title,link,info_image,price,cleanprice,infosize,infobaths,inforooms){
    var title=  title.substr(0, 32);
    if(title.length > 32){
        title=title+"...";
    }
    var infobox= '<div class="info_details '+infobox_class+'"><span id="infocloser" onClick=\'javascript:jQuery(".leaflet-popup-close-button")[0].click();\' ></span>';
    infobox = infobox+ '<div class="infobox_wrapper_image"> <a href="'+link+'">'+info_image+'</a></div>';
    infobox = infobox+ '<div class="infobox_title"><a href="'+link+'" id="infobox_title">'+title+'</a></div>';
    infobox = infobox+ '<div class="prop_pricex">'+price+'</div>';
    infobox = infobox+ '<div class="infobox_details">'+inforooms+' '+infobaths+' '+infosize+'</div></div>';
    
    return infobox;
     
}


/////////////////////////////////////////////////////////////////////////////////////////////////
//  map set search
/////////////////////////////////////////////////////////////////////////////////////////////////  
function wpestate_setOms(gmarkers){
    "use strict";
    for (var i = 0; i < gmarkers.length; i++) {
        if(typeof oms !== 'undefined'){
           oms.addMarker(gmarkers[i]);
        }else{
      
        }
    }
    
}

/////////////////////////////////////////////////////////////////////////////////////////////////
//  map set search
/////////////////////////////////////////////////////////////////////////////////////////////////  

function wpestate_set_google_search(map){
    "use strict";
    if( parseInt(mapbase_vars.wp_estate_kind_of_map) == 2 || jQuery('#google-default-search').length===0 ){
        return;
    }
    
    
    var input,searchBox,places,place;
    
    input = (document.getElementById('google-default-search'));
    searchBox = new google.maps.places.SearchBox(input);
    
   
    google.maps.event.addListener(searchBox, 'places_changed', function() {
    places = searchBox.getPlaces();
        
    if (places.length == 0) {
      return;
    }

    var bounds = new google.maps.LatLngBounds();
    for (var i = 0; place = places[i]; i++) {
        var image = {
            url: place.icon,
            size: new google.maps.Size(71, 71),
            origin: new google.maps.Point(0, 0),
            anchor: new google.maps.Point(17, 34),
            scaledSize: new google.maps.Size(25, 25)
        };

        // Create a marker for each place.
        var marker = new google.maps.Marker({
            map: map,
            icon: image,
            title: place.name,
            position: place.geometry.location
        });

        gmarkers.push(marker);
        bounds.extend(place.geometry.location);

    }

    map.fitBounds(bounds);
    if (!bounds.isEmpty()) {
        wpestate_fit_bounds(bounds);
    }else{
        wpestate_fit_bounds_nolsit();
    }
    map.setZoom(15);
  });

  
    google.maps.event.addListener(map, 'bounds_changed', function() {
    var bounds = map.getBounds();
    searchBox.setBounds(bounds);
  });
    
}

function wpestate_fit_bounds_nolsit(){
    "use strict";
    map.setZoom(3);       
}



function wpestate_fit_bounds(bounds){
    "use strict";
    if(placeCircle!=''){
        map.fitBounds(placeCircle.getBounds());
    }else{
         map.fitBounds(bounds);
        google.maps.event.addListenerOnce(map, 'idle', function() {
            if( map.getZoom()>15 ) {
                map.setZoom(15);
            }
        });
    }

  
}


/////////////////////////////////////////////////////////////////////////////////////////////////
//  open close map
/////////////////////////////////////////////////////////////////////////////////////////////////  

function wpestate_new_open_close_map(type){
    "use strict";
    if( jQuery('#gmap_wrapper').hasClass('fullmap') ){
        return;
    }
    
    if(mapfunctions_vars.open_close_status !== '1'){ // we can resize map
        
        var current_height  =   jQuery('#googleMap').outerHeight();
        var closed_height   =   parseInt(mapfunctions_vars.closed_height,10);
        var open_height     =   parseInt(mapfunctions_vars.open_height,10);
        var googleMap_h     =   open_height;
        var gmapWrapper_h   =   open_height;
          
        if( infoBox!== null){
            infoBox.close(); 
        }
     
        if ( current_height === closed_height )  {                       
            googleMap_h = open_height;                                
            if (Modernizr.mq('only all and (max-width: 940px)')) {
               gmapWrapper_h = open_height;
            } else {
                jQuery('#gmap-menu').show(); 
                gmapWrapper_h = open_height;
            }
        
            wpestate_new_show_advanced_search();
            vertical_off=0;
            jQuery('#openmap').empty().append('<i class="fas fa-angle-up"></i>'+mapfunctions_vars.close_map);

        } else if(type===2) {
            jQuery('#gmap-menu').hide();
            jQuery('#advanced_search_map_form').hide();
            googleMap_h = gmapWrapper_h = closed_height;
           
            // hide_advanced_search();
            wpestate_new_hide_advanced_search();
            vertical_off=150;           
        }
        jQuery('#gmap_wrapper').css('height', gmapWrapper_h+'px');
        jQuery('#googleMap').css('height', googleMap_h+'px');
        jQuery('.tooltip').fadeOut("fast");
        
        if(wp_estate_kind_of_map===1){
            setTimeout(function(){google.maps.event.trigger(map, "resize"); }, 300);
        }
    }
}





/////////////////////////////////////////////////////////////////////////////////////////////////
//  build map cluter
/////////////////////////////////////////////////////////////////////////////////////////////////   
function wpestate_map_cluster(){
    "use strict";
    if(mapfunctions_vars.user_cluster==='yes'){
        clusterStyles = [
            {
            textColor: '#ffffff',    
            opt_textColor: '#ffffff',
            url: images['cloud_pin'],
            height: 72,
            width: 72,
            textSize:15,
           
            }
        ];
        mcOptions = {gridSize: 50,
                    ignoreHidden:true, 
                    maxZoom: parseInt( mapfunctions_vars.zoom_cluster,10), 
                    styles: clusterStyles
                };
        mcluster = new MarkerClusterer(map, gmarkers, mcOptions);
        mcluster.setIgnoreHidden(true);
    }
   
}  
    
    
      
/////////////////////////////////////////////////////////////////////////////////////////////////
/// zoom
/////////////////////////////////////////////////////////////////////////////////////////////////
  
    
if(  document.getElementById('gmapzoomplus') ){
    jQuery('#gmapzoomplus').on('click',function(){   
        "use strict";
        var current= parseInt( map.getZoom(),10);
        current++;
        if(current>20){
            current=20;
        }
        map.setZoom(current);
    });  
}
    
    
if(  document.getElementById('gmapzoomminus') ){
    jQuery('#gmapzoomminus').on('click',function(){
        "use strict";
        var current= parseInt( map.getZoom(),10);
        current--;
        if(current<0){
            current=0;
        }
        map.setZoom(current);
    });  
}
        
    
    
/////////////////////////////////////////////////////////////////////////////////////////////////
/// geolocation
/////////////////////////////////////////////////////////////////////////////////////////////////

if(  document.getElementById('geolocation-button') ){
    jQuery('#geolocation-button').on('click',function(){
        "use strict";
        wpestate_myposition(map);
        wpestate_close_adv_search();
    });  
}


if(  document.getElementById('mobile-geolocation-button') ){
    jQuery('#mobile-geolocation-button').on('click',function(){
        "use strict";
        wpestate_myposition(map);
        wpestate_close_adv_search();
    });  
}





function wpestate_myposition(map){    
    "use strict";
    if(navigator.geolocation){
        var latLong;
        if (location.protocol === 'https:') {
            navigator.geolocation.getCurrentPosition(wpestate_showMyPosition_original,wpestate_errorCallback,{timeout:10000});
        }else{
            jQuery.getJSON("http://ipinfo.io", function(ipinfo){
                latLong = ipinfo.loc.split(",");
                wpestate_showMyPosition (latLong);
            });
        }
      
    }else{
        alert(mapfunctions_vars.geo_no_brow);
    }
}


function wpestate_errorCallback(){
    "use strict";
    alert(mapfunctions_vars.geo_no_pos);
}




function wpestate_showMyPosition_original(pos){
    "use strict";
    if(wp_estate_kind_of_map===1){
        var shape = {
           coord: [1, 1, 1, 38, 38, 59, 59 , 1],
           type: 'poly'
        }; 

        var MyPoint=  new google.maps.LatLng( pos.coords.latitude, pos.coords.longitude);
        map.setCenter(MyPoint);   

        var marker = new google.maps.Marker({
                 position: MyPoint,
                 map: map,
                 icon: wpestate_custompinchild(),
                 shape: shape,
                 title: '',
                 zIndex: 999999999,
                 image:'',
                 price:'',
                 category:'',
                 action:'',
                 link:'' ,
                 infoWindowIndex : 99 ,
                 radius: parseInt(mapfunctions_vars.geolocation_radius,10)+' '+mapfunctions_vars.geo_message
                });

        var populationOptions = {
            strokeColor: '#67cfd8',
            strokeOpacity: 0.6,
            strokeWeight: 1,
            fillColor: '#67cfd8',
            fillOpacity: 0.2,
            map: map,
            center: MyPoint,
            radius: parseInt(mapfunctions_vars.geolocation_radius,10)
        };

        var cityCircle = new google.maps.Circle(populationOptions);

        var label = new Label({
            map: map
        });
        label.bindTo('position', marker);
        label.bindTo('text', marker, 'radius');
        label.bindTo('visible', marker);
        label.bindTo('clickable', marker);
        label.bindTo('zIndex', marker);
    }else{
       
        var new_pos=[pos.coords.latitude, pos.coords.longitude];
        wprentals_draw_leaflet_circle(new_pos);
    }

}
    
    
var geo_markers =   [];
var geo_circle  =   [];
var geo_label   =   [];

function wpestate_showMyPosition(pos){
    "use strict";

    if(wp_estate_kind_of_map===1){
        wpresidence_draw_google_circle(pos);
    }else if(wp_estate_kind_of_map===2){
       wprentals_draw_leaflet_circle(pos)
    }  
   
}


function wprentals_draw_leaflet_circle(pos){

    L.circle( [pos[0],pos[1]], parseInt(mapfunctions_vars.geolocation_radius, 10)).addTo(map);
    
    var markerImage = {
            iconUrl: wprentals_custompinchild_leaflet(),
            iconSize: [38, 59],
            iconAnchor: [20, 50],
            popupAnchor: [1, -50]
        };
    var  markerOptions = {
        riseOnHover: true
    };
    
    var markerCenter    =   L.latLng( pos[0], pos[1] );
    markerOptions.icon = L.icon( markerImage );
    L.marker( markerCenter, markerOptions ).addTo( map );
    
    
    var wpresidence_leaflet_label = '<div class="wpresidence_leaflet_label">';
    wpresidence_leaflet_label+=parseInt(mapfunctions_vars.geolocation_radius, 10) + ' ' + mapfunctions_vars.geo_message
    wpresidence_leaflet_label += '</div>';
    
    var myIcon = L.divIcon({ 
            className:'someclass',
            iconSize: new L.Point(0, 0), 
            html: wpresidence_leaflet_label
        });
      
    L.marker( markerCenter, {icon: myIcon} ).addTo( map );
        
        
    map.panTo(markerCenter);
    map.setZoom(10);
}







function wpresidence_draw_google_circle(pos){
     "use strict";
    for (var i = 0; i < geo_markers.length; i++) {
        geo_markers[i].setMap(null);
        geo_circle[i].setMap(null);
        geo_label[i].setMap(null);
    }
    
    geo_markers =   [];  
    geo_circle  =   [];
    geo_label   =   [];
    
    
    var shape = {
        coord: [1, 1, 1, 38, 38, 59, 59 , 1],
        type: 'poly'
    }; 
   
    // var MyPoint=  new google.maps.LatLng( pos.coords.latitude, pos.coords.longitude);
   
    var MyPoint=  new google.maps.LatLng( pos[0], pos[1]);
    map.setCenter(MyPoint);   
    map.setZoom(13);
    var marker = new google.maps.Marker({
            position: MyPoint,
            map: map,
            icon: wpestate_custompinchild(),
            shape: shape,
            title: '',
            zIndex: 999999999,
            image:'',
            price:'',
            category:'',
            action:'',
            link:'' ,
            infoWindowIndex : 99 ,
            radius: parseInt(mapfunctions_vars.geolocation_radius,10)+' '+mapfunctions_vars.geo_message
            });
    geo_markers.push(marker);
    
    
    var populationOptions = {
        strokeColor: '#67cfd8',
        strokeOpacity: 0.6,
        strokeWeight: 1,
        fillColor: '#67cfd8',
        fillOpacity: 0.2,
        map: map,
        center: MyPoint,
        radius: parseInt(mapfunctions_vars.geolocation_radius,10)
    };
    
    
    
    var cityCircle = new google.maps.Circle(populationOptions);
    geo_circle.push(cityCircle);
    
    var label = new Label({
        map: map
    });
        
    label.bindTo('position', marker);
    label.bindTo('text', marker, 'radius');
    label.bindTo('visible', marker);
    label.bindTo('clickable', marker);
    label.bindTo('zIndex', marker);
    geo_label.push(cityCircle);
}
    
    
    
    
    
    
    
    
    
function wpestate_custompinchild(){
    "use strict";

    var custom_img;
    var extension='';
    var ratio = jQuery(window).dense('devicePixelRatio');
    
    if(ratio>1){
        extension='_2x';
    }
    
    
    if( typeof( images['userpin'] )=== 'undefined' ||  images['userpin']===''){
        custom_img= mapfunctions_vars.path+'/'+'userpin'+extension+'.png';     
    }else{
        custom_img=images['userpin'];
        if(ratio>1){
            custom_img=wpestate_get_custom_retina_pin(custom_img);
        }
    }
   
   
    
    
    var   image;
    if(ratio>1){
        image = {
            url: custom_img, 
            size: new google.maps.Size(88, 96),
            scaledSize   :  new google.maps.Size(44, 48),
            origin: new google.maps.Point(0,0),
            anchor: new google.maps.Point(16,59 )
        };
     
    }else{
        image = {
            url: custom_img, 
            size: new google.maps.Size(59, 59),
            origin: new google.maps.Point(0,0),
            anchor: new google.maps.Point(16,59 )
        };
    }
    
    
    return image;
  
}




/////////////////////////////////////////////////////////////////////////////////////////////////
/// 
/////////////////////////////////////////////////////////////////////////////////////////////////

if( document.getElementById('gmap') ){
    google.maps.event.addDomListener(document.getElementById('gmap'), 'mouseout', function () {           
        google.maps.event.trigger(map, "resize");
    });  
}     


if(  document.getElementById('search_map_button') ){
    google.maps.event.addDomListener(document.getElementById('search_map_button'), 'click', function () {  
        infoBox.close();
    });  
}



if(  document.getElementById('advanced_search_map_button') ){
    google.maps.event.addDomListener(document.getElementById('advanced_search_map_button'), 'click', function () {  
       infoBox.close();
    }); 
}
 
////////////////////////////////////////////////////////////////////////////////////////////////
/// navigate troguh pins 
///////////////////////////////////////////////////////////////////////////////////////////////

jQuery('#gmap-next').on( 'click', function(event) {
    "use strict";
    current_place++;  
    external_action_ondemand=1;
    lealet_map_move_on_hover=1;
    
    if (current_place>gmarkers.length){
        current_place=1;
    }
    while(gmarkers[current_place-1].visible===false){
        current_place++; 
        if (current_place>gmarkers.length){
            current_place=1;
        }
    }
    
    if( map.getZoom() <15 ){
        map.setZoom(15);
    }
    
    
   
    
    if(wp_estate_kind_of_map===1){
         google.maps.event.trigger(gmarkers[current_place-1], 'click');
    }else if(wp_estate_kind_of_map===2){
        
        map.setView(gmarkers[current_place - 1].getLatLng());   
        if (! gmarkers[current_place - 1]._icon) {
            gmarkers[current_place - 1].__parent.spiderfy();
        }
            lealet_map_move_on_hover=1;
       
            map.setZoom(20);
           
            if( (current_place - 1)==0 || (current_place - 1)==gmarkers.length ){
                setTimeout(function(){  gmarkers[current_place - 1].fire('click');  }, 1000); 
            }else{
                gmarkers[current_place - 1].fire('click');
            }
           
     
        lealet_map_move_on_hover=1;
        wpestate_map_callback( wpestate_new_open_close_map );
    }
    
});


jQuery('#gmap-prev').on( 'click', function(event) {
    "use strict";
    external_action_ondemand=1;
    lealet_map_move_on_hover=1;
    current_place--;
    if (current_place<1){
        current_place=gmarkers.length;
    }
    while(gmarkers[current_place-1].visible===false){
        current_place--; 
        if (current_place>gmarkers.length){
            current_place=1;
        }
    }
    if( map.getZoom() <15 ){
        map.setZoom(15);
    }
 
    
    if(wp_estate_kind_of_map===1){
        google.maps.event.trigger(gmarkers[current_place-1], 'click');
    }else if(wp_estate_kind_of_map===2){
        map.setView(gmarkers[current_place - 1].getLatLng());   
        if (! gmarkers[current_place - 1]._icon)  gmarkers[current_place - 1].__parent.spiderfy();
            lealet_map_move_on_hover=1;
       
            map.setZoom(20);
           
            if( (current_place - 1)==0 || (current_place )==gmarkers.length ){
                setTimeout(function(){  gmarkers[current_place - 1].fire('click');  }, 1000); 
            }else{
                gmarkers[current_place - 1].fire('click');
            }
           
        lealet_map_move_on_hover=1;
          wpestate_map_callback( wpestate_new_open_close_map );
    }  
    current_place--;  
});








///////////////////////////////////////////////////////////////////////////////////////////////////////////
/// filter pins 
//////////////////////////////////////////////////////////////////////////////////////////////////////////

jQuery('.advanced_action_div li').on( 'click', function(event) {
"use strict";
   var action = jQuery(this).val();
});





if(  document.getElementById('gmap-menu') ){
    google.maps.event.addDomListener(document.getElementById('gmap-menu'), 'click', function (event) {
        "use strict";
        infoBox.close();

        if (event.target.nodeName==='INPUT'){
            category=event.target.className; 

                if(event.target.name==="filter_action[]"){            
                    if(actions.indexOf(category)!==-1){
                        actions.splice(actions.indexOf(category),1);
                    }else{
                        actions.push(category);
                    }
                }

                if(event.target.name==="filter_type[]"){            
                    if(categories.indexOf(category)!==-1){
                        categories.splice(categories.indexOf(category),1);
                    }else{
                        categories.push(category);
                    }
                }

        show(actions,categories);
        }

    }); 
}
 
function wpestate_getCookieMap(cname) {
    "use strict";
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
}



function wpestate_get_custom_value_tab_search(slug){
    "use strict";
    var value='';
    var is_drop=0;
    

    
    if(slug === 'adv_categ' || slug === 'adv_actions' ||  slug === 'advanced_city' ||  slug === 'advanced_area'  ||  slug === 'county-state'){     
        value = jQuery('.tab-pane.active #'+slug).attr('data-value');
    } else if(slug === 'property_price' && mapfunctions_vars.slider_price==='yes'){
        value = jQuery('.tab-pane.active #price_low').val();
    }else if(slug === 'property-country'){
        value = jQuery('.tab-pane.active #advanced_country').attr('data-value');
    }else if(slug === 'property_status'){
         value = jQuery('.tab-pane.active #adv_status').attr('data-value');
    }else if(slug === 'adv_location'){
         value = jQuery('.tab-pane.active .adv_locations_search').val();
    }else{
  
        if(slug!==''){
            if( jQuery('.tab-pane.active #'+slug).hasClass('filter_menu_trigger') ){ 
                value = jQuery('.tab-pane.active #'+slug).attr('data-value');
                is_drop=1;
            }else{
                value = jQuery('.tab-pane.active #'+slug).val() ;
            }
        }
    }
      
    return value;
 
}
  
  
function wpestate_get_custom_value(slug){
    "use strict";
    var value;
    var is_drop=0;
    if(slug === 'adv_categ' || slug === 'adv_actions' ||  slug === 'advanced_city' ||  slug === 'advanced_area'  ||  slug === 'county-state'){     
        value = jQuery('#'+slug).attr('data-value');
    } else if(slug === 'property_price' && mapfunctions_vars.slider_price==='yes'){
        value = jQuery('#price_low').val();
    }else if(slug === 'property_status'){
        value = jQuery('#adv_status').attr('data-value');
    }else if(slug === 'property-country'){
        value = jQuery('#advanced_country').attr('data-value');
    }else if(slug === 'adv_location'){
         value = jQuery('.adv_locations_search').val(); 
    }else{
      
        if( jQuery('#'+slug).hasClass('filter_menu_trigger') ){ 
            value = jQuery('#'+slug).attr('data-value');
            is_drop=1;
        }else{
            value = jQuery('#'+slug).val() ;
            
        }
    }
    
  
    if (typeof(value)!=='undefined'&& is_drop===0){
      //  value=  value .replace(" ","-");
    }
    
    return value;
 
}
  


function wpestate_get_custom_value_onthelist(slug){
    "use strict";
    var value;
    var is_drop=0;
    if(slug === 'adv_categ' || slug === 'adv_actions' ||  slug === 'advanced_city' ||  slug === 'advanced_area'  ||  slug === 'county-state'){     
        value = jQuery('#'+slug).attr('data-value');
        if( slug === 'adv_categ'){
            value =  jQuery('#tax_categ_picked').val();
        }else  if( slug === 'adv_actions'){
            value = jQuery('#tax_action_picked').val();
        }else if( slug === 'advanced_city'){
            value =  jQuery('#tax_city_picked').val();
        }else if( slug === 'advanced_area'){
            value = jQuery('#taxa_area_picked').val();   
        }
         
         
         
    } else if(slug === 'property_price' && mapfunctions_vars.slider_price==='yes'){
        value = jQuery('#price_low').val();
    }else if(slug === 'property-country'){
        value = jQuery('#advanced_country').attr('data-value');
    }else{
      
        if( jQuery('#'+slug).hasClass('filter_menu_trigger') ){ 
            value = jQuery('#'+slug).attr('data-value');
            is_drop=1;
        }else{
            value = jQuery('#'+slug).val() ;
        }
    }
    
    return value;
}
    
  

 
 
 function wpestate_show_pins() {
    "use strict";
  
    jQuery("#results").show();
    jQuery("#results_wrapper").empty().append('<div class="preview_results_loading">'+mapfunctions_vars.loading_results+'</div>').show();
    
    var action, category, city, area, rooms, baths, min_price, price_max, ajaxurl,postid,halfmap, all_checkers,newpage;
     
    if(  typeof infoBox!=='undefined' && infoBox!== null ){
        infoBox.close(); 
    }

    jQuery('#gmap-loading').show();
    //- removed &&  googlecode_regular_vars.is_adv_search!=='1'
    
    if( typeof(googlecode_regular_vars)!='undefined' ) {
        if( (mapfunctions_vars.adv_search_type==='8' || mapfunctions_vars.adv_search_type==='9') &&  mapfunctions_vars.is_half_map_list!=='1'   ){
            wpestate_show_pins_type2_tabs();
            return;
        }
        
        if(mapfunctions_vars.adv_search_type==='2' && mapfunctions_vars.is_half_map_list!=='1' &&  mapfunctions_vars.is_adv_search!=='1' ){
            wpestate_show_pins_type2();
            return;
        }
    }else{
        if( (mapfunctions_vars.adv_search_type==='8' || mapfunctions_vars.adv_search_type==='9')   ){
            wpestate_show_pins_type2_tabs();
            return;
        }
        
        if(mapfunctions_vars.adv_search_type==='2' && mapfunctions_vars.is_half_map_list!=='1'  ){
            wpestate_show_pins_type2();
            return;
        }
    }
    
    
  
    if(mapfunctions_vars.custom_search==='yes'){
       wpestate_show_pins_custom_search();
       return;
    }    

    
  
    action      =   jQuery('#adv_actions').attr('data-value');
    category    =   jQuery('#adv_categ').attr('data-value');
    city        =   jQuery('#advanced_city').attr('data-value');
    area        =   jQuery('#advanced_area').attr('data-value');
    rooms       =   parseFloat(jQuery('#adv_rooms').val(), 10);
    baths       =   parseFloat(jQuery('#adv_bath').val(), 10);
    min_price   =   parseFloat(jQuery('#price_low').val(), 10);
    price_max   =   parseFloat(jQuery('#price_max').val(), 10);
    postid      =   parseFloat(jQuery('#adv-search-1').attr('data-postid'), 10);
    ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
     
  
    
    if ( parseInt(mapfunctions_vars.is_half)===1 ){
        if(first_time_wpestate_show_inpage_ajax_half===0){
            first_time_wpestate_show_inpage_ajax_half=1;
        }else{
            wpestate_show_inpage_ajax_half();
        }
     
    } 
     
    all_checkers = '';
    jQuery('.search_wrapper .extended_search_check_wrapper  input[type="checkbox"]').each(function () {
        if (jQuery(this).is(":checked")) {
            all_checkers = all_checkers + "," + jQuery(this).attr("name-title");
        }
    });
    
    halfmap     =   0;
    newpage     =   0;
    if( jQuery('#google_map_prop_list_sidebar').length ){
        halfmap    = 1;
    }   
  
    postid=1;
    if(  document.getElementById('search_wrapper') ){
        postid      =   parseInt(jQuery('#search_wrapper').attr('data-postid'), 10);
    }
   
   
    var geo_lat     =   '';
    var geo_long    =   '';
    var geo_rad     =   '';
    
    if( jQuery("#geolocation_search").length > 0){    
        geo_lat     =   jQuery('#geolocation_lat').val();
        geo_long    =   jQuery('#geolocation_long').val();
        geo_rad     =   jQuery('#geolocation_radius').val();

    }
 
    var nonce = jQuery('#wpestate_ajax_filtering').val();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action'            :   'wpestate_classic_ondemand_pin_load',
            'action_values'     :   action,
            'category_values'   :   category,
            'city'              :   city,
            'area'              :   area,
            'advanced_rooms'    :   rooms,
            'advanced_bath'     :   baths,
            'price_low'         :   min_price,
            'price_max'         :   price_max,
            'newpage'           :   newpage,
            'postid'            :   postid,
            'halfmap'           :   halfmap,
            'all_checkers'      :   all_checkers,
            'geo_lat'           :   geo_lat,
            'geo_long'          :   geo_long,
            'geo_rad'           :   geo_rad,
            'security'          :   nonce
        },
        success: function (data) { 
            var no_results = parseInt(data.no_results);
           
            if(no_results!==0){
                wpestate_load_on_demand_pins(data.markers,no_results,1);
            }else{
                wpestate_show_no_results();
            }
               jQuery('#gmap-loading').hide();
          
        },
        error: function (errorThrown) {
          
        }
    });//end ajax     
    
 }
 
 
 
 
 
function wpestate_show_pins_type2(){
    "use strict";
    var action, category, location_search, ajaxurl,postid,halfmap, all_checkers,newpage;
    action      =   jQuery('#adv_actions').attr('data-value');
    category    =   jQuery('#adv_categ').attr('data-value');
    location_search    =   jQuery('#adv_location').val();
    postid      =   parseInt(jQuery('#adv-search-1').attr('data-postid'), 10);
    ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
   
    halfmap     =   0;
    newpage     =   0;
    
    if( jQuery('#google_map_prop_list_sidebar').length ){
        halfmap    = 1;
    }   
  
    postid=1;
    
    if(  document.getElementById('search_wrapper') ){
        postid      =   parseInt(jQuery('#search_wrapper').attr('data-postid'), 10);
    }
    var nonce = jQuery('#wpestate_ajax_filtering').val();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
     
        data: {
            'action'            :   'wpestate_classic_ondemand_pin_load_type2',
            'action_values'     :   action,
            'category_values'   :   category,
            'location'          :   location_search,
            'security'          :   nonce
        },
        success: function (data) { 
            var no_results = parseInt(data.no_results);
            
            if(no_results!==0){
                wpestate_load_on_demand_pins(data.markers,no_results,1);
            }else{
                wpestate_show_no_results();
            }
            jQuery('#gmap-loading').hide();
          
        },
        error: function (errorThrown) {
        }
    });//end ajax 
    
       
    if ( parseInt(mapfunctions_vars.is_half)===1 ){
        if(first_time_wpestate_show_inpage_ajax_half===0){
            first_time_wpestate_show_inpage_ajax_half=1;
        }else{
            wpestate_show_inpage_ajax_half();
        }
     
    } 
 }
 
 
 

 
 
function wpestate_show_pins_type2_tabs(){
    "use strict";
    var action, category, location_search, ajaxurl,postid,halfmap, all_checkers,newpage,picked_tax;
     
    action              =   jQuery('.tab-pane.active #adv_actions').attr('data-value');
    if(typeof action === 'undefined'){
        action='';
    }
    category            =   jQuery('.tab-pane.active #adv_categ').attr('data-value');
    if(typeof category === 'undefined'){
        category='';
    }
    location_search     =   jQuery('.tab-pane.active #adv_location').val();
    picked_tax          =   jQuery('.tab-pane.active .picked_tax').val();
    
    
    postid      =   parseInt(jQuery('#adv-search-1').attr('data-postid'), 10);
    ajaxurl     =   ajaxcalls_vars.admin_url + 'admin-ajax.php';
    ajaxurl     =   ajaxcalls_vars.wpestate_ajax;   
    halfmap     =   0;
    newpage     =   0;
   
    
    if( jQuery('#google_map_prop_list_sidebar').length ){
        halfmap    = 1;
    }   
  
    postid=1;
    
    if(  document.getElementById('search_wrapper') ){
        postid      =   parseInt(jQuery('#search_wrapper').attr('data-postid'), 10);
    }
   
    var term_id=jQuery('.tab-pane.active .term_id_class').val();   
      
    all_checkers = '';
    jQuery('.tab-pane.active .extended_search_check_wrapper input[type="checkbox"]').each(function () {
        if (jQuery(this).is(":checked")) {
            all_checkers = all_checkers + "," + jQuery(this).attr("name-title");
        }
    });
   
    var nonce = jQuery('#wpestate_ajax_filtering').val();
   
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
     
        data: {
            'action'            :   'wpestate_classic_ondemand_pin_load_type2_tabs',
            'action_values'     :   action,
            'category_values'   :   category,
            'location'          :   location_search,
            'picked_tax'        :   picked_tax,
            'all_checkers'      :   all_checkers,
            'security'          :   nonce
        },
        success: function (data) { 
       
            var no_results = parseInt(data.no_results);
            
            if(no_results!==0){
                wpestate_load_on_demand_pins(data.markers,no_results,1);
            }else{
                wpestate_show_no_results();
            }
               jQuery('#gmap-loading').hide();
          
        },
        error: function (errorThrown) {
           
        }
    });//end ajax 
    
    if ( parseInt(mapfunctions_vars.is_half)===1 ){
        if(first_time_wpestate_show_inpage_ajax_half===0){
            first_time_wpestate_show_inpage_ajax_half=1;
        }else{
            wpestate_show_inpage_ajax_half();
        }
     
    } 
 }
 

function wpestate_show_pins_custom_search(){
    "use strict";
    
   
   
    var ajaxurl,initial_array_last_item,array_last_item,how_holder,slug_holder,val_holder,position, inserted_val,temp_val,term_id,halfmap,newpage,postid,slider_min,slider_max;
    ajaxurl             =   ajaxcalls_vars.wpestate_ajax;;   
    inserted_val        =   0;
    array_last_item     =   parseInt( mapfunctions_vars.fields_no,10);
    initial_array_last_item =array_last_item;
    val_holder          =   [];
    slug_holder         =   [];
    how_holder          =   [];
 
    slug_holder         =   mapfunctions_vars.slugs;
    how_holder          =   mapfunctions_vars.hows;
    var term_counter=0;
   

    
    if( mapfunctions_vars.slider_price ==='yes' ){
        slider_min = jQuery('#price_low').val();
        slider_max = jQuery('#price_max').val();
 
    }
   
    var i;
    term_counter=parseInt( jQuery('.tab-pane.active').find('.term_counter').val(),10);
       

 
    
    if( (mapfunctions_vars.adv_search_type==='6' || mapfunctions_vars.adv_search_type==='7' ) ){ //&&  !jQuery('.halfsearch')[0]
        term_id=jQuery('.tab-pane.active .term_id_class').val();   
     
        if( mapfunctions_vars.slider_price ==='yes' ){
            slider_min = jQuery('#price_low_'+term_id).val();
            slider_max = jQuery('#price_max_'+term_id).val();
        }
    
     
        var start_counter = term_counter *mapfunctions_vars.fields_no;
      
      
        
        if(term_counter>0){
            array_last_item=(array_last_item*term_counter)+array_last_item;
 
        }
       
        
        for ( i=start_counter; i<array_last_item;i++){
       
            if ( how_holder[i]=='date bigger' || how_holder[i]=='date smaller'){
                temp_val = wpestate_get_custom_value_tab_search (term_id+slug_holder[i]);
            }else{
                temp_val = wpestate_get_custom_value_tab_search (slug_holder[i]);
            }
            
            if(typeof(temp_val)==='undefined'){
                temp_val='';
            }
            val_holder.push(  temp_val );
           
        }
        
       
        
    }else{
        for (i=0; i<array_last_item;i++){
            temp_val = wpestate_get_custom_value (slug_holder[i]);
            if(typeof(temp_val)==='undefined'){
                temp_val='';
            }
            val_holder.push(  temp_val );
        }
       
    }
  
       

    if( (mapfunctions_vars.adv_search_type==='6' || mapfunctions_vars.adv_search_type==='7' || mapfunctions_vars.adv_search_type==='8' || mapfunctions_vars.adv_search_type==='9' ) ){
        var tab_tax=jQuery('.adv_search_tab_item.active').attr('data-tax');
        
      
        if( jQuery('.halfsearch')[0] ){
            tab_tax=jQuery('.halfsearch').attr('data-tax');
        }
       
        
        if(tab_tax === 'property_category'){
            slug_holder[array_last_item]='adv_categ';
        }else if(tab_tax === 'property_action_category'){
            slug_holder[array_last_item]='adv_actions';
        }else if(tab_tax === 'property_city'){
            slug_holder[array_last_item]='advanced_city';
        }else if(tab_tax === 'property_area'){
            slug_holder[array_last_item]='advanced_area';
        }else if(tab_tax === 'property_county_state'){
            slug_holder[array_last_item]='county-state';
        }
        
        how_holder[array_last_item]='like';
  
      
        val_holder[initial_array_last_item]=jQuery('.adv_search_tab_item.active').attr('data-term');

 
    }
    

    if ( parseInt(mapfunctions_vars.is_half)===1 ){
        if(first_time_wpestate_show_inpage_ajax_half===0){
            first_time_wpestate_show_inpage_ajax_half=1;
        }else{
            wpestate_show_inpage_ajax_half();
        }
     
    } 
    //was 2 times !
      
    var   all_checkers = '';
 
     if( mapfunctions_vars.adv_search_type==='6' ){
        jQuery('.tab-pane.active .extended_search_check_wrapper  input[type="checkbox"]').each(function () {
            if (jQuery(this).is(":checked")) {
                all_checkers = all_checkers + "," + jQuery(this).attr("name-title");
            }
        });
    }else{
    
        jQuery('.search_wrapper .extended_search_check_wrapper  input[type="checkbox"]').each(function () {
            if (jQuery(this).is(":checked")) {
                all_checkers = all_checkers + "," + jQuery(this).attr("name-title");
            }
        });
    }
    
    
    
 
    
    halfmap     =   0;
    newpage     =   0;
    if( jQuery('#google_map_prop_list_sidebar').length ){
        halfmap    = 1;
    }   
  
    postid=1;
    if(  document.getElementById('search_wrapper') ){
        postid      =   parseInt(jQuery('#search_wrapper').attr('data-postid'), 10);
    }
    
    var filter_search_action10 ='';
    var adv_location10 ='';
    
    if( mapfunctions_vars.adv_search_type==='10' ){
        filter_search_action10   = jQuery('#adv_actions').attr('data-value');
        adv_location10           = jQuery('#adv_location').val();
     
    }
    
 
    var filter_search_action11  =   '';
    var filter_search_categ11   =   '';
    var keyword_search          =   '';
    if( mapfunctions_vars.adv_search_type==='11' ){
        filter_search_action11      = jQuery('#adv_actions').attr('data-value');
        filter_search_categ11       = jQuery('#adv_categ').attr('data-value');
        keyword_search              = jQuery('#keyword_search').val();
    }
    
  
    var geo_lat     =   '';
    var geo_long    =   '';
    var geo_rad     =   '';
    
    if( jQuery("#geolocation_search").length > 0){    
        geo_lat     =   jQuery('#geolocation_lat').val();
        geo_long    =   jQuery('#geolocation_long').val();
        geo_rad     =   jQuery('#geolocation_radius').val();

    }
 
 
    var nonce = jQuery('#wpestate_ajax_filtering').val();
    jQuery.ajax({
        type: 'POST',
        url: ajaxurl,
        dataType: 'json',
        data: {
            'action'                    :   'wpestate_custom_ondemand_pin_load',
            'search_type'               :   mapfunctions_vars.adv_search_type,
            'val_holder'                :   val_holder,
            'newpage'                   :   newpage,
            'postid'                    :   postid,
            'halfmap'                   :   halfmap,
            'slider_min'                :   slider_min,
            'slider_max'                :   slider_max,
            'all_checkers'              :   all_checkers,
            'filter_search_action10'    :   filter_search_action10,
            'adv_location10'            :   adv_location10,
            'filter_search_action11'    :   filter_search_action11,
            'filter_search_categ11'     :   filter_search_categ11,
            'keyword_search'            :   keyword_search,
            'geo_lat'                   :   geo_lat,
            'geo_long'                  :   geo_long,
            'geo_rad'                   :   geo_rad,
            'term_counter'              :   term_counter,
            'security'                  :   nonce
        },
        success: function (data) { 
        

            var no_results = parseInt(data.no_results);
            if(no_results!==0){
                wpestate_load_on_demand_pins(data.markers,no_results,1);
            }else{
                wpestate_show_no_results();
            }
            jQuery('#gmap-loading').hide();
          
        },
        error: function (errorThrown) {
         
            
        }
    });//end ajax     
     

 }
 
 
  
 
function wpestate_empty_map(){
    "use strict";
    if (typeof gmarkers !== 'undefined') {
       
        if(wp_estate_kind_of_map== 1 ){
            for (var i = 0; i < gmarkers.length; i++) {
                gmarkers[i].setVisible(false);
                gmarkers[i].setMap(null);
            }
            gmarkers = [];


            if( typeof (mcluster)!=='undefined'){
                mcluster.clearMarkers();  
            }
        }  else if (wp_estate_kind_of_map==2){
            if(typeof map !='undefined'){
                if (mapfunctions_vars.user_cluster === 'yes') {
                    map.removeLayer(markers_cluster);
                }else{
                    for (var i = 0; i < gmarkers.length; i++) {
                        map.removeLayer(gmarkers[i]);
                    }
                }
                gmarkers = [];  
                markers_cluster=L.markerClusterGroup({
                    showCoverageOnHover: false,
                    iconCreateFunction: function(cluster) {
                        return L.divIcon({ html: '<div class="leaflet_cluster">' + cluster.getChildCount() + '</div>' });
                    },       
                });
                map.addLayer(markers_cluster);
            }
        }
    }
} 
 
 
 
function wpestate_load_on_demand_pins(markers,no_results,show_results_bar){
    "use strict";
    jQuery('#gmap-noresult').hide(); 

    wpestate_empty_map();
    if(  document.getElementById('googleMap') ){
        //wpestate_setMarkers(map, markers);
        bounds_list =undefined;
        wpresidence_map_general_set_markers(map, markers,1);
        
        wpestate_preview_listings(markers);
        
        //set map cluster
        wpresidence_map_general_cluster();
        
        wpresidence_map_general_fit_to_bounds(1);
      
    }else{
        wpestate_preview_listings(markers);
    }

    if( jQuery("#geolocation_search").length > 0 && initialGeop === 0){
        var place_lat = jQuery('#geolocation_lat').val();
        var place_lng = jQuery('#geolocation_long').val();

        if(place_lat!=='' && place_lng!=''){
            initialGeop=1;
            wpestate_geolocation_marker(place_lat,place_lng);
        }
    }
} 


function  wpestate_preview_listings(markers){
    "use strict";
    var i           =   0;
    var to_append   =   '';
    var image       =   '';
    var title       =   '';
    var link        =   '';
    var clean_price =   '';
    var price       =   '';
    for (i = 0; i < markers.length; i++) {
        image       =   decodeURIComponent(markers[i][18]);
        title       =   decodeURIComponent(markers[i][0]);
        link        =   decodeURIComponent(markers[i][9]);
        clean_price =   decodeURIComponent(markers[i][11]);
        price       =   wpestate_get_price_currency ( decodeURIComponent(markers[i][5]),clean_price );
            
        to_append=to_append+'<div class="preview_listing_unit" data-href="'+link+'">'+image+' <h4>'+title+'</h4><div class="preview_details">'+price+'</div></div>';
     
      
    }
    
    jQuery('#results_wrapper').empty();
    jQuery('#results_no').show().text( markers.length);

    jQuery('#results_wrapper').append(to_append);
    
    jQuery('.preview_listing_unit').on( 'click', function(event) {
        event.preventDefault();
        var new_link;
        new_link =  jQuery(this).attr('data-href');
        window.open (new_link,'_self',false);
    });
    
    
}


function wpestate_get_price_currency(price,clean_price){
    "use strict";
    var new_price ='';
     
    var my_custom_curr_symbol  =   decodeURIComponent ( wpestate_getCookie_map('my_custom_curr_symbol') );
    var my_custom_curr_coef    =   parseFloat( wpestate_getCookie_map('my_custom_curr_coef'));
    var my_custom_curr_pos     =   parseFloat( wpestate_getCookie_map('my_custom_curr_pos'));
    var my_custom_curr_cur_post=   wpestate_getCookie_map('my_custom_curr_cur_post');
    var slider_counter = 0;
    
 
    if (!isNaN(my_custom_curr_pos) && my_custom_curr_pos !== -1) {
        var temp_price =Number(clean_price*my_custom_curr_coef).toFixed(2);
        if (my_custom_curr_cur_post === 'before') {
            new_price = my_custom_curr_symbol+' '+temp_price;
        } else {
            new_price = temp_price+' '+my_custom_curr_symbol;
        }

    } else {
        new_price=price;
    }
        
    return new_price;
}

function wpestate_getCookie_map(cname) {
    "use strict";
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i<ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) == 0) return c.substring(name.length,c.length);
    }
    return "";
   }



function wpestate_show_no_results(){
    "use strict";
    jQuery('#results_no').show().text('0');
 
    jQuery("#results_wrapper").empty().append('<div class="preview_results_loading">'+mapfunctions_vars.half_no_results+'</div>').show();
    jQuery('#gmap-noresult').show();
    if(  document.getElementById('google_map_prop_list_wrapper') ){
        jQuery('#listing_ajax_container').empty().append('<p class=" no_results_title ">'+mapfunctions_vars.half_no_results+'</p>');
    }
}



function wpestate_show_inpage_ajax_tip2(){
    "use strict";
    if( jQuery('#gmap-full').hasClass('spanselected')){
        jQuery('#gmap-full').trigger('click');
    }


    if(mapfunctions_vars.custom_search==='yes'){
        wpestate_custom_search_start_filtering_ajax(1);
    }else{
        wpestate_start_filtering_ajax(1);  
    } 
}
 
 
 
function wpestate_show_inpage_ajax_half(){
    "use strict";
    jQuery('.half-pagination').remove();
    if(mapfunctions_vars.custom_search==='yes'){
        wpestate_custom_search_start_filtering_ajax(1);
    }else{
        wpestate_start_filtering_ajax(1);  
    } 
}


function wpestate_enable_half_map_pin_action (){
    "use strict";
    jQuery('#google_map_prop_list_sidebar .listing_wrapper').on({
        mouseenter: function () {
            var listing_id = jQuery(this).attr('data-listid');
            wpestate_hover_action_pin(listing_id);
        },
        mouseleave: function () {
             var listing_id = jQuery(this).attr('data-listid');         
            wpestate_return_hover_action_pin(listing_id);
        }
    });
}
    
    
/////////////////////////////////////////////////////////////////////////////////////////////////
/// get pin image
/////////////////////////////////////////////////////////////////////////////////////////////////
function wpestate_convertToSlug(Text){
    "use strict";
    return Text
        .toLowerCase()
        .replace(/ /g,'-')
        .replace(/[^\w-]+/g,'')
        ;
}




function wpestate_get_custom_retina_pin(custom_img){
    "use strict";
    var custom_img_retina;
    custom_img_retina=custom_img.replace(".png","_2x.png");
            
    jQuery.get(custom_img_retina)
        .done(function() { 
            custom_img = custom_img_retina;
        }).fail(function() { 
        });
    return custom_img;              
}





function wpestate_custompin(image){
    "use strict";    
  
    var extension='';
    var ratio = jQuery(window).dense('devicePixelRatio');
    if(ratio>1){
        extension='_2x';
    }
    var custom_img;
    
  
    
    if(mapfunctions_vars.use_single_image_pin==='no'){
        if(image!==''){
            if( typeof( images[image] )=== 'undefined' || images[image]===''){
                custom_img= mapfunctions_vars.path+'/'+image+extension+'.png';     
            }else{
                custom_img=images[image];   

                if(ratio>1){
                    custom_img =wpestate_get_custom_retina_pin(custom_img);
                }
            }
        }else{
            custom_img= mapfunctions_vars.path+'/none.png';   
        }

        if(typeof (custom_img)=== 'undefined'){
            custom_img= mapfunctions_vars.path+'/none.png'; 
        }
    }else{
      
        if(ratio>1){
            custom_img= wpestate_get_custom_retina_pin(  images['single_pin'] );
        }else{
            custom_img= images['single_pin']; 
        }
    }
   

    if(ratio>1){
        image = {
            url: custom_img, 
            size :  new google.maps.Size(118, 118),
            scaledSize   :  new google.maps.Size(44, 48),
            origin: new google.maps.Point(0,0),
            anchor: new google.maps.Point(16,49 ),
            optimized:false
        };
     
    }else{
        image = {
            url: custom_img, 
            size :  new google.maps.Size(59, 59),
            origin: new google.maps.Point(0,0),
            anchor: new google.maps.Point(16,49 )
        };
    }
    return image;
}


/////////////////////////////////////////////////////////////////////////////////////////////////
//// Circle label
/////////////////////////////////////////////////////////////////////////////////////////////////

function Label(opt_options) {
    "use strict";
    // Initialization
    this.setValues(opt_options);


    // Label specific
    var span = this.span_ = document.createElement('span');
    span.style.cssText = 'position: relative; left: -50%; top: 8px; ' +
    'white-space: nowrap;  ' +
    'padding: 2px; background-color: white;opacity:0.7';


    var div = this.div_ = document.createElement('div');
    div.appendChild(span);
    div.style.cssText = 'position: absolute; display: none';
}


if (typeof google !== 'undefined') {
    Label.prototype = new google.maps.OverlayView;
}

// Implement onAdd
Label.prototype.onAdd = function() {
    "use strict";
    var pane = this.getPanes().overlayImage;
    pane.appendChild(this.div_);


  // Ensures the label is redrawn if the text or position is changed.
    var me = this;
    this.listeners_ = [
        google.maps.event.addListener(this, 'position_changed', function() { me.draw(); }),
        google.maps.event.addListener(this, 'visible_changed', function() { me.draw(); }),
        google.maps.event.addListener(this, 'clickable_changed', function() { me.draw(); }),
        google.maps.event.addListener(this, 'text_changed', function() { me.draw(); }),
        google.maps.event.addListener(this, 'zindex_changed', function() { me.draw(); }),
        google.maps.event.addDomListener(this.div_, 'click', function() { 
            if (me.get('clickable')) {
              google.maps.event.trigger(me, 'click');
            }
        })
    ];
};


// Implement onRemove
Label.prototype.onRemove = function() {
    "use strict";
    this.div_.parentNode.removeChild(this.div_);


    // Label is removed from the map, stop updating its position/text.
    for (var i = 0, I = this.listeners_.length; i < I; ++i) {
      google.maps.event.removeListener(this.listeners_[i]);
    }
};


// Implement draw
Label.prototype.draw = function() {
    "use strict";
    var projection = this.getProjection();
    var position = projection.fromLatLngToDivPixel(this.get('position'));


    var div = this.div_;
    div.style.left = position.x + 'px';
    div.style.top = position.y + 'px';


    var visible = this.get('visible');
    div.style.display = visible ? 'block' : 'none';


    var clickable = this.get('clickable');
    this.span_.style.cursor = clickable ? 'pointer' : '';


    var zIndex = this.get('zIndex');
    div.style.zIndex = zIndex;


    this.span_.innerHTML = this.get('text').toString();
};



/////////////////////////////////////////////////////////////////////////////////////////////////
/// close advanced search
/////////////////////////////////////////////////////////////////////////////////////////////////
function wpestate_close_adv_search(){  
    "use strict";
}

//////////////////////////////////////////////////////////////////////
/// show advanced search
//////////////////////////////////////////////////////////////////////


function wpestate_new_show_advanced_search(){
    "use strict";
    jQuery("#search_wrapper").removeClass("hidden");
}

function wpestate_new_hide_advanced_search(){
    "use strict";
    if( mapfunctions_vars.show_adv_search ==='no' ){
        jQuery("#search_wrapper").addClass("hidden"); 
    }

}

function wpestate_hover_action_pin(listing_id){
    "use strict";
    for (var i = 0; i < gmarkers.length; i++) {        
        if ( parseInt( gmarkers[i].idul,10) === parseInt( listing_id,10) ){
            if(wp_estate_kind_of_map===1){
                google.maps.event.trigger(gmarkers[i], 'click');
                
                if(mapfunctions_vars.useprice !== 'yes'){
                    pin_hover_storage=gmarkers[i].icon;
                    gmarkers[i].setIcon(wpestate_custompinhover());
                }
            }else if(wp_estate_kind_of_map===2){
          
                lealet_map_move_on_hover=1;
                if (! gmarkers[i]._icon)  gmarkers[i].__parent.spiderfy();
                map.panTo(  gmarkers[i].getLatLng());
                gmarkers[i].togglePopup();
                
                if(mapfunctions_vars.useprice !== 'yes'){
                    gmarkers[i].setIcon(wpestate_custompinhover());
                }
            
               
            }            
          
        }
    }
}

function wpestate_return_hover_action_pin(listing_id){
    "use strict";
    for (var i = 0; i < gmarkers.length; i++) {  
        if ( parseInt( gmarkers[i].idul,10) === parseInt( listing_id,10) ){
            
            if(wp_estate_kind_of_map===1){
                if (parseInt(gmarkers[i].idul, 10) === parseInt(listing_id, 10)) {
                    infoBox.close();
                    if(mapfunctions_vars.useprice !== 'yes'){
                        gmarkers[i].setIcon(pin_hover_storage);
                    }
                }
            }  else if(wp_estate_kind_of_map===2){
               
                gmarkers[i].togglePopup(); 
                lealet_map_move_on_hover=0;
                if(mapfunctions_vars.useprice !== 'yes'){
                    var markerImage      = L.icon({
                        iconUrl: wprentals_custompin_leaflet(gmarkers[i].pin),
                        iconSize: [44, 50],
                        iconAnchor: [20, 50],
                        popupAnchor: [1, -50]
                    });
                    gmarkers[i].setIcon(markerImage);
                }
            }
   
           
        }
    }
    
}


function wpestate_custompinhover(){
    "use strict";    
 
    var custom_img,image;
    var extension='';
    var ratio = jQuery(window).dense('devicePixelRatio');
    
    if(ratio>1){
        extension='_2x';
    }
    custom_img= mapfunctions_vars.path+'/hover'+extension+'.png'; 
    
    if(wp_estate_kind_of_map===2){
       if(ratio>1){
            
            var markerImage    = L.icon({
                iconUrl: custom_img,
                iconSize: [90, 90],
                iconAnchor: [40, 90],
                popupAnchor: [1, -90]
            });
       }else{
            var markerImage    = L.icon({
                iconUrl: custom_img,
                iconSize: [44, 50],
                iconAnchor: [20, 50],
                popupAnchor: [1, -50]
            });
        }
        return markerImage;
       
    }
    
    
    if(ratio>1){
  
        image = {
            url: custom_img, 
            size :  new google.maps.Size(132, 144),
            scaledSize   :  new google.maps.Size(66, 72),
            origin: new google.maps.Point(0,0),
            anchor: new google.maps.Point(25,72 )
          };
    
    }else{
        image = {
            url: custom_img, 
            size: new google.maps.Size(90, 90),
            origin: new google.maps.Point(0,0),
            anchor: new google.maps.Point(25,72 )
        };
    }
   
    
    return image;
}




function wpestate_map_callback(callback){
    "use strict";
    callback(1);
}




var wpestate_initialize_poi = function ( map_for_poi,what){
    "use strict";
    
    
    if( parseInt(mapbase_vars.wp_estate_kind_of_map) == 2 || typeof(google.maps.places)==='undefined'){
        return;
    }
    var poi_service         =   new google.maps.places.PlacesService( map_for_poi );
    var already_serviced    =   '';
    var show_poi            =   '';
    var map_bounds          =   map_for_poi.getBounds();
    var selector            =   '.google_poi';
    if(what==2){
        selector = '.google_poish';
    }


    jQuery(selector).on( 'click', function(event) {
        event.stopPropagation();
        poi_type        =   jQuery(this).attr('id');
        var position    =   map_for_poi.getCenter();
        var show_poi    =   wpestate_return_poi_values(poi_type);


        if( jQuery(this).hasClass('poi_active')){
            wpestate_show_hide_poi(poi_type,'hide');
        }else{
    
            already_serviced = wpestate_show_hide_poi(poi_type,'show');
            if(already_serviced===1){ 
               
                var request = {
                    location:   position,
                    types:      show_poi,        
                    bounds:     map_bounds,
                    radius:     2500,
                };
                poi_service.nearbySearch( request,function (results, status){
                    wpestate_googlemap_display_poi(results, status,map_for_poi);
                });
            }
        }
        jQuery(this).toggleClass('poi_active');
    });
 
    
   
    
    
    // return google poi types for selected poi
    var wpestate_return_poi_values = function (poi_type){
        var  show_poi;
        switch(poi_type) {
                case 'transport':
                    show_poi = ['bus_station', 'airport', 'train_station', 'subway_station'];
                    break;
                case 'supermarkets':
                    show_poi = ['grocery_or_supermarket', 'shopping_mall'];
                    break;
                case 'schools':
                    show_poi = ['school', 'university'];
                    break;
                case 'restaurant':
                    show_poi=['restaurant'];
                    break;
                case 'pharma':
                    show_poi = ['pharmacy'];
                    break;
                case 'hospitals':
                    show_poi = ['hospital'];
                    break;
            }
        return show_poi;
    };

    
    // add poi markers on the map
    var wpestate_googlemap_display_poi = function (results, status,map_for_poi) {
        var place, poi_marker;
        if ( google.maps.places.PlacesServiceStatus.OK == status  ) {
            for (var i = 0; i < results.length; i++) {
                poi_marker  =   wpestate_create_poi_marker(results[i],map_for_poi);
                poi_marker_array.push(poi_marker);
            }
        }
    };

    // create the poi markers
    var wpestate_create_poi_marker = function (place,map_for_poi){
        var marker = new google.maps.Marker({
                map: map_for_poi,
                position: place.geometry.location,
                show_poi:poi_type,
                icon: mapfunctions_vars.path+'/poi/'+poi_type+'.png'
        });


        var boxText         =   document.createElement("div");
        var infobox_poi     =   new InfoBox({
                    content: boxText,
                    boxClass:"estate_poi_box",
                    pixelOffset: new google.maps.Size(-30, -70),
                    zIndex: null,
                    maxWidth: 275,
                    closeBoxMargin: "-13px 0px 0px 0px",
                    closeBoxURL: "",
                    infoBoxClearance: new google.maps.Size(1, 1),
                    pane: "floatPane",
                    enableEventPropagation: false
                });

        google.maps.event.addListener(marker, 'mouseover', function(event) {
            infobox_poi.setContent(place.name);
            infobox_poi.open(map_for_poi, this);
        });

        google.maps.event.addListener(marker, 'mouseout', function(event) {
            if( infobox_poi!== null){
                infobox_poi.close(); 
            }
        });
        return marker;
    };


    
    // hide-show poi
    var wpestate_show_hide_poi = function (poi_type,showhide){
        var is_hiding=1;

        for (var i = 0; i < poi_marker_array.length; i++) {
            if (poi_marker_array[i].show_poi === poi_type){
                if(showhide==='hide'){
                    poi_marker_array[i].setVisible(false);
                }else{
                    poi_marker_array[i].setVisible(true);
                    is_hiding=0;
                }
            }
        }

        return is_hiding;
    };
};



function wpestate_geolocation_marker (place_lat, place_lng){
    "use strict";
     var place_radius;
    if(control_vars.geo_radius_measure==='miles'){
        place_radius =parseInt( jQuery('#geolocation_radius').val(),10)*1609.34 ; 
    }else{
        place_radius =parseInt( jQuery('#geolocation_radius').val(),10)*1000 ;    
    }
    
    if( wp_estate_kind_of_map===1){
        var place_position=new google.maps.LatLng(place_lat, place_lng);
        map.setCenter(place_position);

        if(placeCircle!=''){
            placeCircle.setMap(null);
            placeCircle='';
        }

        var marker = new google.maps.Marker({
            map: map,
            position:  place_position,
            icon: mapfunctions_vars.path+'/poi/location.png'
        });


        var populationOptions = {
            strokeColor: '#67cfd8',
            strokeOpacity: 0.6,
            strokeWeight: 1,
            fillColor: '#1CA8DD',
            fillOpacity: 0.2,
            map: map,
            center: place_position,
            radius: parseInt(place_radius,10)
        };
        placeCircle = new google.maps.Circle(populationOptions);
        map.fitBounds(placeCircle.getBounds());
    }else{
        var markerCenter    =   L.latLng(place_lat, place_lng );
        map.panTo(markerCenter);      
        if(map.hasLayer(circleLayer)){
            map.removeLayer(circleLayer);
        }
        
         var markerImage = {
                iconUrl:  mapfunctions_vars.path+'/poi/location.png',
                iconSize: [28, 38],
                iconAnchor: [10, 19],
                popupAnchor: [1, -18]
            };
        var  markerOptions = {
            riseOnHover: true
        };
        if(map.hasLayer(circleLayer)){
            map.removeLayer(circleLayer);
        }
        circleLayer=L.featureGroup();
        markerOptions.icon = L.icon( markerImage );
        L.marker( markerCenter, markerOptions ).addTo( map );
        placeCircle= L.circle( markerCenter, parseInt(place_radius,10) ).addTo(circleLayer);
        
        map.addLayer(circleLayer);    
        map.fitBounds(placeCircle.getBounds());
    }
    


}


function wpestate_makeSafeForCSS(name) {
    return name.replace(/[^a-z0-9]/g, function(s) {
        var c = s.charCodeAt(0);
        if (c == 32) return '-';
        if (c >= 65 && c <= 90) return  s.toLowerCase();
        return  ('000' + c.toString(16)).slice(-4);
    });
}
