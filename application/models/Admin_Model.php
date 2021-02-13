<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Admin_Model extends CI_Model
{
    public function update($id, $area)
    {
        $data = array(
            'AREA' => $area
        );
        // var_dump($data);die();
        $this->db->where('PARKING_ID', $id);
        $this->db->update('PARKING_AREA', $data);
    }

    public function UpdateTransport($id, $type)
    {
        $data = array(
            'TYPE' => $type
        );
        // var_dump($data);die();
        $this->db->where('TRANSPORT_ID', $id);
        $this->db->update('TRANSPORT', $data);
    }
}