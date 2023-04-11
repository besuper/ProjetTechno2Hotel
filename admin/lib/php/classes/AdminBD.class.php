<?php

class AdminBD extends Admin {

	private $_db; // recevra $cnx de l'index
	private $_retour = [];

	public function __construct($cnx) {
		$this->_db = $cnx;
	}

	public function isAdmin($login, $password) {
		try {
			$query = "SELECT isadmin(?, ?)";
			$res = $this->_db->prepare($query);
			$res->execute([$login, $password]);

			$data = $res->fetch();

			return $data["isadmin"];
		}catch (PDOException $e) {
			print "Erreur : " . $e->getMessage();
		}

		return false;
	}

}