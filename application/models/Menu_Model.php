<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Menu_Model extends CI_Model
{

    public function getSubMenu()
    {
        $query = " SELECT `user_sub_menu`.*, `user_menu`.
        `menu`
        FROM `user_sub_menu` JOIN `user_menu`
        ON `user_sub_menu`.`menu_id` = `user_menu`.`id`";

        return $this->db->query($query)->result_array();
    }

    public function updateSubMenu($id, $menu_id, $title, $url, $icon, $is_active)
    {
        $data = array(
            'menu_id' => $menu_id,
            'title' => $title,
            'url' => $url,
            'icon' => $icon,
            'is_active' => $is_active,
        );
        $this->db->where('id', $id);
        $this->db->update('user_sub_menu', $data);
    }

    public function update($id, $menu)
    {
        $data = array(
            'menu' => $menu
        );
        $this->db->where('id', $id);
        $this->db->update('user_menu', $data);
    }
}
