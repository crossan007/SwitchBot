<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

Class Device {
  public $name = "Generic Device";
  public $properties;
  public $ID;

  public function Save() {
    echo json_encode($this->properties);
  }

  public function Load($id) {
    
  }

}


?>

