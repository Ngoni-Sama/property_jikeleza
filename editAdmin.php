<?php 
require 'core/init.php';
$general->logged_out_protect();

$admin_id =$_REQUEST['admin_id'];
$view_admin = $admin->admin_data($admin_id);

if (isset($_POST['submit'])) {
    
    if(empty($_POST['email']) || empty($_POST['username']))
	{
		$errors[] = 'You must fill in all of the fields.';

    }
    
    if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) 
	{
        $errors[] = 'Please enter a valid email address';
    }
	
	if(empty($errors) === true)
	{		
        $username   = $_POST['username'];
        $email      = $_POST['email'];
		$admin->updateAdmin($username, $email, $admin_id);
        {
            Print '<script>alert("Admin Successfully edited");;
            window.location.assign("home.php")</script>';

			exit();    
        }
		exit();
	}
}

?>
<!DOCTYPE html>
<html class="bg-black">
    <head>
        <meta charset="UTF-8">
        <title>	</title>

    </head>
    <body class="bg-black">
    <a href="viewAdmin.php">Click here to go back</a>
	<br><br>

        <div class="form-box" id="login-box">
            <div class="header">Update admin</div>
            <form action="" method="post">
                <div class="body bg-white">
					<?php foreach ($view_admin as $row) { ?>
				    	<div class="form-group">
                        Username
                        <input type="text" name="username" class="form-control" value="<?php echo $row['username']?>" />
                        </div>
                        
                        <div class="form-group">
                        Email
                        <input type="email" name="email" class="form-control" value="<?php echo $row['email']?>" />
                        </div>
					<?php } ?>
                </div>
				
                <div class="footer">
                    <button type="submit" name="submit" class="btn bg-blue btn-block" > Update </button>
                </div>
            
			</form>
		<?php 
		if(empty($errors) === false){
			echo '<p>' . implode('</p><p>', $errors) . '</p>';	
		}

		?>
            <div class="margin text-center">
                <span></span>
                <br/>

            </div>
        </div>

    </body>
</html>