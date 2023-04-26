<?php

class ClientBD extends Client {
	private $_db;
	private $_retour = [];

	public function __construct($cnx) {
		$this->_db = $cnx;
	}

	public function insert() {
		try{
			$query = "INSERT INTO client(nom_client, prenom_client, mail_client, rue, numero_rue, id_ville, id_pays) VALUES (?, ?, ?, ?, ?, ?, ?)";
			$res = $this->_db->prepare($query);
			return $res->execute(array(
				$this->nom,
				$this->prenom,
				$this->mail,
				$this->rue,
				$this->numero_rue,
				$this->id_ville,
				$this->id_pays,
			));
		}catch(PDOException $e){
			print "Echec ".$e->getMessage();
		}

		return 0;
	}

	public function delete($id) {
		try{
			$query = "DELETE FROM client WHERE id_client=:id";
			$res = $this->_db->prepare($query);
			$res->bindValue(':id', $id);
			$res->execute();
		}catch(PDOException $e){
			print "Echec ".$e->getMessage();
		}
	}

	public function getClientByID($id){
		try{
			$query="select * from client where id_client = :id";
			$res = $this->_db->prepare($query);
			$res->bindValue(':id',$id);
			$res->execute();
			$data = $res->fetch();
			return $data;
		}catch(PDOException $e){
			print "Echec ".$e->getMessage();
		}
	}

	public function getAll() {
		try {
			$query = "SELECT * FROM CLIENTS ORDER BY id_client";

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