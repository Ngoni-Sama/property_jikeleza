<?php 
class Suburb
{
 	
	private $db;

	public function __construct($database) 
	{
	    $this->db = $database;
	}	
	
	public function register_suburb($suburb_id, $suburb_name, $city_name, $province_name)
	{
		$query 	= $this->db->prepare("INSERT INTO `suburb` (`suburb_id`, `suburb_name`, `city_name`, `province_name`) VALUES (?, ?, ?, ?) ");
		
		$query->bindValue(1, $suburb_id);
		$query->bindValue(2, $suburb_name);
		$query->bindValue(3, $city_name);
		$query->bindValue(4, $province_name);

		try
		{
			$query->execute();
		}
		catch(PDOException $e)
		{
			die($e->getMessage());
		}
	}
	
	public function suburb_exists($suburb_name) 
	{
		$query = $this->db->prepare("SELECT COUNT(`suburb_name`) FROM `suburb` WHERE `suburb_name`= ?");
		$query->bindValue(1, $suburb_name);
	
		try
		{
			$query->execute();
			$rows = $query->fetchColumn();

			if($rows == 1)
			{
				return true;
			}
			else
			{
				return false;
			}

		} catch (PDOException $e)
		{
			die($e->getMessage());
		}

	}
	
	public function suburb_data($suburb_id) 
	{
		$query = $this->db->prepare("SELECT * FROM suburb WHERE `suburb_id` = ?");
		$query->bindValue(1, $suburb_id);
		
		try
		{
			$query->execute();
		} catch(PDOException $e)
		{
			die($e->getMessage());
		}
		return $query->fetchAll();
	}
	
	public function deleteSuburb($suburb_id) 
	{
		$query = $this->db->prepare("DELETE FROM `suburb` WHERE `suburb_id` = ?");
		$query->bindValue(1, $suburb_id);
		
		try
		{
			$query->execute();
			
		} catch(PDOException $e)
		{
			die($e->getMessage());
		}
		
	}
	
	public function get_city_details($city_name) {

		$query = $this->db->prepare("SELECT * FROM `city` WHERE `city_name` = ? ");
		$query->bindValue(1, $city_name);
	
		try{
			
			$query->execute();
			return $query->fetchColumn();
			
			
		}catch(PDOException $e){
			die($e->getMessage());
		}

	}
	
	
}

?>