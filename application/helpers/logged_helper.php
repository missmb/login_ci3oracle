<?php
function is_logged_in()
{
    $ci = get_instance(); //= $this
    if (!$ci->session->userdata('email')) {
        redirect('auth');
    } else {
        $role_id = $ci->session->userdata('role_id');
        $menu = $ci->uri->segment(1);
        // $queryMenu = $ci->db->get_where('user_menu', ['menu' => $menu] )->row_array();

        $queryMenu = $ci->db->get_where('USER_MENU', ['MENU' => $menu])->row_array();
        // $menu_id = 2;
        $menu_id = $queryMenu['MENU_ID'];

        $userAccess = $ci->db->get_where('USER_ACCESS_MENU', [
            'ROLE_ID' => $role_id,
            'MENU_ID' => $menu_id
        ]);



        // Sintak ini mengambil uri segment pada uri
        // $menu = $ci->uri->segment(1);


        //query ini mengambil data berdasrkan variabel $menu 
        $queryMenu = $ci->db->get_where('USER_MENU', ['MENU' => $menu])->row_array();


        $userAccess = $ci->db->get_where(
            'USER_ACCESS_MENU',
            ['ROLE_ID' => $role_id, 'MENU_ID' => $menu_id]
        );
        // var_dump($menu_id);die;
        // var_dump($queryMenu);die;
        if ($userAccess->num_rows() < 1) {
            // var_dump($userAccess->num_rows());die;
            redirect('auth/blocked');
        }
    }
}


function check_access($role_id, $menu_id)
{
    $ci = get_instance();

    $ci->db->where('ROLE_ID', $role_id);
    $ci->db->where('MENU_ID', $menu_id);

    $result = $ci->db->get('USER_ACCESS_MENU');

    if ($result->num_rows() > 0) {

        return "checked='checked'";
    }
}
