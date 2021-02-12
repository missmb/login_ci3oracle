<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Menu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'Menu Management';
        $data['user'] = $this->db->get_where('USER_SYS', ['EMAIL' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('USER_MENU')->result_array();

        $this->form_validation->set_rules('menu', 'Menu', 'required');

        if ($this->form_validation->run() == false) {

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('template/footer', $data);
        } else {
            $this->db->insert('USER_MENU', ['MENU' => $this->input->post('menu')]);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New menu added!</div>');
            redirect('menu');
        }
    }

    public function submenu()
    {
        $data['title'] = 'SubMenu Management';
        $data['user'] = $this->db->get_where('USER_SYS', ['EMAIL' => $this->session->userdata('email')])->row_array();
        $this->load->model('Menu_Model', 'menu'); //alias menu

        // $data['subMenu'] = $this->db->get('user_sub_menu')->result_array();
        $data['subMenu'] = $this->menu->getSubMenu();
        $data['menu'] = $this->db->get('USER_MENU')->result_array();

        $this->form_validation->set_rules('title', 'Title', 'required');
        $this->form_validation->set_rules('menu_id', 'Menu_id', 'required');
        $this->form_validation->set_rules('url', 'Url', 'required');
        $this->form_validation->set_rules('icon', 'Icon', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('menu/submenu', $data);
            $this->load->view('template/footer', $data);
        } else {
            $data = [
                'TITLE' => $this->input->post('title'),
                'MENU_ID' => $this->input->post('menu_id'),
                'URL' => $this->input->post('url'),
                'ICON' => $this->input->post('icon'),
                'IS_ACTIVE' => $this->input->post('is_active')
            ];
            $this->db->insert('USER_SUB_MENU', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New sub menu added!</div>');
            redirect('menu/submenu');
        }
    }

    public function delete($id)
    {
        $this->db->delete('USER_MENU', array('MENU_ID' => $id));
        redirect('menu');
    }

    public function edit()
    {
        $data['title'] = 'Edit Menu';
        $data['user'] = $this->db->get_where('USER_SYS', ['EMAIL' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('USER_MENU')->result_array();
        // $data['user'] = $this->db->get_where('user', ['email' => $this->session->userdata('email')])->row_array();

        $this->form_validation->set_rules('menu', 'Menu', 'is_unique[USER_MENU.MENU]', [
            'is_unique' => 'This menu aready exist',
        ]);

        if ($this->form_validation->run() == false) {

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('menu/index', $data);
            $this->load->view('template/footer', $data);
        } else {
            $id = $this->input->post('menu_id');
            $menu = $this->input->post('menu');
            $this->Menu_Model->update($id, $menu);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your Menu has been updated!</div>');
            redirect('menu');
        }
    }

    function deleteSubMenu($id)
    {
        $this->db->delete('USER_SUB_MENU', array('SUB_ID' => $id));
        redirect('menu/submenu');
    }

    public function editSubMenu()
    {
        $data['title'] = 'Edit Menu';
        $data['user'] = $this->db->get_where('USER_SYS', ['EMAIL' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->db->get('USER_MENU')->result_array();
        if ($this->input->post('title') > 0) {

            $this->form_validation->set_rules('title', 'title', 'is_unique[user_sub_menu.title]', [
                'is_unique' => 'This menu aready exist',
            ]);

            if ($this->form_validation->run() == false) {

                $this->load->view('template/header', $data);
                $this->load->view('template/sidebar', $data);
                $this->load->view('template/topbar', $data);
                $this->load->view('menu/index', $data);
                $this->load->view('template/footer', $data);
            } else {
                $id = $this->input->post('id');
                $menu_id = $this->input->post('menu_id');
                $title = $this->input->post('title');
                $url = $this->input->post('url');
                $icon = $this->input->post('icon');
                $is_active = $this->input->post('is_active');
                $this->Menu_Model->updateSubMenu($id, $menu_id, $title, $url, $icon, $is_active);
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your SubMenu has been updated!</div>');
                redirect('menu/submenu');
            }
        } else {
            $id = $this->input->post('id');
            $menu_id = $this->input->post('menu_id');
            $title = $this->input->post('title');
            $url = $this->input->post('url');
            $icon = $this->input->post('icon');
            $is_active = $this->input->post('is_active');
            $this->Menu_Model->updateSubMenu($id, $menu_id, $title, $url, $icon, $is_active);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your SubMenu has been updated!</div>');
            redirect('menu/submenu');
        }
    }
}
