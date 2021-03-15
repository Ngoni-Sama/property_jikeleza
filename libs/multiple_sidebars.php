<?php

class wpestate_sidebar_generator {
	public function __construct(){
            add_action('init',array('wpestate_sidebar_generator','init'));
            add_action('admin_print_scripts', array('wpestate_sidebar_generator','admin_print_scripts'));
            if ( current_user_can('manage_options') ){  
		add_action('admin_menu',array('wpestate_sidebar_generator','admin_menu'));
		add_action('wp_ajax_add_sidebar', array('wpestate_sidebar_generator','add_sidebar') );
		add_action('wp_ajax_remove_sidebar', array('wpestate_sidebar_generator','remove_sidebar') );
		
		//save posts/pages
		add_action('edit_post', array('wpestate_sidebar_generator', 'save_form'));
		add_action('publish_post', array('wpestate_sidebar_generator', 'save_form'));
		add_action('save_post', array('wpestate_sidebar_generator', 'save_form'));
		add_action('edit_page_form', array('wpestate_sidebar_generator', 'save_form'));
          }
	}
	
	public static function init(){
            //go through each sidebar and register it
		
	    $sidebars = wpestate_sidebar_generator::get_sidebars();
	    

	    if(is_array($sidebars)){
			foreach($sidebars as $sidebar){
				$sidebar_class = wpestate_sidebar_generator::name_to_class($sidebar);
				register_sidebar(array(
					'id'=>sanitize_title($sidebar),
                                        'name'=>$sidebar,
                                        'before_widget' => '<li id="%1$s" class="widget widget-container sbg_widget '.$sidebar_class.' %2$s">',
		   			'after_widget' => '</li>',
		   			'before_title' => '<h3 class="widget-title-sidebar">',
					'after_title' => '</h3>',
		    	));
			}
		}
	}
	
public static	function admin_print_scripts(){
		wp_print_scripts( array( 'sack' ));
          
		?>
			<script>
				function add_sidebar( sidebar_name )
				{
					var nonce = document.getElementById('sidebar_generator_nonce').value;
					var mysack = new sack("<?php  echo site_url(); ?>/wp-admin/admin-ajax.php" );    
				
				  	mysack.execute = 1;
				  	mysack.method = 'POST';
                                        
                                        mysack.setVar( "sidebar_generator_nonce",nonce );
				  	
                                        mysack.setVar( "action", "add_sidebar" );
				  	mysack.setVar( "sidebar_name", sidebar_name );
				  	mysack.encVar( "cookie", document.cookie, false );
				  	mysack.onError = function() { alert('Ajax error. Cannot add sidebar' )};
				  	mysack.runAJAX();
					return true;
				}
				
				function remove_sidebar( sidebar_name,num )
				{
					
                                        var nonce = document.getElementById('remove_sidebar_generator_nonce').value;
					var mysack = new sack("<?php echo site_url(); ?>/wp-admin/admin-ajax.php" );    
				
				  	mysack.execute = 1;
				  	mysack.method = 'POST';
                                        
                                        mysack.setVar( "sidebar_generator_nonce",nonce );
                                          
				  	mysack.setVar( "action", "remove_sidebar" );
				  	mysack.setVar( "sidebar_name", sidebar_name );
				  	mysack.setVar( "row_number", num );
				  	mysack.encVar( "cookie", document.cookie, false );
				  	mysack.onError = function() { alert('Ajax error. Cannot add sidebar' )};
				  	mysack.runAJAX();
					//alert('hi!:::'+sidebar_name);
					return true;
				}
			</script>
		<?php
	}
	
	 public static function add_sidebar(){
             
                //check_admin_referer( 'add_sidebar', 'sidebar_generator_nonce' );
                $nonce = $_POST['sidebar_generator_nonce'];
                if ( ! wp_verify_nonce( $nonce, 'add_sidebar' ) ) {
                     die();//failed nonce
                }

		$sidebars = wpestate_sidebar_generator::get_sidebars();
		$name = str_replace(array("\n","\r","\t"),'',$_POST['sidebar_name']);
		$id = wpestate_sidebar_generator::name_to_class($name);
		if(isset($sidebars[$id])){
			die("alert('Sidebar already exists, please use a different name.')");
		}
		
		$sidebars[$id] = $name;
		wpestate_sidebar_generator::update_sidebars($sidebars);
		
		$js = "
			var tbl = document.getElementById('sbg_table');
			var lastRow = tbl.rows.length;
			// if there's no header row in the table, then iteration = lastRow + 1
			var iteration = lastRow;
			var row = tbl.insertRow(lastRow);
			
			// left cell
			var cellLeft = row.insertCell(0);
			var textNode = document.createTextNode('$name');
			cellLeft.appendChild(textNode);
			
			//middle cell
			var cellLeft = row.insertCell(1);
			var textNode = document.createTextNode('$id');
			cellLeft.appendChild(textNode);
			
			//var cellLeft = row.insertCell(2);
			//var textNode = document.createTextNode('[<a href=\'javascript:void(0);\' onclick=\'return remove_sidebar_link($name);\'>Remove</a>]');
			//cellLeft.appendChild(textNode)
			
			var cellLeft = row.insertCell(2);
			removeLink = document.createElement('a');
      		linkText = document.createTextNode('remove');
			removeLink.setAttribute('onclick', 'remove_sidebar_link(\'$name\')');
			removeLink.setAttribute('href', 'javacript:void(0)');
        
      		removeLink.appendChild(linkText);
      		cellLeft.appendChild(removeLink);

			
		";
		
		
		die( "$js");
	}
	
	public static function remove_sidebar(){
                if(!is_admin()){
                    exit('out pls');
                }
                
                $nonce = $_POST['sidebar_generator_nonce'];
                if ( ! wp_verify_nonce( $nonce, 'remove_sidebar' ) ) {
                     die();//failed nonce
                }
                
                
		$sidebars = wpestate_sidebar_generator::get_sidebars();
		$name = ( str_replace( array("\n","\r","\t"),'',$_POST['sidebar_name']) );
                
		$id = wpestate_sidebar_generator::name_to_class($name);
		if(!isset($sidebars[$id])){
			die("alert('Sidebar does not exist.')");
		}
		$row_number = intval($_POST['row_number']);
		unset($sidebars[$id]);
		wpestate_sidebar_generator::update_sidebars($sidebars);
		$js = "
			var tbl = document.getElementById('sbg_table');
			tbl.deleteRow($row_number)

		";
		die($js);
	}
	
	public static function admin_menu(){
		add_theme_page( 'Sidebars', 'Sidebars', 'manage_options', __FILE__, array('wpestate_sidebar_generator','admin_page'));
            
                
        }
	
	public static function admin_page(){
		?>
		<script>
			function remove_sidebar_link(name,num){
				answer = confirm("Are you sure you want to remove " + name + "?\nThis will remove any widgets you have assigned to this sidebar.");
				if(answer){
					//alert('AJAX REMOVE');
					remove_sidebar(name,num);
				}else{
					return false;
				}
			}
			function add_sidebar_link(){
				var sidebar_name = prompt("Sidebar Name:","");
				//alert(sidebar_name);
				add_sidebar(sidebar_name);
			}
		</script>
		<div class="wrap">
			<h2>Sidebar Generator</h2>
			<p>
				The sidebar name is for your use only. It will not be visible to any of your visitors. 
				
			</p>
			<br />
                        
                        <?php wp_nonce_field( 'add_sidebar', 'sidebar_generator_nonce' );?>
                        <?php wp_nonce_field( 'remove_sidebar', 'remove_sidebar_generator_nonce' );?>
			<div class="add_sidebar">
				<a href="javascript:void(0);" onclick="return add_sidebar_link()" title="Add a sidebar">+ Add Sidebar</a>
			</div>
			<br />
			<table class="widefat page" id="sbg_table" style="width:600px;">
				<tr>
					<th>Name</th>
					<th>CSS class</th>
					<th>Remove</th>
				</tr>
				<?php
				$sidebars = wpestate_sidebar_generator::get_sidebars();
				//$sidebars = array('bob','john','mike','asdf');
				if(is_array($sidebars) && !empty($sidebars)){
					$cnt=0;
					foreach($sidebars as $sidebar){
						$alt = ($cnt%2 == 0 ? 'alternate' : '');
				?>
				<tr class="<?php echo esc_attr($alt);?>">
					<td><?php echo esc_html($sidebar); ?></td>
					<td><?php echo esc_html ( wpestate_sidebar_generator::name_to_class($sidebar)); ?></td>
					<td><a href="javascript:void(0);" onclick="return remove_sidebar_link('<?php echo esc_html($sidebar); ?>',<?php echo floatval($cnt+1); ?>);" title="Remove this sidebar">remove</a></td>
				</tr>
				<?php
						$cnt++;
					}
				}else{
					?>
					<tr>
						<td colspan="3">No Sidebars defined</td>
					</tr>
					<?php
				}
				?>
			</table>
			<br /><br />
			
		</div>
		<?php
	}
	
	/**
	 * for saving the pages/post
	*/
	 public static function save_form($post_id){
            $is_saving ='';
            if( isset($_POST['sbg_edit']) ){
		$is_saving = $_POST['sbg_edit'];
            }
              if(!empty($is_saving)){
			delete_post_meta($post_id, 'sbg_selected_sidebar');
			delete_post_meta($post_id, 'sbg_selected_sidebar_replacement');
			add_post_meta($post_id, 'sbg_selected_sidebar', $_POST['sidebar_generator']);
			add_post_meta($post_id, 'sbg_selected_sidebar_replacement', $_POST['sidebar_generator_replacement']);
		}		
	}
	

	public static function get_sidebar($name="0"){
		if(!is_singular()){
			if($name != "0"){
                            dynamic_sidebar($name);
			}else{
                            dynamic_sidebar();
			}
			return;//dont do anything
		}
		global $wp_query;
		$post = $wp_query->get_queried_object();
		$selected_sidebar = get_post_meta($post->ID, 'sbg_selected_sidebar', true);
		$selected_sidebar_replacement = get_post_meta($post->ID, 'sbg_selected_sidebar_replacement', true);
		$did_sidebar = false;
		//this page uses a generated sidebar
		if($selected_sidebar != '' && $selected_sidebar != "0"){
			echo "\n\n<!-- begin generated sidebar -->\n";
			if(is_array($selected_sidebar) && !empty($selected_sidebar)){
				for($i=0;$i<sizeof($selected_sidebar);$i++){					
					
					if($name == "0" && $selected_sidebar[$i] == "0" &&  $selected_sidebar_replacement[$i] == "0"){
						//echo "\n\n<!-- [called $name selected {$selected_sidebar[$i]} replacement {$selected_sidebar_replacement[$i]}] -->";
						dynamic_sidebar();//default behavior
						$did_sidebar = true;
						break;
					}elseif($name == "0" && $selected_sidebar[$i] == "0"){
						//we are replacing the default sidebar with something
						//echo "\n\n<!-- [called $name selected {$selected_sidebar[$i]} replacement {$selected_sidebar_replacement[$i]}] -->";
						dynamic_sidebar($selected_sidebar_replacement[$i]);//default behavior
						$did_sidebar = true;
						break;
					}elseif($selected_sidebar[$i] == $name){
						//we are replacing this $name
						//echo "\n\n<!-- [called $name selected {$selected_sidebar[$i]} replacement {$selected_sidebar_replacement[$i]}] -->";
						$did_sidebar = true;
						dynamic_sidebar($selected_sidebar_replacement[$i]);//default behavior
						break;
					}
					//echo "<!-- called=$name selected={$selected_sidebar[$i]} replacement={$selected_sidebar_replacement[$i]} -->\n";
				}
			}
			if($did_sidebar == true){
				echo "\n<!-- end generated sidebar -->\n\n";
				return;
			}
			//go through without finding any replacements, lets just send them what they asked for
			if($name != "0"){
				dynamic_sidebar($name);
			}else{
				dynamic_sidebar();
			}
			echo "\n<!-- end generated sidebar -->\n\n";
			return;			
		}else{
			if($name != "0"){
				dynamic_sidebar($name);
			}else{
				dynamic_sidebar();
			}
		}
	}
	
	/**
	 * replaces array of sidebar names
	*/
	public static function update_sidebars($sidebar_array){
		$sidebars = update_option('sbg_sidebars',$sidebar_array);
	}	
	
	/**
	 * gets the generated sidebars
	*/
	public static function get_sidebars(){
		$sidebars = get_option('sbg_sidebars');
		return $sidebars;
	}
	public static function name_to_class($name){
		$class = str_replace(array(' ',',','.','"',"'",'/',"\\",'+','=',')','(','*','&','^','%','$','#','@','!','~','`','<','>','?','[',']','{','}','|',':',),'',$name);
		return $class;
	}
	
}
$sbg = new wpestate_sidebar_generator;

function generated_dynamic_sidebar($name='0'){
	wpestate_sidebar_generator::get_sidebar($name);	
	return true;
}
?>