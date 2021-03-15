<?php 
class Province{
 	
	private $db;

	public function __construct($database) {
	    $this->db = $database;
	}

	public function register_province($province_id, $province_name){
		global $db;
		
		$query 	= $this->db->prepare("INSERT INTO `province` (`province_id`, `province_name`) VALUES (?, ?) ");
		
		$query->bindValue(1, $province_id);
		$query->bindValue(2, $province_name);

		try{
			$query->execute();
			
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
	public function get_last_province_id($province_name) {

		$query = $this->db->prepare("SELECT `province_id` FROM `province` WHERE `province_name` = ? AND `province_id` = 
		(SELECT max(`province_id`) FROM `province` WHERE `province_name` = ?)");
		$query->bindValue(1, $province_name);
		$query->bindValue(2, $province_name);
	
		
		try{
			
			$query->execute();
			return $query->fetchColumn();
			
			
		}catch(PDOException $e){
			die($e->getMessage());
		}

	}
	
	public function province_exists($province_name) {
	
		$query = $this->db->prepare("SELECT COUNT(`province_name`) FROM `province` WHERE `province_name`= ?");
		$query->bindValue(1, $province_name);
	
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
	

	public function provincedata($province_id) {

		$query = $this->db->prepare("SELECT * FROM province WHERE province_id = ?");
		$query->bindValue(1, $province_id);
		try{

			$query->execute();

		} catch(PDOException $e){

			die($e->getMessage());
		}
		return $query->fetchAll();
	}

}

?>