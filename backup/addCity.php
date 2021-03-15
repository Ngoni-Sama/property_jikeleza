<?php
require 'core/init.php';
$general->logged_out_protect();

if (isset($_POST['submit'])) 
{
	$city_name 			= $_POST['city_name'];
	$province_name 		= $_POST['province_name'];

	global $city_id;
		
		if(!preg_match("/^[a-zA-Z ]*$/",$city_name))
		{
			$errors[] = 'Only letters and white space allowed for city name';
		}
		if ($province->province_exists($province_name) === false) 
		{
			$errors[] = 'Sorry that province does\'nt exist';
		}


		if(empty($errors) === true)
		{			
			
			$city->register_city($city_id, $province_name, $city_name);
			
			Print '<script>alert("city successfully added");
			window.location.assign("addCity.php")</script>';
	
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
			Province Name: <input type="text" name="province_name" required="required" /><br/>
			City Name: <input type="text" name="city_name" required="required" /><br/>
			
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