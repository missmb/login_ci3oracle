<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Menu_Model extends CI_Model
{

    public function getSubMenu()
    {
        $query = " SELECT USER_SUB_MENU.*, USER_MENU.
        MENU
        FROM USER_SUB_MENU JOIN USER_MENU
        ON USER_SUB_MENU.MENU_ID = USER_MENU.MENU_ID";

        return $this->db->query($query)->result_array();
    }

    public function updateSubMenu($id, $menu_id, $title, $url, $icon, $is_active)
    {
        $data = array(
            'MENU_ID' => $menu_id,
            'TITLE' => $title,
            'URL' => $url,
            'ICON' => $icon,
            'IS_ACTIVE' => $is_active,
        );
        $this->db->where('SUB_ID', $id);
        $this->db->update('USER_SUB_MENU', $data);
    }

    public function update($id, $menu)
    {
        $data = array(
            'MENU' => $menu
        );
        $this->db->where('MENU_ID', $id);
        $this->db->update('USER_MENU', $data);
    }

    public function Sidebar()
    {
        $role_id = $this->session->userdata('role_id');

        $query = " SELECT USER_MENU.MENU_ID, USER_MENU.MENU
                       FROM USER_MENU JOIN USER_ACCESS_MENU
                           ON USER_MENU.MENU_ID = USER_ACCESS_MENU.MENU_ID
                        WHERE USER_ACCESS_MENU.ROLE_ID =$role_id 
                     ORDER BY USER_ACCESS_MENU.MENU_ID ASC";
        return $this->db->query($query)->result_array();
    }
    
}
