<?php
// classe métier

class Admin {

	private $_attributs = [];

	public function __construct(array $data) {
		$this->hydrate($data);
	}

	// charger les infos dans notre classe métier depuis une base de donnée par exemple (init)
	public function hydrate($data) {
		foreach ($data as $champ => $valeur) {
			$this->$champ = $valeur; //attention
		}
	}

	public function __get($champ) {
		if(isset($this->_attributs[$champ])){
			return $this->_attributs[$champ];
		}

		return null;
	}

	public function __set($champ, $valeur) {
		$this->_attributs[$champ] = $valeur;
	}

}