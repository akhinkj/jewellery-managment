<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Auth extends CI_Controller {

    // public function __construct() {
    //     parent::__construct();
    //     $this->load->model('User_model');
    // }
    public function __construct() {
        parent::__construct();
        $this->load->library('session');  // Add this line
        $this->load->model('User_model');
    }

    public function login() {
        if($this->session->userdata('logged_in')) {
            redirect('index.php/admin/products');
        }

        if($this->input->post()) {
            $username = $this->input->post('username');
            $password = $this->input->post('password');

            $user = $this->User_model->get_user($username);

            if($user && password_verify($password, $user->password)) {
                $this->session->set_userdata('logged_in', TRUE);
                redirect('index.php/admin/products');
            } else {
                $this->session->set_flashdata('error', 'Invalid credentials');
            }
        }

        $this->load->view('auth/login');
    }

    public function logout() {
        $this->session->unset_userdata('logged_in');
        redirect('auth/login');
    }
}