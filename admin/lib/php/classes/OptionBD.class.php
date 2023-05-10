<?php

class OptionBD extends Option {
	private $_db;
	private $_retour = [];

	public function __construct($cnx) {
		$this->_db = $cnx;
	}

	public function test() {
		var_dump($this->nom);
	}

	public function insert() {
		try{
			$query = "INSERT INTO option(nom_options, supplement) VALUES (?, ?) RETURNING id_options";
			$res = $this->_db->prepare($query);
			$res->execute(array(
				$this->nom_option,
				$this->supplement
			));

			return $res->fetch();
		}catch(PDOException $e){
			print "Echec ".$e->getMessage();
		}

		return 0;
	}

	public function delete($id) {
		try{
			$query = "DELETE FROM option WHERE id_options=:id";
			$res = $this->_db->prepare($query);
			$res->bindValue(':id', $id);
			$res->execute();
		}catch(PDOException $e){
			print "Echec ".$e->getMessage();
		}
	}

	public function updateOption($id, $champ, $val) {
		try{
			$query = "UPDATE option SET $champ = :val WHERE id_options=:id";
			$res = $this->_db->prepare($query);
			$res->bindValue(':val', $val);
			$res->bindValue(':id', $id);
			$res->execute();
		}catch(PDOException $e){
			print "Echec ".$e->getMessage();
		}
	}

	public function getAll() {
		try {
			$query = "SELECT * FROM option ORDER BY id_options";

			$req = $this->_db->prepare($query);
			$req->execute();

			while($data = $req->fetch()) {
				$this->_retour[] = new Client($data);
			}

			if(empty($this->_retour)){
				return [];
			}

			return $this->_retour;
		}catch(PDOException $e) {
			print "Erreur " . $e->getMessage();
		}
	}

}