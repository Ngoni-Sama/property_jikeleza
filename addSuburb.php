<?php
require 'core/init.php';
$general->logged_out_protect();

if (isset($_POST['submit'])) 
{
	$city_name 			= $_POST['city_name'];
	$suburb_name 		= $_POST['suburb_name'];

	global $suburb_id;
		
		if(!preg_match("/^[a-zA-Z ]*$/",$suburb_name))
		{
			$errors[] = 'Only letters and white space allowed for suburb name';
        }

        if(!preg_match("/^[a-zA-Z ]*$/",$city_name))
		{
			$errors[] = 'Only letters and white space allowed for city name';
        }
        
		if ($city->city_exists($city_name) === false) 
		{
			$errors[] = 'Sorry that city does\'nt exist';
		}

		if(empty($errors) === true)
		{			
            $province_name = $city->get_city_information($city_name);

			$suburb->register_suburb($suburb_id, $suburb_name, $city_name, $province_name);
			
			Print '<script>alert("Suburb successfully added");
			window.location.assign("addSuburb.php")</script>';
	
		}
}
?>

<!DOCTYPE html>
<html>
	<head>
	<title>	</title>
	
	</head>

	<body>
	<a href="home.php">Click here to go back</a>
	<br>
	<div class="container">
		<h2 >Add Province</h2>
		<form action="" method="POST">
			City Name: <input type="text" name="city_name" required="required" /><br/>
			Suburb Name: <input type="text" name="suburb_name" required="required" /><br/>
			
			<input type="submit" name="submit" class="button" value="Add"/>
		
		<?php 
			if(empty($errors) === false)
			{
				echo '<p>' . implode('</p><p>', $errors) . '</p>';	
			}
		?>
		
		</form>



	</div>
	</body>
	
</html>