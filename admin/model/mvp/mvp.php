<?php
class ModelMvpMvp extends Model {
	public function getAll () {
		$mvp = array();
		$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "mvp (
			`id` INT(11) NOT NULL AUTO_INCREMENT,
			`name` VARCHAR(255) NOT NULL,
			`image` VARCHAR(255) NOT NULL,
			`text` TEXT NOT NULL,
			PRIMARY KEY(`id`)
		)");
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "mvp ORDER BY id");
		foreach ($query->rows as $result) {
			$mvp[] = $result;
		}

		return $mvp;
	}
	public function addNew ($name,$image,$text){
		$this->db->query("INSERT INTO " . DB_PREFIX . "mvp (`name`, `image`, `text`) VALUES
    ('".$name."','".$image."','".$text."')");
	return 'added';
	}
	public function updateRow ($id,$name,$image,$text){
		$this->db->query("UPDATE " . DB_PREFIX . "mvp SET name = '".$name."', image= '".$image."', text = '".$text."' WHERE id = '" . (int)$id . "'");
	return 'updated';
	}
	public function deleteRow ($id){
		$this->db->query("DELETE FROM " . DB_PREFIX . "mvp WHERE id = ".$id);
	return 'deleted';
	}
}
