<?php
require 'core/init.php';
$general->logged_out_protect();

//$id   = htmlentities($user['id']); // storing the user's username after clearning for any html tags. 

$view_admin = $admin->admin_data($admin_id);

?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
</head>
<body>

<h1>Welcome</h1>
<?php foreach ($view_admin as $row) { ?>
<label>Username: </label>
<?php echo $row['username']; ?>
<?php } ?>

<p>What do you want to do ?</p>
<ol>
    <li><a href="logout.php">Logout</a></li>
	<br>
	<li><a href="addAdmin.php">Add admin</a></li>
	<li><a href="viewAdmin.php">View admin</a></li>
	<br>
	<li><a href="addProvince.php">Add province</a></li>
	<br>
	<li><a href="addCity.php">Add city</a></li>
	<br>
	<li><a href="addSuburb.php">Add suburb</a></li>
</ol>

<h1></h1>

</body>
</html>