<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Talento_slim_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function insert($data){
        return ($this->db->insert('talento_slim' , $data)) ? $this->db->insert_id() : false;
    }
    
}

?>
