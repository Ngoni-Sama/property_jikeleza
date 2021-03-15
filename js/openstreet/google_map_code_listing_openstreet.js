var markers = '';
var gmarkers = [];
var found_id;


jQuery( function( $ ) {
    return
	'use strict';
        var curent_gview_lat = jQuery('#google_map_on_list').attr('data-cur_lat');
        var curent_gview_long = jQuery('#google_map_on_list').attr('data-cur_long');
        
    
        var mapCenter = L.latLng( curent_gview_lat, curent_gview_long );
        var listingMap =  L.map( 'google_map_on_list',{
                center: mapCenter, 
                zoom: 15
        });
        
     	var tileLayer = L.tileLayer( 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
				attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
			} );
                        
        listingMap.addLayer( tileLayer );
        listingMap.scrollWheelZoom.disable();
        listingMap.on('popupopen', function(e) {
       
            var px = listingMap.project(e.popup._latlng); // find the pixel location on the map where the popup anchor is
            if( mapfunctions_vars.useprice === 'yes' ){
               px.y -= 115; // find the height of the popup container, divide by 2, subtract from the Y axis of marker location
            }else{
                px.y -= 320/2; // find the height of the popup container, divide by 2, subtract from the Y axis of marker location
            }
            listingMap.panTo(listingMap.unproject(px),{animate: true}); // pan to new center
        });
        
        var pins = googlecode_property_vars.single_marker;
        markers = jQuery.parseJSON(pins);
        if (markers.length > 0) {
            wpestate_wprentals_google_setMarkers_leaf(listingMap, markers);
        }
     
        if(found_id!== undefined){
          
            gmarkers[found_id].fire('click');
        }
});



function wpestate_wprentals_google_setMarkers_leaf(map, locations) {
    "use strict";
    var pin_price_marker,guest_no,info_image,status_html,infobox,infoboxWrapper,markerImage,markerCenter,infobox_class, markerOptions,propertyMarker,custom_info,pin_price,place, id, lat, lng, title, pin, counter, image, price, single_first_type, single_first_action, link, city, area, cleanprice, rooms, baths, size, single_first_type_name, single_first_action_name, map_open, myLatLng, selected_id, open_height, boxText, closed_height, width_browser, infobox_width, vertical_pan, myOptions,status, i, slug1, val1, how1, slug2, val2, how2, slug3, val3, how3, slug4, val4, how4, slug5, val5, how5, slug6, val6, how6, slug7, val7, how7, slug8, val8, how8;
    selected_id = parseInt(jQuery('#gmap_wrapper').attr('data-post_id'), 10);
    if (isNaN(selected_id)) {
        selected_id = parseInt(jQuery('#google_map_on_list').attr('data-post_id'), 10);
    }
    


    for (i = 0; i < locations.length; i++) {
 
        place                       = locations[i];
        id                          = place[10];
        lat                         = place[1];
        lng                         = place[2];
        title                       = decodeURIComponent(place[0]);
        pin                         = place[8];
        counter                     = place[3];
        image                       = decodeURIComponent(place[4]);
        price                       = decodeURIComponent(place[5]);
        single_first_type           = decodeURIComponent(place[6]);
        single_first_action         = decodeURIComponent(place[7]);
        link                        = decodeURIComponent(place[9]);
        city                        = decodeURIComponent(place[11]);
        area                        = decodeURIComponent(place[12]);
        cleanprice                  = place[13];
        rooms                       = place[14];
        guest_no                    = place[15];
        size                        = place[16];
        single_first_type_name      = decodeURIComponent(place[17]);
        single_first_action_name    = decodeURIComponent(place[18]);
        status                      = decodeURIComponent(place[19]);
        pin_price                   =   decodeURIComponent ( place[20] );
        custom_info                 =   decodeURIComponent ( place[21] );
       
     
     
        infoboxWrapper = document.createElement( "div" );
        infoboxWrapper.className = 'leafinfobox-wrapper';
        infobox = "";
        
 
            infobox_class=" classic_info "
            if( mapfunctions_vars.useprice === 'yes' ){
                infobox_class =' openstreet_map_price_infobox ';
            }
            if ( typeof(status)!='undefined'){
                if( status.indexOf('%')!==-1 ){
                    
                }else{
                    status = decodeURIComponent(status.replace(/-/g, ' '));
                }                
            }else{
                status='';
            }

            status_html='';
            if (status!=='normal' && status!==''){
                status_html='<div class="property_status status_'+status+'">'+status+'</div>';
            }
                                       
            
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
            if (guest_no !== '') {
                infoguest = '<span id="infoguest">' + guest_no + '</span>';
            } else {
                infoguest = '';
            }

            if (rooms !== '') {
                inforooms = '<span id="inforoom">' + rooms + '</span>';
            } else {
                inforooms = '';
            }

            title = title.toString();




            if( custom_info!=='undefined'){
                var custom_array=custom_info.split(',');
                inforooms = '<span id="inforoom" class="custom_infobox_icon"><i class="' + custom_array[0] + '"></i>' + custom_array[1] + '</span>';
                infoguest = '<span id="infoguest" class="custom_infobox_icon"><i class="' + custom_array[2] + '"></i>' + custom_array[3] + '</span>';

            }
            infobox += '<div class="info_details '+infobox_class+' "><a id="infocloser" onClick=\'javascript:jQuery(".leaflet-popup-close-button")[0].click();\' ></span>'+status_html+'<a href="' + link + '"><div class="infogradient"></div><div class="infoimage" style="background-image:url(' + info_image + ')"  ></div></a><a href="' + link + '" id="infobox_title"> ' + title + '</a><div class="prop_detailsx">' + category_name + " " + in_type + " " + action_name + '</div><div class="infodetails">' + infoguest + inforooms + '</div><div class="prop_pricex">' + price + '</div></div>';

      //  }
        
        
        markerOptions = {
            riseOnHover: true
        };

        markerCenter    = L.latLng( lat, lng );
        
        
        
        
        
        
        
        
        
        if( mapfunctions_vars.useprice === 'yes' ){
            var price_pin_class= 'wpestate_marker openstreet_price_marker '+wpestate_makeSafeForCSS(single_first_type_name.trim() )+' '+wpestate_makeSafeForCSS(single_first_action_name.trim()); 
      
            pin_price_marker = '<div class="'+price_pin_class+'">';
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
            propertyMarker  = L.marker( markerCenter, {icon: myIcon} ).addTo( map );

        }else{    
            
            
            markerImage     = {
                                iconUrl: wpestate_custompin_leaf(pin),
                                iconSize: [44, 50],
                                iconAnchor: [20, 50],
                                popupAnchor: [1, -50]
                            };
            markerOptions.icon = L.icon( markerImage );
            propertyMarker  = L.marker( markerCenter, markerOptions ).addTo( map );
        }
        
        
        
       
        gmarkers.push(propertyMarker);
        if (selected_id === id) {
            found_id = i;
      
        }
        
        infoboxWrapper.innerHTML = infobox;
        propertyMarker.bindPopup( infobox );
           
    }//end for
    
}// end wprentals_google_setMarkers






function wpestate_custompin_leaf(image) {
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
        custom_img = mapfunctions_vars.path + '/none.png';
    }

    if (typeof (custom_img) === 'undefined') {
        custom_img = mapfunctions_vars.path + '/none.png';
    }
    return custom_img;
}
