<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        //is_logged_in();
        if (!$this->session->userdata('email')) {
            redirect('auth');
            // ini kalo belum login
        } 
        // else if ($this->session->userdata('role_id') == 1) {

        //     redirect('auth');
        //     //panggil function
        // }
    }

    public function index()
    {
        $data['title'] = 'My Profile';
        $data['user'] = $this->db->get_where('USER_SYS', ['EMAIL' => $this->session->userdata('email')])->row_array();
        // echo 'welcome '.$data['user']['name'];

        $this->load->view('template/header', $data);
        $this->load->view('template/sidebar', $data);
        $this->load->view('template/topbar', $data);
        $this->load->view('user/index', $data);
        $this->load->view('template/footer', $data);
    }

    public function edit(){
        $data['title'] = 'Edit Profile';
        $data['user'] = $this->db->get_where('USER_SYS', ['EMAIL' => $this->session->userdata('email')])->row_array();
        
        $this->form_validation->set_rules('name', 'Full Name', 'required|trim');

        if($this->form_validation->run() == false){

            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('user/edit', $data);
            $this->load->view('template/footer', $data);
        } else {
            $name = $this->input->post('name');
            $email = $this->input->post('email');

            $upload_image = $_FILES['image']['name'];

            if($upload_image){
                $config['allowed_types'] = 'gif|jpg|png';
                $config['max_size'] = '2048';
                $config['upload_path'] = './assets/img/profile/';

                $this->load->library('upload', $config);

                if($this->upload->do_upload('image')){
                    $old_image = $data['user']['image'];
                    if($old_image != 'default.jpg'){
                        unlink(FCPATH . 'assets/img/profile/' . $old_image); 
                    }
                    $new_image = $this->upload->data('file_name');
                    $this->db->set('image', $new_image);
                }else {
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
        
        $this->form_validation->set_rules('current_password', 'Current Password', 'required|trim');
        $this->form_validation->set_rules('new_password1', 'New Password', 'required|trim|min_length[6]|matches[new_password2]');
        $this->form_validation->set_rules('new_password2', 'Confirm New Password', 'required|trim|min_length[6]|matches[new_password1]');
        if($this->form_validation->run() == false){
            $this->load->view('template/header', $data);
            $this->load->view('template/sidebar', $data);
            $this->load->view('template/topbar', $data);
            $this->load->view('user/changepassword', $data);
            $this->load->view('template/footer', $data);
        } else {
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password1');

            if (!password_verify($current_password, $data['user']['password'])) {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong current password!</div>');
                redirect('user/changepassword');
            } else {
                if($current_password == $new_password){
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">New password cannot be the same as current password!</div>');
                redirect('user/changepassword');
                } else  {
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
}
