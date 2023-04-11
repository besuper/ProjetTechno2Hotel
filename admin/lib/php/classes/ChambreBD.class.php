<?php

class ChambreBD extends Chambre {

	private $_db;
	private $_retour = [];

	public function __construct($cnx) {
		$this->_db = $cnx;
	}

	public function updateChambre($id, $champ, $val) {
		try{
			$query = "UPDATE chambre SET $champ = :val WHERE id_chambre=:id";
			$res = $this->_db->prepare($query);
			$res->bindValue(':val', $val);
			$res->bindValue(':id', $id);
			$res->execute();
		}catch(PDOException $e){
			print "Echec ".$e->getMessage();
		}
	}

	public function deleteChambre($id) {
		try{
			$query = "DELETE FROM chambre WHERE id_chambre=:id";
			$res = $this->_db->prepare($query);
			$res->bindValue(':id', $id);
			$res->execute();
		}catch(PDOException $e){
			print "Echec ".$e->getMessage();
		}
	}

	public function getAllChambres() {
		try {
			$query = "SELECT * FROM chambre ORDER BY id_chambre";

			$req = $this->_db->prepare($query);
			$req->execute();

			while($data = $req->fetch()) {
				$this->_retour[] = new Chambre($data);
			}

			if(empty($this->_retour)){
				return null;
			}

			return $this->_retour;
		}catch(PDOException $e) {
			print "Erreur " . $e->getMessage();
		}
	}

}