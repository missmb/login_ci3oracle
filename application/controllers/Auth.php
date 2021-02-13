<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('form_validation');
    }
    public function index()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required|trim');

        if ($this->form_validation->run() == false) {
            $data['title'] = 'login';
            $this->load->view('template/auth_header', $data);
            $this->load->view('auth/login.php');
            $this->load->view('template/auth_footer');
        } else {
            $this->_login();
        }
    }

    private function _login()
    {
        $email = $this->input->post('email');
        $password = $this->input->post('password');

        $user = $this->db->get_where('USER_SYS', ['EMAIL' => $email])->row_array();
        // var_dump($user); die;

        if ($user) {

            if ($user['IS_ACTIVE'] == 1) {
                if (password_verify($password, $user['PASSWORD'])) {
                    $data = [
                        'email' => $user['EMAIL'],
                        'role_id' => $user['ROLE_ID']
                    ];
                    $this->session->set_userdata($data);

                    if ($user['ROLE_ID'] == 1) {
                        redirect('admin');
                    } else {
                        redirect('user');
                    }
                } else {
                    $data = [
                        'password' => $user['PASSWORD'],
                        'role_id' => $user['ROLE_ID']
                    ];
                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong Password! </div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">This email has not been activated!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not registered!</div>');
            redirect('auth');
        }
    }

    public function registration()
    {
        if ($this->session->userdata('email')) {
            redirect('user');
        }

        $this->form_validation->set_rules('name', 'Name', 'required|trim');
        $this->form_validation->set_rules('email', 'Email', 'required|trim|valid_email|is_unique[USER_SYS.EMAIL]', [
            'is_unique' => 'This email aready registered',
        ]);
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[6]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password2', 'Password', 'required|matches[password1]');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'registration';
            $this->load->view('template/auth_header', $data);
            $this->load->view('auth/registration.php');
            $this->load->view('template/auth_footer');
        } else {
            $email = $this->input->post('email');
            $data = [
                // 'name' => $this->input->post('name'),
                // 'email' => $this->input->post('email'),
                'EMAIL' => htmlspecialchars($email),
                'NAME' => htmlspecialchars($this->input->post('name')),
                'IMAGE' => 'default.jpg',
                'ROLE_ID' => 2,
                'PASSWORD' => password_hash($this->input->post('password1'), PASSWORD_DEFAULT),
                'IS_ACTIVE' => 0,
                'DATE_CREATED' => Date('d-M-s')
            ];

            $int = 33;
            $strong = true;
            // base64_encode(random_bytes(33));
            $token = base64_encode(openssl_random_pseudo_bytes($int));
            $user_token = [
                'EMAIL' => $email,
                'TOKEN' => $token,
                'DATE_CREATED' => Date('d-M-s')
            ];

            $this->db->insert('USER_SYS', $data);
            $this->db->insert('USER_TOKEN', $user_token);

            $this->_sendEmail($token , 'verify');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Congratulation! your account has been created. Please Activate your account</div>');
            redirect('auth');
        }
    }


    private function _sendEmail($token, $type)
    {
        // var_dump($token);die();
        $config  = [
            'protocol'  => 'smtp',
            'smtp_host' => 'ssl://smtp.googlemail.com',
            'smtp_user' => 'maratulbariroh3630@gmail.com',
            'smtp_pass' => "Mojowarno'Menganto210",
            'smtp_port' => 465,
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'newline'   => "\r\n"
        ];

        $this->email->initialize($config);

        $this->email->from('maratulbariroh3630@gmail.com', 'missMb');
        $this->email->to($this->input->post('email'));

        if ($type == 'verify') {
            $this->email->subject('Account Varification');
            $this->email->message('Click this link to verify you account : <a href="' . base_url() . 'auth/verify?email=' . $this->input->post('email') . '&token=' .$token . '">Activate</a>');
        } else if ($type == 'forgot') {
            $this->email->subject('Reset Password');
            $this->email->message('Click this link to reset your password : <a href="' . base_url() . 'auth/resetpassword?email=' . $this->input->post('email') . '&token=' . $token . '">Reset Password</a>');
        }

        if ($this->email->send()) {
            return true;
        } else {
            echo $this->email->print_debugger();
            die;
        }
    }

    public function verify()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');


        $user = $this->db->get_where('USER_SYS', ['EMAIL' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('USER_TOKEN', ['TOKEN' => $token])->row_array();
            // var_dump($token, $user_token);DIE();
            if ($user_token) {
                if (time() - $user_token['DATE_CREATED' < (60 * 60 * 24)]) {
                    $this->db->set('IS_ACTIVE', 1);
                    $this->db->where('EMAIL', $email);
                    $this->db->update('USER_SYS');

                    $this->db->delete('USER_TOKEN', ['EMAIL' => $email]);

                    $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">' . $email . ' has been activated! Please Login</div>');
                    redirect('auth');
                } else {
                    $this->db->delete('USER_SYS', ['EMAIL' => $email]);
                    $this->db->delete('USER_TOKEN', ['EMAIL' => $email]);


                    $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong activation failed! Token expired.</div>');
                    redirect('auth');
                }
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Wrong activation token failed!</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Account activation failed! Wrong Email.</div>');
            redirect('auth');
        }
    }

    public function logout()
    {
        $this->session->unset_userdata('email');
        $this->session->unset_userdata('role_admin');

        $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">You have been logged out!</div>');
        redirect('auth');
    }

    public function blocked()
    {
        $this->load->view('auth/blocked');
    }

    public function forgotPassword()
    {
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
        if ($this->form_validation->run() == false) {
            $data['title'] = 'Forgot Password';
            $this->load->view('template/auth_header', $data);
            $this->load->view('auth/forgotpassword.php');
            $this->load->view('template/auth_footer');
        } else {
            $email = $this->input->post('email');
            $user = $this->db->get_where('USER_SYS', ['email' => $email, 'is_active' => 1])->row_array();

            if ($user) {
                $token = base64_encode(random_bytes(33));
                $user_token = [
                    'email' => $email,
                    'token' => $token,
                    'date_created' => time()
                ];

                $this->db->insert('user_token', $user_token);
                $this->_sendEmail($token, 'forgot');
                $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Please check your email to reset your password</div>');
                redirect('auth/forgotpassword');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Email is not registerd or activated!</div>');
                redirect('auth/forgotpassword');
            }
        }
    }

    public function resetpassword()
    {
        $email = $this->input->get('email');
        $token = $this->input->get('token');


        $user = $this->db->get_where('USER_SYS', ['email' => $email])->row_array();

        if ($user) {
            $user_token = $this->db->get_where('user_token', ['token' => $token])->row_array();

            if ($user_token) {
                $this->session->set_userdata('reset_email', $email);
                $this->changePassword();
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password failed! Wrong token.</div>');
                redirect('auth');
            }
        } else {
            $this->session->set_flashdata('message', '<div class="alert alert-danger" role="alert">Reset password failed! Wrong email.</div>');
            redirect('auth');
        }
    }

    public function changePassword(){
        if(!$this->session->userdata('reset_email')){
            redirect('auth');
        }
        $this->form_validation->set_rules('password1', 'Password', 'required|trim|min_length[6]|matches[password2]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);
        $this->form_validation->set_rules('password2', 'Repeat Password', 'required|trim|min_length[6]|matches[password1]', [
            'matches' => 'Password dont match!',
            'min_length' => 'Password too short!'
        ]);

        if($this->form_validation->run() == false ){
            $data['title'] = 'Change Password';
            $this->load->view('template/auth_header', $data);
            $this->load->view('auth/change-password');
            $this->load->view('template/auth_footer');
        } else {
            $pass = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
            $email = $this->session->userdata('reset_email');

            $this->db->set('password', $pass);
            $this->db->where('email', $email);
            $this->db->update('USER_SYS');

            $this->session->unset_userdata('reset_email');

            $this->session->set_flashdata('message', '<div class="alert alert-success" role="alert">Password has been changed! Please loin.</div>');
            redirect('auth');
        }
    }
}
 