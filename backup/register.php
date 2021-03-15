<?php 
require 'core/init.php';
$general->logged_in_protect();

if (isset($_POST['submit'])) {

	if(empty($_POST['password']) || empty($_POST['email']) || empty($_POST['username']))
	{
		$errors[] = 'You must fill in all of the fields.';

	}
	else
	{
	      	      
        //if ($users->user_exists($_POST['username']) === true) {
        //    $errors[] = 'That username already exists';
        //}
        //if(!ctype_alnum($_POST['username'])){
        //    $errors[] = 'Please enter a username with only alphabets and numbers, with no spaces in between';	
        //}
        if (strlen($_POST['password']) <6)
		{
            $errors[] = 'Your password must be atleast 6 characters';
        } 
		else 
			if (strlen($_POST['password']) >18)
			{
				$errors[] = 'Your password cannot be more than 18 characters long';
			}
        
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) 
		{
            $errors[] = 'Please enter a valid email address';
        }
		else 
			if ($admin->email_exists($_POST['email']) === true) 
			{
				$errors[] = 'That email already exists.';
			}
			else 
				if ($admin->username_exists($_POST['username']) === true) 
				{
					$errors[] = 'That username already exists.';
				}
	}

	if(empty($errors) === true)
	{		
		$username 	= htmlentities($_POST['username']);
		$password 	= $_POST['password'];
		$email 		= htmlentities($_POST['email']);
		
		$admin->register($username, $email, $password);
		$login = $admin->login($email, $password);
		if ($login === false) {
			$errors[] = 'Sorry, that email or password is invalid';
		}else {
			$_SESSION['id'] =  $login;
			header('Location: home.php');
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
        <title>Registration Page</title>

    </head>
    <body class="bg-black">

        <div class="form-box" id="login-box">
            <div class="header">Register admin</div>
            <form action="" method="post">
                <div class="body bg-white">
					<div class="form-group">
                        <input type="text" name="username" class="form-control" placeholder="Username" value="<?php if(isset($_POST['username'])) echo htmlentities($_POST['username']); ?>"/>
                    </div>
                    <div class="form-group">
                        <input type="email" name="email" class="form-control" placeholder="Email" value="<?php if(isset($_POST['email'])) echo htmlentities($_POST['email']); ?>"/>
                    </div>
                    <div class="form-group">
                        <input type="password" name="password" class="form-control" placeholder="Password"/>
                    </div>
                </div>
                <div class="footer">                    

                    <button type="submit" name="submit" class="btn bg-blue btn-block">Get Started</button>
					
					<br>
                    <a href="login.php" class="text-center">I already have an account</a><br>
					
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