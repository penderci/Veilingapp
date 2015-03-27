<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends CI_Controller {

    public function index()
    {
        //$this->load->view('welcome_message');

        $data['middle'] = '/login/login';
        $this->load->view('template',$data);

    }

    public function login_validation(){
        //xss_clean Provides Cross Site Script Hack filtering.
        $this->form_validation->set_rules('inputEmail','Email','required|trim|callback_validate_credentials|xss_clean') ;
        $this->form_validation->set_rules('inputPassword','Password','required|trim|md5');

        if($this->form_validation->run()){
            //$this->load->view('/todo/todo_view');
            redirect(base_url().'aankopen');
        } else {
            //redirect(base_url().'login');
            $data['middle'] = '/login/login';
            $this->load->view('template',$data);

        }
    }

    public function validate_credentials(){
        if($this->User_model->can_login()){
            $data = array(
                'email'=>$this->input->post('inputEmail'),
                'is_logged_in'=> 1
            );
            $this->session->set_userdata($data);
            return true;
        } else {
            $this->form_validation->set_message('validate_credentials','Incorrect username/password');
            return false;
        }
    }

    public function logout(){
        $this->session->sess_destroy();
        redirect(base_url().'login');
    }
}