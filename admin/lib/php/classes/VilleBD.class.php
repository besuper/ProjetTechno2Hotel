<?php

class VilleBD extends Client {
	private $_db;
	private $_retour = [];

	public function __construct($cnx) {
		$this->_db = $cnx;
	}

	public function getAll() {
		try {
			$query = "SELECT * FROM ville ORDER BY nom";

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