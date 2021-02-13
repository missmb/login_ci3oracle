<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['user'] = $this->db->get_where('USER_SYS', ['EMAIL' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('USER_MENU')->result_array();

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

    // ----------------------------------------------------------------Parking-----------------------------
    public function Parking(){
        $data['title'] = 'Parking Area';
        $data['user'] = $this->db->get_where('USER_SYS', ['EMAIL' => $this->session->userdata('email')])->row_array();
        $data['parking'] = $this->db->get('PARKING_AREA')->result_array();
        $data['menu'] = $this->db->get('USER_MENU')->result_array();

        $this->form_validation->set_rules('area', 'Area', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('admin/parking_area', $data);
            $this->load->view('template/footer', $data);
        } else {
            $this->db->insert('PARKING_AREA', ['AREA' => $this->input->post('area')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Area added!</div>');
            redirect('admin/parking');
        }
    }

    public function deletearea($id)
    {
        $this->db->delete('PARKING_AREA', array('PARKING_ID' => $id));
        redirect('admin/parking');
    }

    public function parkingedit()
    {
        $data['title'] = 'Edit Area';
        $data['user'] = $this->db->get_where('USER_SYS', ['EMAIL' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('USER_MENU')->result_array();
        
        $this->form_validation->set_rules('area', 'Area', 'is_unique[PARKING_AREA.AREA]', [
            'is_unique' => 'This menu aready exist',
        ]);

        if ($this->form_validation->run() == false) {

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('admin/parking_area', $data);
            $this->load->view('template/footer', $data);
        } else {
            $id = $this->input->post('parking_id');
            $area = $this->input->post('area');
            $this->Admin_Model->update($id, $area);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your Area has been updated!</div>');
            redirect('admin/parking');
        }
    }
    
    // ----------------------------------------------------------------Tranportation -----------------------------
    public function Transport(){
        $data['title'] = 'Transportation';
        $data['user'] = $this->db->get_where('USER_SYS', ['EMAIL' => $this->session->userdata('email')])->row_array();
        $data['transport'] = $this->db->get('TRANSPORT')->result_array();
        $data['menu'] = $this->db->get('USER_MENU')->result_array();

        $this->form_validation->set_rules('type', 'type', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('admin/tranport', $data);
            $this->load->view('template/footer', $data);
        } else {
            // var_dump($this->input->post('type'));die();
            $this->db->insert('TRANSPORT', ['TYPE' => $this->input->post('type')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New Transportation added!</div>');
            redirect('admin/transport');
        }
    }

    public function deletetransport($id)
    {
        $this->db->delete('TRANSPORT', array('TRANSPORT_ID' => $id));
        redirect('admin/transport');
    }

    public function TransportEdit()
    {
        $data['title'] = 'Edit Transport';
        $data['user'] = $this->db->get_where('USER_SYS', ['EMAIL' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('USER_MENU')->result_array();

        $this->form_validation->set_rules('type', 'type', 'is_unique[TRANSPORT.TYPE]', [
            'is_unique' => 'This menu aready exist',
        ]);

        if ($this->form_validation->run() == false) {

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('admin/transport', $data);
            $this->load->view('template/footer', $data);
        } else {
            $id = $this->input->post('transport_id');
            $type = $this->input->post('type');
            $this->Admin_Model->UpdateTransport($id, $type);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Transportation has been updated!</div>');
            redirect('admin/transport');
        }
    }

}
