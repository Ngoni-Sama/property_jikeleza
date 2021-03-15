<?php
require 'core/init.php';
$general->logged_out_protect();

if (isset($_POST['submit'])) 
{
	$province_name 		= $_POST['province_name'];

	global $province_id;
		
		if(!preg_match("/^[a-zA-Z ]*$/",$province_name))
		{
			$errors[] = 'Only letters and white space allowed for province name';
		}

		if ($province->province_exists($province_name) === true) 
	{
		$errors[] = 'Sorry that province already exist';
	}
	
		if(empty($errors) === true)
		{			
	
			$province->register_province($province_id, $province_name);
			
			Print '<script>alert("province successfully added");
			window.location.assign("addprovince.php")</script>';
	
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
			Province name: <input type="text" name="province_name" required="required" /><br/>
			
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