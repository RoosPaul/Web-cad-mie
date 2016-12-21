<?php

class selection {
	private $model;

    public function __construct() {
        require(ROOT . "/model/selectionModel.php");
        $this->model = new favorite();
    }

    public function index() {
    	$id_ppl = $this->model->get_my_favorite();
    	$data = [];
    	for ($i = 0; $i < count($id_ppl); $i++) {
    		$pseudo = $this->model->id_to_pseudo($id_ppl[$i]['id_following']);
    		$result = $this->model->get_profile($pseudo['pseudo']);
    		$data = array_merge($result, $data);
    	}
        require (ROOT . "/view/selection/home_selection.php");
    }
}