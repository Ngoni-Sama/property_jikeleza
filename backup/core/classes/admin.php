<?php 
class Admin{
 	
	private $db;

	public function __construct($database) {
	    $this->db = $database;
	}

	public function insert_admin($username, $email, $password)
	{	
		global $bcrypt; // making the $bcrypt variable global so we can use here
		$password   = $bcrypt->genHash($password);
		
		$query 	= $this->db->prepare("INSERT INTO `admin` (`username`, `email`, `password`) VALUES (?, ?, ?) ");
		$query->bindValue(1, $username);
		$query->bindValue(2, $email);
		$query->bindValue(3, $password);	

		try
		{
			$query->execute();

			//mail($email, 'Welcome to Tello Business', "Hello " . $username. ",\r\nThank you for registering with us. \r\n\r\n-- Tello Business Team");
		}catch(PDOException $e)
		{
			die($e->getMessage());
		}	
	}

	public function updateAdmin($username, $email, $admin_id)
	{
		$query = $this->db->prepare("UPDATE `admin` SET
								`username`			= ?,
								`email`				= ?
								
								WHERE `admin_id` 	= ? 
								");

		$query->bindValue(1, $username);
		$query->bindValue(2, $email);
		$query->bindValue(3, $admin_id);

		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function admin_data($admin_id) 
	{
		$query = $this->db->prepare("SELECT * FROM `admin` WHERE `admin_id`= ?");
		$query->bindValue(1, $admin_id);

		try{

			$query->execute();

			return $query->fetchAll();

		} catch(PDOException $e){

			die($e->getMessage());
		}
	}
	
	public function adminInformation() 
	{
		$query = $this->db->prepare("SELECT * FROM `admin`");

		try{

			$query->execute();

			return $query->fetchAll();

		} catch(PDOException $e){

			die($e->getMessage());
		}
	}

	public function search_admin($search) 
	{
		$query = $this->db->prepare("SELECT * FROM `admin` where `email` = ? OR `username` = ?");
		$query->bindValue(1, $search);
		$query->bindValue(2, $search);

		try{

			$query->execute();

			return $query->fetchAll();

		} catch(PDOException $e){

			die($e->getMessage());
		}
	}
	  	  	 
	public function get_admin() {

		$query = $this->db->prepare("SELECT * FROM `admin` ORDER BY `email` DESC");
		
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}

		return $query->fetchAll();

	}

	public function admin_exists($email) {
	
		$query = $this->db->prepare("SELECT COUNT(`admin_id`) FROM `admin` WHERE `email`= ?");
		$query->bindValue(1, $email);
	
		try{

			$query->execute();
			$rows = $query->fetchColumn();

			if($rows == 1){
				return true;
			}else{
				return false;
			}

		} catch (PDOException $e){
			die($e->getMessage());
		}

	}
	 
	public function email_exists($email) 
	{
		$query = $this->db->prepare("SELECT COUNT(`admin_id`) FROM `admin` WHERE `email`= ?");
		$query->bindValue(1, $email);
	
		try{

			$query->execute();
			$rows = $query->fetchColumn();

			if($rows == 1){
				return true;
			}else{
				return false;
			}

		} catch (PDOException $e){
			die($e->getMessage());
		}

	}
	
	public function username_exists($username) 
	{
		$query = $this->db->prepare("SELECT COUNT(`admin_id`) FROM `admin` WHERE `username`= ? ");
		$query->bindValue(1, $username);
	
		try{

			$query->execute();
			$rows = $query->fetchColumn();

			if($rows == 1){
				return true;
			}else{
				return false;
			}

		} catch (PDOException $e){
			die($e->getMessage());
		}

	}

	public function admin1_exists($search) 
	{
		$query = $this->db->prepare("SELECT COUNT(`admin_id`) FROM `admin` WHERE `username`= ? OR `email` = ?");
		$query->bindValue(1, $search);
		$query->bindValue(2, $search);

		try{

			$query->execute();
			$rows = $query->fetchColumn();

			if($rows == 1){
				return true;
			}else{
				return false;
			}

		} catch (PDOException $e){
			die($e->getMessage());
		}

	}

	public function register($username, $email, $password)
	{
		global $bcrypt; // making the $bcrypt variable global so we can use here

		$password   = $bcrypt->genHash($password);

		$query 	= $this->db->prepare("INSERT INTO `admin` (`username`, `email`, `password`) VALUES (?, ?, ?) ");
		$query->bindValue(1, $username);
		$query->bindValue(2, $email);
		$query->bindValue(3, $password);
		
		try{
			$query->execute();

			//mail($email, 'Welcome to Tello', "Hello " . $username. ",\r\nThank you for registering with us. \r\n\r\n-- Tello Team");
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function login($email, $password) {

		global $bcrypt;  // Again make get the bcrypt variable, which is defined in init.php, which is included in login.php where this function is called

		$query = $this->db->prepare("SELECT `password`, `admin_id` FROM `admin` WHERE `email` = ?");
		$query->bindValue(1, $email);

		try{
			
			$query->execute();
			$data 				= $query->fetch();
			$stored_password 	= $data['password']; // stored hashed password
			$admin_id   				= $data['admin_id']; // id of the user to be returned if the password is verified, below.
			
			if($bcrypt->verify($password, $stored_password) === true){ // using the verify method to compare the password with the stored hashed password.
				return $admin_id;	// returning the user's id.
			}else{
				return false;	
			}

		}catch(PDOException $e){
			die($e->getMessage());
		}
	
	}
	
	public function deleteAdmin($admin_id) {
		$query = $this->db->prepare("DELETE FROM `admin` WHERE `admin_id` = ?");
		$query->bindValue(1, $admin_id);
		
		try{

			$query->execute();
			
		} catch(PDOException $e){

			die($e->getMessage());
		}
		
	}


}