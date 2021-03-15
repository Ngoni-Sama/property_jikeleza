<?php

if( !function_exists('wpestate_fields_type_select') ):

function wpestate_fields_type_select($real_value){

    $select = '<select id="field_type" name="add_field_type[]" style="width:140px;">';
    $values = array('short text','long text','numeric','date','dropdown');
    
    foreach($values as $option){
        $select.='<option value="'.$option.'"';
            if( $option == $real_value ){
                 $select.= ' selected="selected"  ';
            }       
        $select.= ' > '.$option.' </option>';
    }   
    $select.= '</select>';
    return $select;
}
endif; // end   wpestate_fields_type_select  


?>