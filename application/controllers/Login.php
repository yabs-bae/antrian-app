<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Login extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
        $data = [];
		$this->load->view('login/login',$data);
    }
    

	public function logout()
	{
        
        $this->session->sess_destroy();
        redirect('login','refresh');
    }
    

	public function act_login()
    {

        
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $pass = md5($password);

            $cek     = $this->mlogin->login($username,$pass);
            $session = $this->mlogin->data($username);

            if ($cek > 0) {
                $file = $this->mymodel->selectDataone('file',['table'=>'user','table_id'=>  $session->id]);

                $this->session->set_userdata('session_sop', true);
                $this->session->set_userdata('id', $session->id);
                $this->session->set_userdata('username', $session->username);
                $this->session->set_userdata('role_id', $session->role_id);
                $this->session->set_userdata('role_slug', $session->role_slug);
                $this->session->set_userdata('role_name', $session->role_name);
                $this->session->set_userdata('name', $session->name);
                $this->session->set_userdata('avatar', base_url($file['dir']));

                $this->mymodel->insertData('log',['activity'=>'melakukan login','user_id'=>$this->session->userdata('id')]);
                
                echo "oke";
                return TRUE;
            } else {
                $this->alert->alertdanger('Check again your username and password');
                return FALSE;
            }
    }

}
/* End of file Login.php */
/* Location: ./application/controllers/Login.php */