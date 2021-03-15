/*global google , jQuery , InfoBox , googlecode_contact_vars,mapfunctions_vars,wpestate_close_adv_search*/
var gmarkers = [];
var map_open=0;
var first_time=1;
var pins='';
var markers='';
var infoBox = null;
var map;
var selected_id='';

            
                
if (typeof google === 'object' && typeof google.maps === 'object') {
    google.maps.event.addDomListener(window, 'load', wpresidence_initialize_map_contact);
}else{
    wpresidence_initialize_map_contact_leaflet();
}