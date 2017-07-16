<?php
class ModelModuleComments extends Model {
	public function getAll () {
		$comments = array();
		$this->db->query("CREATE TABLE IF NOT EXISTS " . DB_PREFIX . "comments (
			`id` INT(11) NOT NULL AUTO_INCREMENT,
			`name` VARCHAR(255) NOT NULL,
			`image` VARCHAR(255) NOT NULL,
			`text` TEXT NOT NULL,
			PRIMARY KEY(`id`)
		)");
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "comments ORDER BY id");
		foreach ($query->rows as $result) {
			$comments[] = $result;
		}

		return $comments;
	}
	public function addNew ($name,$image,$text){
		$this->db->query("INSERT INTO " . DB_PREFIX . "comments (`name`, `image`, `text`) VALUES
    ('".$name."','".$image."','".$text."')");
	return 'added';
	}
	public function updateRow ($id,$name,$image,$text){
		$this->db->query("UPDATE " . DB_PREFIX . "comments SET name = '".$name."', image= '".$image."', text = '".$text."' WHERE id = '" . (int)$id . "'");
	return 'updated';
	}
	public function deleteRow ($id){
		$this->db->query("DELETE FROM " . DB_PREFIX . "comments WHERE id = ".$id);
	return 'deleted';
	}
}