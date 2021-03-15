/* Thu 11 May 2017 08:40:57 BST */
/* Copyright (C) WpEstate, Inc - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 * Written by WpEstate august 2017
 */

function WpstateMarker(poss,latlng, map,title,counter,image,id,price,pin_price,single_first_type,single_first_action,link,i,rooms,baths,cleanprice,size,single_first_type_name,single_first_action_name,pin,infoWindowIndex) {
    
   
   
        this.position   =   latlng;		
        this.title      =   title;
        this.zIndex     =   counter;
        this.image      =   image;
        this.idul       =   id;
        this.price      =   price;
        this.pin_price  =   pin_price;
        this.category   =   single_first_type;
        this.action     =   single_first_action;
        this.link       =   link;
        this.infoWindowIndex =   i;
        this.rooms      =    rooms;
        this.baths      =    baths;
        this.cleanprice =       cleanprice;
        this.size       =       size;
        this.category_name  =   single_first_type_name;
        this.action_name    =   single_first_action_name;
        this.visible        =   true;
        this.draggable      =   false;
        this.optimized      =   true;
        this.opacity        =   1.0;
        this.pin            =   pin;
        this._omsData       =   null;
        this.spiderfied     =   false;
        this.div_ = null;
        this.map_ = map;
	this.setMap(map);	
  
    
}

    if(typeof google != 'undefined' && google){ 
        WpstateMarker.prototype = new google.maps.OverlayView();
    }
    
    WpstateMarker.prototype.onAdd = function() {
    };

    WpstateMarker.prototype.draw = function() {

        var self = this;
        var div = this.div;

        if (!div) {
            div = this.div = document.createElement('div');
            div.className = 'wpestate_marker '+wpestate_makeSafeForCSS(this.category_name.trim() )+' '+wpestate_makeSafeForCSS(this.action_name.trim())+' class_' +wpestate_makeSafeForCSS(this.category_name.trim() )+' class_'+wpestate_makeSafeForCSS(this.action_name.trim()); 
            if (typeof(self.price) !== 'undefined') {
                if( mapfunctions_vars.use_price_pins_full_price==='no'){
                    div.innerHTML ='<div class="interior_pin_price">'+self.pin_price+'</div>';
                }else{
                    div.innerHTML ='<div class="interior_pin_price">'+self.price+'</div>';
                }
            }

            google.maps.event.addDomListener(div, "mouseout", function(event) {
                google.maps.event.trigger(self, "mouseout");
                self.div.classList.remove("hover_z_pin");
            });
            
            google.maps.event.addDomListener(div, "click", function(event) {
                event.stopPropagation();
                google.maps.event.trigger(self, "click");
            });

            google.maps.event.addDomListener(div, "mouseover", function(event) {
                google.maps.event.trigger(self, "mouseover");
                self.div.className +=' hover_z_pin '; 
            });

            
            var panes = this.getPanes();
            panes.overlayImage.appendChild(div);
        }


        var point = this.getProjection().fromLatLngToDivPixel(this.position);

        if (point) {
           
            div.style.left = (point.x+0 ) + 'px';
            div.style.top = (point.y -12) + 'px';
        }
    };

    WpstateMarker.prototype.remove = function() {
        if (this.div) {
            this.div.parentNode.removeChild(this.div);
            this.div = null;
        }	
    };

    WpstateMarker.prototype.getPosition = function() {
        return this.position;	
    };
        
    WpstateMarker.prototype.setPosition = function(newlatlng) {
        this.position=newlatlng;
        var point = this.getProjection().fromLatLngToDivPixel(this.position);

        if (point) {
            this.div.style.left = (point.x+0 ) + 'px';
            this.div.style.top = (point.y ) + 'px';
        }
    };
        
    WpstateMarker.prototype.getDraggable = function() {
        return false;	
    };

    WpstateMarker.prototype.getVisible  = function() {
        return this.visible;
    };

    WpstateMarker.prototype.getMap  = function() {
        return this.map;
    };

     WpstateMarker.prototype.setmap  = function(map) {
         this.map=map;
    };


    WpstateMarker.prototype.getZIndex  = function() {
        return this.zIndex;
    };

    WpstateMarker.prototype.setZIndex = function(value) {
       this.zIndex=value;
    };

    WpstateMarker.prototype.setVisible  = function(value) {
        this.visible=value;
    };

    WpstateMarker.prototype.getBounds = function()  {
        return new google.maps.LatLngBounds(this.position, this.position); 
    };


    WpstateMarker.prototype.fromLatLngToDivPixel=function(){

    }

function wpestate_makeSafeForCSS(name) {
    return name.replace(/[^a-z0-9]/g, function(s) {
        var c = s.charCodeAt(0);
        if (c == 32) return '-';
        if (c >= 65 && c <= 90) return  s.toLowerCase();
        return  ('000' + c.toString(16)).slice(-4);
    });
}