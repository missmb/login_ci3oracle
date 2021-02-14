<?php
defined('BASEPATH') or exit('No direct script access allowed');

use App\Models\Menu_Model;

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_logged_in();
    }

    public function index()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('USER_SYS', ['EMAIL' => $this->session->userdata('email')])->row_array();

        $data['menu'] = $this->Menu_Model->Sidebar();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('template/footer', $data);
    }

    public function edit()
    {
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('USER_SYS', ['EMAIL' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->Menu_Model->Sidebar();

        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

        if ($this->form_validation->run() == false) {

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('template/footer', $data);
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            $upload_image = $_FILES['image']['name'];

            if ($upload_image) {
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '2048';
                $config['upload_path'] = './assets/img/profile/';

                $this->load->library('upload', $config);

                if ($this->upload->do_upload('image')) {
                    $old_image = $data['user']['IMAGE'];
                    // VAR_DUMP($old_image);DIE();
                    if ($old_image != 'default.jpg') {
                        unlink(FCPATH . 'assets/img/profile/' . $old_image);
                    }
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('IMAGE', $new_image);
                } else {
                    echo  $this->upload->display_errors();
                }
            }

            $this->db->set('NAME', $name);
            $this->db->where('EMAIL', $email);
            $this->db->update('USER_SYS');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Your Profile has been updated!</div>');
            redirect('user');
        }
    }

    public function changePassword()
    {
        $data['title'] = 'Change Password';
        $data['user'] = $this->db->get_where('USER_SYS', ['EMAIL' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->Menu_Model->Sidebar();

        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[6]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[6]|matches[new_password1]');
        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('template/footer', $data);
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');

            if (!password_verify($current_password, $data['user']['PASSWORD'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong current password!</div>');
                redirect('user/changepassword');
            } else {
                if ($current_password == $new_password) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">New password cannot be the same as current password!</div>');
                    redirect('user/changepassword');
                } else {
                    $password_hash = password_hash($new_password, PASSWORD_DEFAULT);
                    $this->db->set('PASSWORD', $password_hash);
                    $this->db->where('EMAIL', $this->session->userdata('email'));
                    $this->db->update('USER_SYS');

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Ppassword Changed!</div>');
                    redirect('user/changepassword');
                }
            }
        }
    }

    // ----------------------------------------------------------------Ticket -----------------------------

    public function Ticket(){
        $data['title'] = 'TICKET';
        $data['user'] = $this->db->get_where('USER_SYS', ['EMAIL' => $this->session->userdata('email')])->row_array();
        $data['ticket'] = $this->User_Model->Ticket();
        // $data['ticket'] = $this->db->get('TICKET')->result_array();
        $data['menu'] = $this->Menu_Model->Sidebar();
        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('user/ticket/index', $data);
        $this->load->view('template/footer', $data);
    }

    public function addticket(){
        $data['title'] = 'Add Ticket';
        $data['user'] = $this->db->get_where('USER_SYS', ['EMAIL' => $this->session->userdata('email')])->row_array();
        $data['menu'] = $this->Menu_Model->Sidebar();
        $data['username'] = $this->db->get('USER_SYS')->result_array();
        $data['transport'] = $this->db->get('TRANSPORT')->result_array();
        $data['parking'] = $this->db->get('PARKING_AREA')->result_array();

        $this->form_validation->set_rules('user_enter', 'User Enter', 'required');
        $this->form_validation->set_rules('transport', 'Transport', 'required');
        $this->form_validation->set_rules('parking', 'Parking', 'required');
        $this->form_validation->set_rules('license_plate', 'License Plate', 'required');
        $this->form_validation->set_rules('stnk', 'STNK', 'required');

        if ($this->form_validation->run() == false) {
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('user/ticket/add_ticket', $data);
            $this->load->view('template/footer', $data);
        } else {
            $data = [
                'ENTER' => Date('d-M-y'),
                'USER_ENTER' => $this->input->post('user_enter'),
                'TRANSPORT_ID' => $this->input->post('transport'),
                'PARKING_ID' => $this->input->post('parking'),
                'LICENSE_PLATE' => $this->input->post('license_plate'),
                'STNK' => $this->input->post('stnk')
            ];
            $this->db->insert('TICKET', $data);
            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">New ticked added!</div>');
            redirect('user/ticket');
        }
    }

    public function ExitUser($id) {
        $data = [
            'EXIT' => Date('d-M-y'),
            'STATUS' => 2,
        ];
        // var_dump($data);die();
        $this->db->where('TICKET_ID', $id)->update('TICKET', $data);
        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Success Edit Data!</div>');
        redirect('user/ticket');
    }
}
