/*global  jQuery, document,Chart,wpestate_property_vars ,ajaxcalls_vars,Modernizr,google,map,control_vars,dashboard_vars*/
var morgageChart;
jQuery(document).ready(function ($) {
    "use strict";
    wpestate_enable_star_action();
    if ($(".venobox").length > 0){
        $('.venobox').venobox(); 
    }
    
  //  wpestate_enable_schedule_contact();
  

    
    
    jQuery('#edit_review').on( 'click', function(event) {
      
        var  listing_id  =   jQuery(this).attr('data-listing_id');
        var  title       =   jQuery(this).parent().find('#wpestate_review_title').val();
        var  content     =   jQuery(this).parent().find('#wpestare_review_content').val();
        var  stars       =   jQuery(this).parent().find('.starselected_click').length;
        var  ajaxurl     =   control_vars.admin_url + 'admin-ajax.php';
        var  acesta      =   jQuery(this);
        var  parent      =   jQuery(this).parent().parent();
        var  coment      =  jQuery(this).attr('data-coment_id');
        
        
        if( stars>0 && content!=''){
            jQuery('.rating').text(control_vars.posting);
        }
        var nonce = jQuery('#wpestate_review_nonce').val();
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_edit_review',
                'listing_id'        :   listing_id,
                'title'             :   title,
                'stars'             :   stars,
                'content'           :   content,
                'coment'            :   coment,
                'security'          :   nonce
            },
            success: function (data) {
                jQuery('.rating').text(control_vars.review_edited);
                
            },
            error: function (errorThrown) {
            }
        });
    });
    
    jQuery('#submit_review').on( 'click', function(event) {
      
        var  listing_id  =   jQuery(this).attr('data-listing_id');
        var  title       =   jQuery(this).parent().find('#wpestate_review_title').val();
        var  content     =   jQuery(this).parent().find('#wpestare_review_content').val();
        var  stars       =   jQuery(this).parent().find('.starselected_click').length;
        var  ajaxurl     =   control_vars.admin_url + 'admin-ajax.php';
        var  acesta      =   jQuery(this);
        var  parent      =   jQuery(this).parent().parent();
        
        
        if( stars>0 && content!=''){
            jQuery('.rating').text(control_vars.posting);
        }
        var nonce = jQuery('#wpestate_review_nonce').val();
        jQuery.ajax({
            type: 'POST',
            url: ajaxurl,
            data: {
                'action'            :   'wpestate_post_review',
                'listing_id'        :   listing_id,
                'title'             :   title,
                'stars'             :   stars,
                'content'           :   content,
                'security'          :   nonce,
            },
            success: function (data) {

                jQuery('.rating').text(control_vars.review_posted);
                jQuery('#wpestate_review_title').val('');
                jQuery('#wpestare_review_content').val('');
            },
            error: function (errorThrown) {
            }
        });
    });
   
});

 

function wpestate_enable_star_action() {

    jQuery('.empty_star').on({
        mouseenter: function () {
            var loop, index;
            index = jQuery('.empty_star').index(this);
            jQuery('.empty_star').each(function () {
                loop = jQuery('.empty_star').index(this);
                if (loop <= index) {
                    jQuery(this).addClass('starselected');
                } else {
                    jQuery(this).removeClass('starselected');
                }
            });
        },
        mouseleave: function () {
         
        }
     });
	 
    jQuery('.rating').mouseleave(function(){
        jQuery('.empty_star').removeClass('starselected');
    });
	 
    
    jQuery('.empty_star').on( 'click', function(event) {
        jQuery('.empty_star').removeClass('starselected_click');
        var index   =   jQuery('.empty_star').index(this);
        var loop    =   '';
        jQuery('.empty_star').each(function () {
            loop = jQuery('.empty_star').index(this);
            if (loop <= index) {
                jQuery(this).addClass('starselected_click');
            } 
        });
            
    });
    
}   
        
    
    
function wpestate_show_morg_pie(){
    if(  !document.getElementById('morgage_chart') ){
        return;
    }
    var data_morg={
        datasets: [{
            data: [ jQuery('#morg_principal').attr('data-per'), 
                    jQuery('#monthly_property_tax').attr('data-per'), 
                    jQuery('#hoo_fees').attr('data-per')],
            backgroundColor: [
                    "#0073e1",
                    "#0dc3f8",
                    "#FF5E5B",]
        }],

        labels: [
            wpestate_property_vars.label_principal,
            wpestate_property_vars.label_property_tax,
            wpestate_property_vars.label_hoo,
       
           
        ]
    };


    var options_morg='';
    
   
    var ctx_pie =  jQuery("#morgage_chart").get(0).getContext("2d");
    morgageChart = new Chart(ctx_pie, {
        type: 'doughnut',
      
        data: data_morg,
        options: {
                responsive: true,
                cutoutPercentage:70,
                layout: {
                    padding: {
                        left: 50,
                        right: 0,
                        top: 0,
                        bottom: 0
            }
        },
                title: {
                        display: false,
                        
                },
                animation: {
                        animateScale: true,
                        animateRotate: true
                },
                tooltips: {
                    enabled: false
                },
                legend: {
                    display: false,
                }
        }
    });
   // morgageChart.canvas.parentNode.style.width = "500px";
   // morgageChart.canvas.parentNode.style.height = "500px";
   
   
   
   
    jQuery('#morgage_down_payment').on('change',function(){
        var morgage_down_payment_value   = parseFloat( jQuery('#morgage_down_payment').val(),10);
        var morgage_home_price           = parseFloat( jQuery('#morgage_home_price').val(),10 );
        var morgage_down_payment_percent = parseFloat ( morgage_down_payment_value*100/morgage_home_price,10);
        jQuery('#morgage_down_payment_percent').val(morgage_down_payment_percent.toFixed(2));
        wpestate_compute_morg();
    });
   
   
    jQuery('#morgage_down_payment_percent').on('change',function(){
        var morgage_home_price             = parseFloat( jQuery('#morgage_home_price').val(),10 );
        var morgage_down_payment_percent   = parseFloat( jQuery('#morgage_down_payment_percent').val(),10);
        var morgage_down_payment_value     = parseFloat(morgage_home_price*morgage_down_payment_percent/100);
        jQuery('#morgage_down_payment').val(morgage_down_payment_value.toFixed(2));
        wpestate_compute_morg();
    });
   
   
    jQuery('#monthly_property_tax,#hoo_fees').on('change',function(){
        var hoo_fees                        = parseFloat( jQuery('#hoo_fees').val(),10);
        var property_tax                    = parseFloat( jQuery('#monthly_property_tax').val(),10);
        var morg_principal                  = parseFloat( jQuery('#morg_principal').text(),10);
        
        var total_monthly  =   morg_principal + hoo_fees + property_tax;
        jQuery('#morg_month_total').text( total_monthly.toFixed(2) );
    });
     
    jQuery('#morgage_home_price,#morgage_term,#morgage_interest,#monthly_property_tax,#hoo_fees').on('change',function(){
        wpestate_compute_morg();
    });
   
   
}
    
    
function wpestate_compute_morg(){
        
        var morgage_home_price              = parseFloat( jQuery('#morgage_home_price').val(),10 );
        if( isNaN(morgage_home_price) ){
            morgage_home_price=0;
        }
        var morgage_down_payment_value      = parseFloat( jQuery('#morgage_down_payment').val(),10);
        if( isNaN(morgage_down_payment_value) ){
            morgage_down_payment_value=0;
        }
        var morgage_term                    = parseFloat( jQuery('#morgage_term').val(),10);
        if( isNaN(morgage_term) ){
            morgage_term=1;
        }
        var morgage_interest                = parseFloat( jQuery('#morgage_interest').val(),10);
        if( isNaN(morgage_interest) ){
            morgage_interest=0;
        }
        var hoo_fees                        = parseFloat( jQuery('#hoo_fees').val(),10);
        if( isNaN(hoo_fees) ){
            hoo_fees=0;
        }
        var property_tax                    = parseFloat( jQuery('#monthly_property_tax').val(),10);
        if( isNaN(property_tax) ){
            property_tax=0;
        }
       
       
       
       
        var morgage_down_payment_percent = parseFloat ( morgage_down_payment_value*100/morgage_home_price,10);
        if( isNaN(morgage_down_payment_percent) ){
            morgage_down_payment_percent=0;
        }
        jQuery('#morgage_down_payment_percent').val(morgage_down_payment_percent.toFixed(2));
    
        
        
        var principal   = morgage_home_price -morgage_down_payment_value;
        
        var operator_A  = parseFloat((morgage_interest / 100 / 12) * principal,10) ;     
        var operator_B  = parseFloat( 1 + ( morgage_interest/ 100 / 12),10) ;
        
        var montly_pmt     =   parseFloat( operator_A / (1 - ( Math.pow( operator_B , (-1*morgage_term * 12)))) ,10);
        if(morgage_interest==0){
            montly_pmt =   parseFloat( principal/ ( morgage_term*12) ,10);
        }

        
        
        
        
        var total_monthly  =   montly_pmt + hoo_fees + property_tax;
        if(morgage_home_price===0){
            total_monthly=0;
            montly_pmt=0;
        }
       
       
        jQuery('#morg_principal').text(montly_pmt.toFixed(2));
        jQuery('#morg_month_total').text( total_monthly.toFixed(2) );
        
        var percent_principal =     parseFloat( montly_pmt*100/total_monthly, 10);
        var percent_hoa       =     parseFloat( hoo_fees*100/total_monthly, 10);
        var percent_tax       =     parseFloat( property_tax*100/total_monthly, 10);
    
        morgageChart.data.datasets[0].data=[percent_principal,percent_tax,percent_hoa];
        morgageChart.update();
    }
    
    
function wpestate_show_stat_accordion(){
    if(  !document.getElementById('myChart') ){
        return;
    }
  
    var ctx = jQuery("#myChart").get(0).getContext("2d");
    var myNewChart  =    new Chart(ctx);
    var labels      =   '';
    var traffic_data='  ';
   
    labels          =   jQuery.parseJSON ( wpestate_property_vars.singular_label);
    traffic_data    =   jQuery.parseJSON ( wpestate_property_vars.singular_values);
   
    var data = {
    labels:labels ,
    datasets: [
         {
            label: wpestate_property_vars.property_views,
            fillColor: "rgba(220,220,220,0.5)",
            strokeColor: "rgba(220,220,220,0.8)",
            highlightFill: "rgba(220,220,220,0.75)",
            highlightStroke: "rgba(220,220,220,1)",
            data: traffic_data
        },
    ]
    };
    
    var options = {
        title:'page views',
       //Boolean - Whether the scale should start at zero, or an order of magnitude down from the lowest value
       scaleBeginAtZero : true,

       //Boolean - Whether grid lines are shown across the chart
       scaleShowGridLines : true,

       //String - Colour of the grid lines
       scaleGridLineColor : "rgba(0,0,0,.05)",

       //Number - Width of the grid lines
       scaleGridLineWidth : 1,

       //Boolean - Whether to show horizontal lines (except X axis)
       scaleShowHorizontalLines: true,

       //Boolean - Whether to show vertical lines (except Y axis)
       scaleShowVerticalLines: true,

       //Boolean - If there is a stroke on each bar
       barShowStroke : true,

       //Number - Pixel width of the bar stroke
       barStrokeWidth : 2,

       //Number - Spacing between each of the X value sets
       barValueSpacing : 5,

       //Number - Spacing between data sets within X values
       barDatasetSpacing : 1,

       //String - A legend template
       legendTemplate : "<ul class=\"<%=name.toLowerCase()%>-legend\"><% for (var i=0; i<datasets.length; i++){%><li><span style=\"background-color:<%=datasets[i].fillColor%>\"></span><%if(datasets[i].label){%><%=datasets[i].label%><%}%></li><%}%></ul>"

    };
 
   // var myBarChart = new Chart(ctx).Bar(data, options);
    var myBarChart = new Chart(ctx,{
        type: 'bar',
        data: data,
        options: options
    });

}