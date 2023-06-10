<?php

class ChambreBD extends Chambre {

	private $_db;
	private $_retour = [];

	public function __construct($cnx) {
		$this->_db = $cnx;
	}

	public function insert() {
		try{
			$query = "INSERT INTO chambre(nom_chambre, prix, lit, description, image_chambre) VALUES (?, ?, ?, ?, ?) RETURNING id_chambre";
			$res = $this->_db->prepare($query);
			$res->execute(array(
				$this->nom,
				$this->prix,
				$this->lit,
				$this->description,
				$this->image,
			));

			return $res->fetch();
		}catch(PDOException $e){
			print "Echec ".$e->getMessage();
		}

		return 0;
	}

	public function ajoutOption($id_option) {
		try{
			$query = "INSERT INTO chambre_options(id_chambre, id_options) VALUES (?, ?)";
			$res = $this->_db->prepare($query);
			return $res->execute(array(
				$this->id_chambre,
				$id_option
			));
		}catch(PDOException $e){
			print "Echec ".$e->getMessage();
		}

		return 0;
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
			$query = "DELETE FROM chambre_options WHERE id_chambre=:id";
			$res = $this->_db->prepare($query);
			$res->bindValue(':id', $id);
			$res->execute();
		}catch(PDOException $e){
			print "Echec ".$e->getMessage();
		}

		try{
			$query = "DELETE FROM chambre WHERE id_chambre=:id";
			$res = $this->_db->prepare($query);
			$res->bindValue(':id', $id);
			$res->execute();
		}catch(PDOException $e){
			print "Echec ".$e->getMessage();
		}
	}

	public function getChambreByID($id){
		try{
			$query="select * from chambre where id_chambre = :id";
			$res = $this->_db->prepare($query);
			$res->bindValue(':id',$id);
			$res->execute();
			$data = $res->fetch();
			return $data;
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