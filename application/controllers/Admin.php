<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // if(!$this->session->userdata('email')){
        //     redirect('auth');
        // }
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('USER_SYS', ['EMAIL' => $this->session->userdata('email')])->row_array();
        // echo 'welcome '.$data['user']['name'];

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/index', $data);
        $this->load->view('template/footer', $data);
    }

    public function Role()
    {
        $data['title'] = 'Role';
        $data['user'] = $this->db->get_where('USER_SYS', ['EMAIL' => $this->session->userdata('email')])->row_array();
        $data['role'] = $this->db->get('USER_ROLE')->result_array();
    
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/role', $data);
        $this->load->view('template/footer', $data);
    }

    public function roleAccess($role_id)
    {
        $data['title'] = 'Role Access';
        $data['user'] = $this->db->get_where('USER_SYS', ['EMAIL' => $this->session->userdata('email')])->row_array();
        $data['role'] = $this->db->get_where('USER_ROLE', ['ROLE_ID' => $role_id])->row_array();

        $this->db->where('ROLE_ID !=', 1);
        $data['menu'] = $this->db->get('USER_MENU')->result_array();
    
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('admin/role-access', $data);
        $this->load->view('template/footer', $data);
    }


    public function changeAccess(){
        $menu_id = $this->input->post('menuId');
        $role_id = $this->input->post('roleId');
  
        $data = [
            'ROLE_ID' => $role_id,
            'MENU_ID' => $menu_id
        ];

        $result = $this->db->get_where('USER_ACCESS_MENU', $data);

        if($result->num_rows() < 1) {
            $this->db->insert('USER_ACCESS_MENU', $data);

        } 
        else {
            $this->db->delete('USER_ACCESS_MENU', $data);

        }

        $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Access Changed! </div>');

    }
}
