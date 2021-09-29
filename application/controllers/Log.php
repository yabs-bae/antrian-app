
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Log extends MY_Controller {
		public function __construct()
		{
			parent::__construct();
			$role = $this->mymodel->selectDataone('role',['id'=>$this->session->userdata('role_id')]);
			if($role['role']!="Admin") redirect('/','refresh');
		}

        public function index()
        {
            $data['page_name'] = "log";
			$this->template->load('template/template','log/index',$data);
        }

		public function json()
		{
            $user = $this->input->get('user_id');
			header('Content-Type: application/json');
	        $this->datatables->select('log.id,log.activity,log.date,user.name');
            if($user){
	        $this->datatables->where('log.user_id',$user);
            }
	        $this->datatables->join('user','user.id=log.user_id');
	        $this->datatables->from('log');
	        echo $this->datatables->generate();
		}

	}
?>