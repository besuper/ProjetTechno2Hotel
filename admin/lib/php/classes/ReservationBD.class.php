<?php

class ReservationBD extends Reservation {
	private $_db;
	private $_retour = [];

	public function __construct($cnx) {
		$this->_db = $cnx;
	}

	public function getClientReservations($id) {
		try {
			$query = "SELECT * FROM reservation where id_client = ?";

			$req = $this->_db->prepare($query);
			$req->execute(array($id));

			while($data = $req->fetch()) {
				$this->_retour[] = new Reservation($data);
			}

			if(empty($this->_retour)){
				return [];
			}

			return $this->_retour;
		}catch(PDOException $e) {
			print "Erreur " . $e->getMessage();
		}

		return [];
	}

	public function cancel($debut, $fin, $id_chambre) {
		try{
			$query = "DELETE FROM reservation WHERE rest_date_debut = ? AND res_date_fin = ? AND id_chambre = ?";
			$res = $this->_db->prepare($query);
			$res->execute(array(
				$debut,
				$fin,
				$id_chambre
			));
		}catch(PDOException $e){
			print "Echec ".$e->getMessage();
		}
	}

}