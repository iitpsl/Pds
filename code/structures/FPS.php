<?php

class FPS {
    public $district;
    public $name;
    public $id;
    public $type;
    public $latitude;
    public $longitude;
    public $storage;
    public $uniqueid;

    // Getter methods
    public function getDistrict() {
        return $this->district;
    }

    public function getName() {
        return $this->name;
    }

    public function getId() {
        return $this->id;
    }

    public function getType() {
        return $this->type;
    }

    public function getLatitude() {
        return $this->latitude;
    }

    public function getLongitude() {
        return $this->longitude;
    }

    public function getDemand() {
        return $this->demand;
    }
	
	public function getUniqueid() {
        return $this->uniqueid;
    }


    // Setter methods

    public function setDistrict($district) {
        $this->district = $district;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function setLatitude($latitude) {
        $this->latitude = $latitude;
    }

    public function setLongitude($longitude) {
        $this->longitude = $longitude;
    }

    public function setDemand($demand) {
        $this->demand = $demand;
    }
	
	public function setUniqueid($uniqueid) {
        $this->uniqueid = $uniqueid;
    }
	
	function insert(FPS $fps){
        return "INSERT INTO fps (district, name, id, type, latitude, longitude, demand, uniqueid) VALUES ('".$fps->getDistrict()."','".$fps->getName()."','".$fps->getId()."','".$fps->getType()."','".$fps->getLatitude()."','".$fps->getLongitude()."','".$fps->getDemand()."','".$fps->getUniqueid()."')";
    }

    function delete(FPS $fps){
        return "DELETE FROM fps WHERE uniqueid='".$fps->getUniqueid()."'";
    }
	
	function check(FPS $fps){
        return "SELECT * FROM fps WHERE uniqueid='".$fps->getUniqueid()."'";
    }
	
	function checkEdit(FPS $fps){
        return "SELECT * FROM fps WHERE id='".$fps->getId()."'";
    }

    function update(FPS $fps){
      return  "UPDATE fps SET district = '".$fps->getDistrict()."',name = '".$fps->getName()."',id = '".$fps->getId()."',type = '".$fps->getType()."',latitude = '".$fps->getLatitude()."',longitude = '".$fps->getLongitude()."',demand = '".$fps->getDemand()."' WHERE uniqueid = '".$fps->getUniqueid()."'";
    }
	
	function updateEdit(FPS $fps){
      return  "UPDATE fps SET district = '".$fps->getDistrict()."',name = '".$fps->getName()."',id = '".$fps->getId()."',type = '".$fps->getType()."',latitude = '".$fps->getLatitude()."',longitude = '".$fps->getLongitude()."',demand = '".$fps->getDemand()."' WHERE id = '".$fps->getId()."'";
    }
}

?>