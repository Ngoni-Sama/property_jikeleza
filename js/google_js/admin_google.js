/*global admin_google_vars,google,jQuery */
var map='';
var selected_city='';
var geocoder;
var gmarkers = [];
var propertyMarker_submit ;

jQuery(document).ready(function ($) {
    "use strict";
    if( parseInt( admin_google_vars.wpresidence_map_type ) === 1){                                        
        google.maps.event.addDomListener(window, 'load', wpresidence_admin_submit_initialize);
    }else{
        wpresidence_admin_submit_initialize();
    }
    
    
    var myElem = document.getElementById('property_map_trigger');
    if (myElem !== null) {
        
        jQuery('#property_map_trigger').on('click',function(){
            if( parseInt( admin_google_vars.wpresidence_map_type ) === 1){   
                google.maps.event.trigger(map, 'resize');     
            }else{
              
           }
        });
        
           
    }   
    
});



function wpresidence_admin_submit_initialize(){
    "use strict";
 
    if( parseInt( admin_google_vars.wpresidence_map_type ) === 1){
        
        var myPlace    = new google.maps.LatLng(admin_google_vars.general_latitude, admin_google_vars.general_longitude);

        var mapOptions = {
                flat:false,
                noClear:false,
                zoom: 17,
                scrollwheel: false,
                draggable: true,
                center: myPlace,
                mapTypeId: google.maps.MapTypeId.ROADMAP
              };

        map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);
        google.maps.visualRefresh = true;


        var marker=new google.maps.Marker({
            position:myPlace
        });

        marker.setMap(map);
        gmarkers.push(marker);

        google.maps.event.addListener(map, 'click', function(event) {
            wpestate_placeMarker(event.latLng);
            google.maps.visualRefresh = true;
        });
        
        map.setCenter(myPlace);
        

   
    }else if( parseInt( admin_google_vars.wpresidence_map_type ) === 2) {
        
    
        
        var mapCenter = L.latLng( admin_google_vars.general_latitude, admin_google_vars.general_longitude );
        map =  L.map( 'googleMap',{
            center: mapCenter, 
            zoom:15,
        });

        var tileLayer =  wpresidence_open_stret_tile_details_admin();
        
      
      
        map.addLayer( tileLayer );

        
       map.on('click', function(e){
    
            map.removeLayer( propertyMarker_submit );
            var markerCenter        =   L.latLng( e.latlng);
            propertyMarker_submit   =   L.marker(e.latlng).addTo(map);;
            propertyMarker_submit.bindPopup('<div class="submit_leaflet_admin">Latitude: ' + e.latlng.lat + ' Longitude: ' + e.latlng.lng+'</div>').openPopup();
           
            jQuery("#property_latitude").val( e.latlng.lat );
            jQuery("#property_longitude").val( e.latlng.lng );
            
            jQuery("#agency_lat").val ( e.latlng.lat );
            jQuery("#agency_long").val( e.latlng.lng );
            
            jQuery("#developer_lat").val ( e.latlng.lat );
            jQuery("#developer_long").val( e.latlng.lng );
            
            
        });
       
        var markerCenter        =   L.latLng(mapCenter);
        propertyMarker_submit   =   L.marker( markerCenter ).addTo(map);
        propertyMarker_submit.bindPopup('<div class="submit_leaflet_admin">Latitude: ' + admin_google_vars.general_latitude + ' Longitude: ' + admin_google_vars.general_longitude +'</div>');
       
        jQuery('#property_map_trigger').on('click',function(){
            setTimeout(function(){ map.invalidateSize(); }, 600);   
            setTimeout(function(){       propertyMarker_submit.openPopup(); }, 600);   
      
        });
        
    }
    
    
    
}


function wpresidence_open_stret_tile_details_admin(){
    
    
    if( admin_google_vars.wp_estate_mapbox_api_key==='' ){
        var tileLayer = L.tileLayer(  'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        } );

    }else{
        var tileLayer = L.tileLayer( 'https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token='+admin_google_vars.wp_estate_mapbox_api_key, {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
            maxZoom: 18,
            id: 'mapbox.streets',
            accessToken: 'your.mapbox.access.token'
            } 
        );
    }
    return tileLayer;
}



function wpestate_placeMarker(location) {
    "use strict";
    wpestate_removeMarkersadmin();
    var marker = new google.maps.Marker({
        position: location,
        map: map
    });
    var myElem;
    
    gmarkers.push(marker);
    var infowindow = new google.maps.InfoWindow({
        content: 'Latitude: ' + location.lat() + '<br>Longitude: ' + location.lng()  
    });
  
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

function wpestate_removeMarkersadmin(){
    "use strict";
    for (var i = 0; i<gmarkers.length; i++){
        gmarkers[i].setMap(null);
    }
}
 






jQuery('#admin_place_pin').on( 'click', function(event) {
    "use strict";    
    event.preventDefault();
    wpestate_admin_codeAddress();  
});  

jQuery('#property_citychecklist label').on( 'click', function(event) {
    "use strict";
    selected_city=  jQuery(this).text() ;
}); 

 
function wpestate_admin_codeAddress() {
    "use strict";
    var state, city;
    var address     ='';
  
    var listing_lat,listing_long;
    var open_street_address='';
   
    if(jQuery('#property_address').length >0 ){
        address     = document.getElementById('property_address').value;
        var checkedValue = jQuery('#property_city-all input:checked').parent();
        city=checkedValue.text();
        
        checkedValue = jQuery('#property_county_state-all input:checked').parent();
        state=checkedValue.text();
        
        var country   = document.getElementById('property_country').value;
    
    }else if(jQuery('#developer_address').length >0 ){
        address     = document.getElementById('developer_address').value;
        var checkedValue = jQuery('#property_city_developer-all input:checked').parent();
        city=checkedValue.text();
        
        checkedValue = jQuery('#property_county_state_developer-all input:checked').parent();
        state=checkedValue.text();
        var country ='';
    
    }else if(jQuery('#agency_address').length >0 ){
        address     = document.getElementById('agency_address').value;
        var checkedValue = jQuery('#city_agency-all input:checked').parent();
        city=checkedValue.text();
        
        checkedValue = jQuery('#county_state_agency-all input:checked').parent();
        state=checkedValue.text();
        
        var country ='';
    }
    
    
    var full_addr   = address;
    if(city){
        full_addr=full_addr +','+city;
    }
    
    if(state){
        full_addr=full_addr +','+state;
    }
  
    if(country){
        full_addr=full_addr +','+country;
    }
   
    open_street_address=address+','+city+','+country;
    
    
    if( parseInt( admin_google_vars.geolocation_type ) == 1 ){
        geocoder       = new google.maps.Geocoder();
        geocoder.geocode( { 'address': full_addr}, function(results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                    listing_lat     =   results[0].geometry.location.lat();
                    listing_long    =   results[0].geometry.location.lng();
                    wpresidence_internalmap_set_postion(listing_lat,listing_long)
            } else {
                    alert(admin_google_vars.geo_fails  + status);
            }
        });
    }else  if( parseInt( admin_google_vars.geolocation_type ) == 2 ){
            var jqxhr = jQuery.get( "https://nominatim.openstreetmap.org/search",
                        {
                            format: 'json',
                            addressdetails:'1',
                            q: open_street_address//was q
                        })
    
            .done(function(data) {
              
        
                if( typeof(data[0]) !='undefined' ){
                    listing_lat     =   data[0].lat;
                    listing_long    =   data[0].lon;
                    wpresidence_internalmap_set_postion(listing_lat,listing_long);
                }else{
                    alert(admin_google_vars.geo_fails  + status);
                }
            })
            .fail(function() {

            })
            .always(function() {

            });
    }
    
    
  
}

function wpresidence_internalmap_set_postion(listing_lat,listing_long){
    
    wpestate_removeMarkersadmin();
    
    if( parseInt( admin_google_vars.wpresidence_map_type ) === 1){
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
    }else if( parseInt( admin_google_vars.wpresidence_map_type ) === 2) {
        map.removeLayer( propertyMarker_submit );
        var mapCenter = L.latLng( listing_lat, listing_long );
        var markerCenter        =   L.latLng(mapCenter);
        propertyMarker_submit   =   L.marker( markerCenter ).addTo(map);
        propertyMarker_submit.bindPopup('<div class="submit_leaflet_admin">Latitude: ' + listing_lat + ' Longitude: ' + listing_long +'</div>').openPopup();
        map.panTo(new L.LatLng(listing_lat,listing_long));
    }
   
    jQuery("#property_latitude").val(listing_lat);
    jQuery("#property_longitude").val(listing_long);
    
    jQuery("#developer_lat").val(listing_lat) ;
    jQuery("#developer_long").val(listing_long);
    
    jQuery("#agency_lat").val(listing_lat);
    jQuery("#agency_long").val(listing_long);
    
}
