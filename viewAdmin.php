<?php
require 'core/init.php';
$general->logged_out_protect();

$view_admin = $admin->adminInformation();	

if (isset($_POST['submit']))
{
	$search = $_POST['search'];
	
	if ($admin-> admin1_exists($search) === false) 
	{
		$errors[] = 'Sorry that admin does\'nt exists.';
	}

	$view_admin = $admin->search_admin($search);
	
}

if (isset($_POST['submit1']))
{
	$view_admin = $admin->adminInformation();
}



?>

<!DOCTYPE html>
<html>
	<head>
		<title>	</title>
	</head>
	
		<body>
			<a href="home.php">Click here to go back</a> <br><br>
			
			<label>Search</label>
			<form action="" method="post">
				<input type="text" placeholder="Type the username/email here" name="search" size = 22>	
				<button type="submit" name="submit" >Search</button>
				
				<br><br>
				<button type="submit" name="submit1" >Click here to view all admin</button>
			</form>
			<?php 
				if(empty($errors) === false)
				{
					echo '<p>' . implode('</p><p>', $errors) . '</p>';	
				}
			?>

			<br>		
			

			<?php 
			if(empty($errors) === true)
			{	
			?>

			<table width = 50%>
				<tr>
					<td align="center">ID</td>
					<td align="center">Username</td>
					<td align="center">Email</td>
					<td align="center">Action</td>	
				</tr>
				
				<tr>
					<?php foreach ($view_admin as $row) { ?>
					<th><?php echo $row['admin_id']; ?></th>
					<th><?php echo $row['username']; ?></th>
					<th><?php echo $row['email']; ?></th>
					<th> 
						<a href="editAdmin.php?admin_id=<?php echo $row['admin_id']?>"> Edit</a> | | 
						<a href="deleteAdmin.php?admin_id=<?php echo $row['admin_id']?>" >Delete</a> 
					</th>
				</tr>
					<?php } ?>
			</table>
			
			<?php } ?>		
		
		</body>
</html>
	