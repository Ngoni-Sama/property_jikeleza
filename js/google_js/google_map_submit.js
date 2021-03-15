/*global google, Modernizr , InfoBox,google_map_submit_vars ,mapfunctions_vars, googlecode_home_vars,jQuery*/
var geocoder;
var map;
var selected_id         =   '';
var gmarkers = [];
var propertyMarker_submit='';

function google_map_submit_initialize(){
    "use strict";
  
   if( jQuery('#googleMapsubmit').length===0 ){
       return;
   }
    
    var listing_lat=jQuery('#property_latitude').val();
    var listing_lon=jQuery('#property_longitude').val();
    
    if( jQuery('#agency_lat').length > 0){
        listing_lat=jQuery('#agency_lat').val();
        listing_lon=jQuery('#agency_long').val();
    }
    
    if( jQuery('#developer_lat').length > 0){
        listing_lat=jQuery('#developer_lat').val();
        listing_lon=jQuery('#developer_long').val();
    }
    
    if(listing_lat==='' || typeof  listing_lat==='undefined'){
        listing_lat=google_map_submit_vars.general_latitude;
    }
    
     if(listing_lon===''|| typeof  listing_lon==='undefined'){
        listing_lon= google_map_submit_vars.general_longitude;
    }
    
    
    if( parseInt( mapfunctions_vars.geolocation_type ) == 1 ){
        geocoder = new google.maps.Geocoder();
        var mapOptions = {
                flat:false,
                noClear:false,
                zoom: 17,
                scrollwheel: false,
                draggable: true,
                disableDefaultUI:false,
                center: new google.maps.LatLng( listing_lat, listing_lon),
                mapTypeId: google.maps.MapTypeId.ROADMAP,
                gestureHandling: 'cooperative'
               };


        if(  document.getElementById('googleMapsubmit') ){
            map = new google.maps.Map(document.getElementById('googleMapsubmit'), mapOptions);
        }else{
            return;
        }

        google.maps.visualRefresh = true;

        var point=new google.maps.LatLng( listing_lat, listing_lon);

        wpestate_placeSavedMarker(point);

        if(mapfunctions_vars.map_style !==''){
           var styles = JSON.parse ( mapfunctions_vars.map_style );
           map.setOptions({styles: styles});
        }

        google.maps.event.addListener(map, 'click', function(event) {
            wpestate_placeMarker(event.latLng);
        });
    }else{
        
        var mapCenter = L.latLng( listing_lat, listing_lon );
        map =  L.map( 'googleMapsubmit',{
            center: mapCenter, 
            zoom:15,
        });

        var tileLayer =  wpresidence_open_stret_tile_details();
        map.addLayer( tileLayer );

        
       map.on('click', function(e){
    
            map.removeLayer( propertyMarker_submit );
            var markerCenter        =   L.latLng( e.latlng);
            propertyMarker_submit   =   L.marker(e.latlng).addTo(map);;
            propertyMarker_submit.bindPopup('<div class="submit_leaflet_admin">Latitude: ' + e.latlng.lat + ' Longitude: ' + e.latlng.lng+'</div>').openPopup();
            jQuery("#property_latitude").val(e.latlng.lat) ;
            jQuery("#property_longitude").val( e.latlng.lng);
            jQuery("#agency_lat").val(e.latlng.lat) ;
            jQuery("#agency_long").val( e.latlng.lng);
            jQuery("#developer_lat").val(e.latlng.lat) ;
            jQuery("#developer_long").val( e.latlng.lng);
        });
       
        var markerCenter        =   L.latLng(mapCenter);
        propertyMarker_submit   =   L.marker( markerCenter ).addTo(map);
        propertyMarker_submit.bindPopup('<div class="submit_leaflet_admin">Latitude: ' + listing_lat + ' Longitude: ' + listing_lon +'</div>');
        
       
        //   setTimeout(function(){       propertyMarker_submit.openPopup(); }, 600); 
    }
	
	
}
 


function wpestate_placeSavedMarker(location) {
    "use strict";
    wpestate_removeMarkers();
    var marker = new google.maps.Marker({
      position: location,
      map: map
    });
     gmarkers.push(marker);

    var infowindow = new google.maps.InfoWindow({
      content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()  
    });

   infowindow.open(map,marker);


}


function wpestate_codeAddress() {
    "use strict";
 
    var address     =   document.getElementById('property_address').value;
    var city        =   jQuery ("#property_city_submit").val();
    var full_addr   =   address;
    var listing_lat,listing_long;
    if(city!=='none'){
        full_addr   =   full_addr+','+city;
    }
    var state       =   document.getElementById('property_county').value;
    if(state){
        full_addr=full_addr +','+state;
    }

    var country   = document.getElementById('property_country').value;
    if(country){
        full_addr=full_addr +','+country;
    }


    if(parseInt(mapfunctions_vars.geolocation_type ) == 1 ){
 
        geocoder.geocode( { 'address': full_addr}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                    listing_lat     =   results[0].geometry.location.lat();
                    listing_long    =   results[0].geometry.location.lng();
                    wpresidence_submit_set_postion(listing_lat,listing_long)
            } else {
                alert(google_map_submit_vars.geo_fails + status);
            }
        });
    }else  if( parseInt( mapfunctions_vars.geolocation_type ) == 2 ){
            var jqxhr = jQuery.get( "https://nominatim.openstreetmap.org/search",
                        {
                            format: 'json',
                            addressdetails:'1',
                            q: full_addr//was q
                        })
    
            .done(function(data) {
                if(data==''){
                    alert(google_map_submit_vars.geo_fails + status);
                }else{
                 
                    listing_lat     =   data[0].lat;
                    listing_long    =   data[0].lon;
                    wpresidence_submit_set_postion(listing_lat,listing_long);
                }
            })
            .fail(function(data) {
          
            })
            .always(function() {

            });
    }
}

function wpresidence_submit_set_postion(listing_lat,listing_long){
    
    wpestate_removeMarkers();
    
    if( parseInt( mapfunctions_vars.geolocation_type ) == 1 ){
        var myLatLng = new google.maps.LatLng( listing_lat, listing_long);
        map.setCenter(myLatLng);
        var marker = new google.maps.Marker({
            map: map,
            position: myLatLng
        });

        gmarkers.push(marker);
        var infowindow = new google.maps.InfoWindow({
            content: 'Latitude: ' + listing_lat + '<br>Longitude: ' + listing_long
        });

        infowindow.open(map,marker);
        document.getElementById("property_latitude").value  =   listing_lat ;
        document.getElementById("property_longitude").value =   listing_long;
    }else{
        var mapCenter = L.latLng( listing_lat, listing_long );
        var markerCenter        =   L.latLng(mapCenter);
          map.removeLayer( propertyMarker_submit );
        propertyMarker_submit   =   L.marker( markerCenter ).addTo(map);
        propertyMarker_submit.bindPopup('<div class="submit_leaflet_admin">Latitude: ' + listing_lat + ' Longitude: ' + listing_long +'</div>');
      
        setTimeout(function(){       propertyMarker_submit.openPopup(); }, 600);   
        propertyMarker_submit.fire('click');
        document.getElementById("property_latitude").value = listing_lat ;
        document.getElementById("property_longitude").value = listing_long;
        map.panTo(new L.LatLng(listing_lat,listing_long));
     
    }
}



function wpestate_codeAddress_agency(agency_adress , agency_city , agency_county,agency_lat,agency_long) {
    "use strict";
    var address     =   jQuery(agency_adress).val();
    var city        =   jQuery(agency_city).val();
    var full_addr   =   address+','+city;
    var state       =   jQuery(agency_county).val();
     var open_street_address='';
     
    if(state){
        full_addr=full_addr +','+state;
    }
 
    open_street_address=address+','+city;
    
    if( wp_estate_kind_of_map == 1 ){
        
        geocoder.geocode( { 'address': full_addr}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
                gmarkers.push(marker);

                var infowindow = new google.maps.InfoWindow({
                    content: 'Latitude: ' + results[0].geometry.location.lat() + '<br>Longitude: ' + results[0].geometry.location.lng()  
                });

                infowindow.open(map,marker);
                jQuery(agency_lat).val( results[0].geometry.location.lat() );
                jQuery(agency_long).val( results[0].geometry.location.lng() );
            } else {
                alert(google_map_submit_vars.geo_fails + status);
            }
        });
        
    }else  if( wp_estate_kind_of_map == 2 ){
        var jqxhr = jQuery.get( "https://nominatim.openstreetmap.org/search",
                    {
                        format: 'json',
                        addressdetails:'1',
                        q: open_street_address//was q
                    })

        .done(function(data) {


            if( typeof(data[0]) !='undefined' ){
                var listing_lat     =   data[0].lat;
                var listing_long    =   data[0].lon;

                var mapCenter               =   L.latLng( listing_lat, listing_long );
                var markerCenter            =   L.latLng(mapCenter);
                
                map.removeLayer( propertyMarker_submit );
                propertyMarker_submit   =   L.marker( markerCenter ).addTo(map);
                propertyMarker_submit.bindPopup('<div class="submit_leaflet_admin">Latitude: ' + listing_lat + ' Longitude: ' + listing_long +'</div>');
      
                setTimeout(function(){  propertyMarker_submit.openPopup(); }, 600);   
        
                map.panTo(new L.LatLng(listing_lat,listing_long));
                jQuery(agency_lat).val(  data[0].lat );
                jQuery(agency_long).val( data[0].lon );
        
            }else{
                alert(google_map_submit_vars.geo_fails  + status);
            }
        })
        .fail(function() {

        })
        .always(function() {

        });
    }
}












function wpestate_placeMarker(location) {
    "use strict";
    wpestate_removeMarkers();
    var marker = new google.maps.Marker({
       position: location,
       map: map
    });
    gmarkers.push(marker);

    var infowindow = new google.maps.InfoWindow({
        content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()  
    });
    
    var myElem ;
    infowindow.open(map,marker);
    myElem = document.getElementById('property_latitude');
    if (myElem !== null) {
        document.getElementById("property_latitude").value=location.lat();
        document.getElementById("property_longitude").value=location.lng();
    }
    
    myElem = document.getElementById('agency_lat');
    if (myElem !== null) {
        document.getElementById("agency_lat").value=location.lat();
        document.getElementById("agency_long").value=location.lng();
        
    }
    
    myElem = document.getElementById('developer_lat');
    if (myElem !== null) {

        document.getElementById("developer_lat").value=location.lat();
        document.getElementById("developer_long").value=location.lng();
    }
}


 ////////////////////////////////////////////////////////////////////
 /// set markers function
 //////////////////////////////////////////////////////////////////////
 
function wpestate_removeMarkers(){
    "use strict";

    for (var i = 0; i<gmarkers.length; i++){
        if( parseInt( mapfunctions_vars.geolocation_type ) == 1 ){
            gmarkers[i].setMap(null);
        }else{
         map.removeLayer(gmarkers[i]);
        }
    }
}
                         
jQuery('#open_google_submit').on( 'click', function() {
    "use strict";
    setTimeout(function(){
        initialize();
        google.maps.event.trigger(map, "resize");
    },300);
   
});
               
    
jQuery('#google_capture').on( 'click', function(event) {
    "use strict";
    event.preventDefault();
    wpestate_removeMarkers();
    wpestate_codeAddress();  
});  

if (typeof google === 'object' && typeof google.maps === 'object') {
   google.maps.event.addDomListener(window, 'load', google_map_submit_initialize);
}else{
    google_map_submit_initialize();
}
    



jQuery('#google_agency_location').on( 'click', function(event) {
    "use strict";
    event.preventDefault();
    wpestate_removeMarkers();
    wpestate_codeAddress_agency('#agency_address', '#agency_city','#agency_county','#agency_lat','#agency_long');
});  


jQuery('#google_developer_location').on( 'click', function(event) {
    "use strict";
    event.preventDefault();
    wpestate_removeMarkers();
    wpestate_codeAddress_agency('#developer_address', '#developer_city','#developer_county','#developer_lat','#developer_long');
});  


   


jQuery(document).ready(function ($) {
    "use strict";
    
    $( "#imagelist" ).sortable({
        revert: true,
        update: function( event, ui ) {
            var all_id,new_id;
            all_id="";
            $( "#imagelist .uploaded_images" ).each(function(){

                new_id = $(this).attr('data-imageid'); 
                if (typeof new_id != 'undefined') {
                    all_id=all_id+","+new_id; 
                   
                }

            });
           
            $('#attachid').val(all_id);
        },
    });

    
    

    var autocomplete,autocomplete2;
    var options = {
        types: ['(cities)'],
     //   componentRestrictions: {country: 'uk'}
    };




    var componentForm = {
        establishment:'long_name',
        street_number: 'short_name',
        route: 'long_name',
        locality: 'long_name',
        administrative_area_level_1: 'long_name',
        administrative_area_level_2: 'long_name',
        country: 'long_name',
        postal_code: 'short_name',
        postal_code_prefix:'short_name',
        neighborhood:'long_name'
    };



    if ( google_map_submit_vars.enable_auto ==='yes' ){
        
        if(  document.getElementById('property_address') ){
            if( parseInt( mapfunctions_vars.geolocation_type ) == 1 ){
                autocomplete = new google.maps.places.Autocomplete(
                  /** @type {HTMLInputElement} */(document.getElementById('property_address')),
                    {   types: ['geocode'],
                        "partial_match" : true
                    }
                );

                var input = document.getElementById('property_address');
                    google.maps.event.addDomListener(input, 'keydown', function(e) { 
                        if (e.keyCode == 13) { 
                            e.stopPropagation(); 
                            e.preventDefault();
                        }
                }); 

                google.maps.event.addListener(autocomplete, 'place_changed', function(event) {
                    var place = autocomplete.getPlace();
                    wpestate_fillInAddress(place);
                });

                autocomplete2 = new google.maps.places.Autocomplete(
                    /** @type {HTMLInputElement} */(document.getElementById('property_city_submit')),
                    {    types: ['(cities)']        }
                );

                google.maps.event.addListener(autocomplete2, 'place_changed', function() {
                    var place = autocomplete2.getPlace();
                    wpestate_fillInAddress(place);
                });
            } else if( parseInt( mapfunctions_vars.geolocation_type ) == 2 ){
            
                            jQuery('#property_address').autocomplete( {
				source: function ( request, response ) {
					jQuery.get( 'https://nominatim.openstreetmap.org/search', {
						format: 'json',
						q: request.term,//was q
						addressdetails:'1',
					}, function( result ) {
						if ( !result.length ) {
                                                    response( [ {
                                                        value: '',
                                                        label: 'there are no results'
                                                    } ] );
                                                    return;
						}
						response( result.map( function ( place ) {
						
                                                       var return_obj= {
								label: place.display_name,
                                                                latitude: place.lat,
								longitude: place.lon,
								value: place.display_name,
                                                            
                                                        };
                                                        
                               
                                                        if(typeof(place.address)!='undefined'){
                                                            return_obj.county=place.address.county;
                                                        }
                                                        
                                                        if(typeof(place.address)!='undefined'){
                                                            return_obj.city=place.address.city;
                                                        }
                                                        
                                                        if(typeof(place.address)!='undefined'){
                                                            return_obj.state=place.address.state;
                                                        }
                                                        
                                                        if(typeof(place.address)!='undefined'){
                                                            return_obj.country=place.address.country;
                                                        }
                                                        
                                                        if(typeof(place.address)!='undefined'){
                                                            return_obj.zip=place.address.postcode;
                                                        }
                                                        
                                                        return return_obj
                                                        
//                                                       
						} ) );
					}, 'json' );
				},
				select: function ( event, ui ) {
                                 
					var listing_lat     =   ui.item.latitude;
                                        var listing_long    =   ui.item.longitude;
                                
                                     
                                        $('#property_zip').val( ui.item.zip );
                                        $('#property_county').val( ui.item.county);
                                        $('#property_city_submit').val( ui.item.city);
                                        $('#property_country').val( ui.item.country);
                                        $('#property_city_submit').val( ui.item.city);
                                            
                                        wpresidence_submit_set_postion(listing_lat,listing_long);
				}
			} );
            
            }
            
            
            
            
        }
    }
    
    
    function wpestate_fillInAddress(place) {
       
        $('#property_area').val('');
        $('#property_zip').val('');
        $('#property_county').val('');
        $('#property_city_submit').val('');
        
        for (var i = 0; i < place.address_components.length; i++) {
          var addressType = place.address_components[i].types[0];
       
            var temp='';
            var val = place.address_components[i][componentForm[addressType]];
           
      
                
            if(addressType=== 'street_number' || addressType=== 'route'){
              //  document.getElementById('property_address').value =  document.getElementById('property_address').value +', '+ val;
            }else if(addressType=== 'neighborhood'){
                 $('#property_area').val(val);
            }else if(addressType=== 'postal_code_prefix'){
               // temp = $('#property_zip').val();
                $('#property_zip').val(val);
            }else if(addressType=== 'postal_code'){
               // temp = $('#property_zip').val();
                $('#property_zip').val(val);
            }else if(addressType=== 'administrative_area_level_2'){
                $('#property_county').val(val);
            }else if(addressType=== 'administrative_area_level_1'){
                $('#property_county').val(val);
            }else if(addressType=== 'locality'){
                $('#property_city_submit').val(val);
            }else if(addressType=== 'country'){
                $('#property_country').val(val);
            }else{
               
            }
            
          
        }
        wpestate_codeAddress();
    }

    jQuery('#google_capture2').on( 'click', function(event) {
        event.preventDefault();
        wpestate_codeAddress_child();  
    });  

    function wpestate_codeAddress_child() {
       
        var address =   document.getElementById('property_address').value;
        var city    =   jQuery("#property_city_submit").val();

        var full_addr= address+','+city;
        if(  document.getElementById('property_state') ){
            var state     = document.getElementById('property_state').value;
            if(state){
                full_addr=full_addr +','+state;
            }
        }

        if(  document.getElementById('property_country') ){
            var country   = document.getElementById('property_country').value;
            if(country){
                full_addr=full_addr +','+country;
            }
        }   


        geocoder.geocode( { 'address': full_addr}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                    map.setCenter(results[0].geometry.location);
                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });

                    var infowindow = new google.maps.InfoWindow({
                        content: 'Latitude: ' + results[0].geometry.location.lat() + '<br>Longitude: ' + results[0].geometry.location.lng()  
                     });

                    infowindow.open(map,marker);
                    document.getElementById("property_latitude").value=results[0].geometry.location.lat();
                    document.getElementById("property_longitude").value=results[0].geometry.location.lng();
            } else {
                    alert(google_map_submit_vars.geo_fails + status);
            }
        });
    }
    
});