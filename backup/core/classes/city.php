<?php 
class City{
 	
	private $db;

	public function __construct($database) {
	    $this->db = $database;
	}

	public function register_city($city_id, $province_name, $city_name){
		global $db;
		
		$query 	= $this->db->prepare("INSERT INTO `city` (`city_id`, `province_name`, `city_name`) VALUES (?, ?, ?) ");
		
		$query->bindValue(1, $city_id);
		$query->bindValue(2, $province_name);
		$query->bindValue(3, $city_name);

		try{
			$query->execute();
			
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
	public function get_city_information($city_name) {

		$query = $this->db->prepare("SELECT `province_name` FROM `city` WHERE `city_name` = ?");
		$query->bindValue(1, $city_name);
	
		try{
			
			$query->execute();
			return $query->fetchColumn();
			
			
		}catch(PDOException $e){
			die($e->getMessage());
		}

	}

	public function city_exists($city_name) {
	
		$query = $this->db->prepare("SELECT COUNT(`city_name`) FROM `city` WHERE `city_name`= ?");
		$query->bindValue(1, $city_name);
	
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

	public function citydata($city_id) {

		$query = $this->db->prepare("SELECT * FROM city WHERE city_id = ?");
		$query->bindValue(1, $city_id);
		try{

			$query->execute();

		} catch(PDOException $e){

			die($e->getMessage());
		}
		return $query->fetchAll();
	}

}

?>