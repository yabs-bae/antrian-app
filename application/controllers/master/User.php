<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		$role = $this->mymodel->selectDataone('role',['id'=>$this->session->userdata('role_id')]);
		if($role['role']!="Admin") redirect('/','refresh');
	}
	public function index()
	{
		$this->data['page_name'] = 'master';
		$this->template->load('template/template','master/user/user',$this->data);
	}

	public function json()
	{
		header('Content-Type: application/json');
        $this->datatables->select('user.id,user.username,user.name,role.role,user.desc,file.dir');
        $this->datatables->join('role','user.role_id=role.id','left');
        $this->datatables->join('file',"file.table_id=user.id AND `file`.`table` = 'user'",'left');

        $this->datatables->where(array('user.status'=>0));

        $this->datatables->from('user');
        $this->datatables->add_column('view', '
													<button onclick="edit($1)" class="btn btn-primary btn-flat btn-sm"Edit><span class="txt-white fa fa-edit"></span> Edit</button> 
													<button onclick="hapus($1)"  class="btn btn-danger btn-flat btn-sm"><span class="txt-white fa fa-trash"></span> Hapus</button>  
											', 'id');
        echo $this->datatables->generate();
	}


	function json_activity($id)
	{
		$this->datatables->select('ip,link,get,post,user_id,created_at');
        $this->datatables->where(array('user_id'=>$id));
        $this->datatables->from('activity');
        echo $this->datatables->generate();
		
	}

	public function store()
	{
		$this->form_validation->set_error_delimiters('<li>', '</li>');
	
        $this->form_validation->set_rules(
        'dt[username]', '<strong>Username</strong>',
        'required|is_unique[user.username]',
        array(
                'required'      => 'You have not provided %s.',
                'is_unique'     => 'This %s already exists.'
        )
		);
		$this->form_validation->set_rules(
        'dt[email]', '<strong>Email</strong>',
        'required|is_unique[user.email]',
        array(
                'required'      => 'You have not provided %s.',
                'is_unique'     => 'This %s already exists.'
        )
		);
		$this->form_validation->set_rules('dt[password]', '<strong>Pasword</strong>', 'required|min_length[6]|callback_password_check');
			$this->form_validation->set_rules('password_confirmation_field', 'Password Confirmation Field', 'required|matches[dt[password]]');

		$this->form_validation->set_rules('dt[name]', '<strong>Name</strong>', 'required');

		$this->form_validation->set_rules('dt[role_id]', '<strong>Role</strong>', 'required');
		$this->form_validation->set_rules('dt[desc]', '<strong>Description</strong>', 'required');


    	if ($this->form_validation->run() == FALSE){
			$error =  validation_errors();
			$this->alert->alertdanger($error);
             
        }else{
        	
        
        		$dt = $_POST['dt'];
        		$role = $this->mymodel->selectWhere('role',['id'=>$dt['role_id']]);
        		$dt['role_slug'] = $role['slug'];
        		$dt['role_name'] = $role['role'];
        		$dt['password'] = md5($dt['password']);
        		$dt['created_at'] = date('Y-m-d H:i:s');
    			$this->db->insert('user',$dt);
				$last_id = $this->db->insert_id();	   
			 if (!empty($_FILES['file']['name'])){
	        	$dir  = "webfile/";
				$config['upload_path']          = $dir;
				$config['allowed_types']        = '*';
				$config['file_name']           = md5('smartsoftstudio').rand(1000,100000);

				$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('file')){
					$error = $this->upload->display_errors();
					$this->alert->alertdanger($error);		
				}else{
				   	$file = $this->upload->data();
					$data = array(
				   				'id' => '',
				   				'name'=> $file['file_name'],
				   				'mime'=> $file['file_type'],
				   				'dir'=> $dir.$file['file_name'],
				   				'table'=> 'user',
				   				'table_id'=> $last_id,
				   				'status'=>'ENABLE',
				   				'created_at'=>date('Y-m-d H:i:s')
				   	 		);
				   	$str = $this->db->insert('file', $data);
					$this->alert->alertsuccess('Success Send Data');    
				} 
			}else{
				$data = array(
			   				'id' => '',
			   				'name'=> '',
			   				'mime'=> '',
			   				'dir'=> '',
			   				'table'=> 'user',
			   				'table_id'=> $last_id,
			   				'status'=>'ENABLE',
			   				'created_at'=>date('Y-m-d H:i:s')
			   	 		);

			   	$str = $this->db->insert('file', $data);
				$this->alert->alertsuccess('Success Send Data');

			}


        }
	}

	public function edit($id)
	{
		$data['user'] = $this->mymodel->selectDataone('user',array('id'=>$id));
		$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'user'));

		$this->load->view('master/user/user-edit',$data);
	}

	public function editUser($id)
	{
		$id = $this->template->sonDecode($id);
		$data['user_data'] = $this->mymodel->selectDataone('user',array('id' =>$id));
		$data['file'] = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'user'));
		$data['page_name'] = 'master';
		$data['id'] = $id;

		$this->template->load('template/template','master/user/edit-user',$data);
	}

	public function updateUser()
	{
		$param = $this->input->post();
		$id = $param['ids'];

		$dataup = array('name' => $param['name'],
					  	'email' => $param['email'],
					  	'desc' => $param['desc'],
					 );

		if($_FILES['file']['name']!='')
	    {
	        $dir  = "webfile/";
			$config['upload_path']          = $dir;
			$config['allowed_types']        = '*';
			$config['file_name']           = md5('smartsoftstudio').rand(1000,100000);

	        $this->load->library('upload', $config);
	        $this->upload->initialize($config);
	        
	        if ( ! $this->upload->do_upload('file')){
					$error = $this->upload->display_errors();
					// $this->alert->alertdanger($error);		
			}else{
				$file = $this->upload->data();
				$data = array(
			   				'name'=> $file['file_name'],
			   				'mime'=> $file['file_type'],
			   				// 'size'=> $file['file_size'],
			   				'dir'=> $dir.$file['file_name'],
			   				'table'=> 'user',
			   				'table_id'=> $id,
			   				'updated_at'=>date('Y-m-d H:i:s')
			   	 		);
				$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'user'));
				@unlink($file['dir']);
				if($file==""){
					$this->mymodel->insertData('file', $data);
				}else{
					$this->mymodel->updateData('file', $data , array('id'=>$file['id']));
				}
				

				$dataup['updated_at'] = date("Y-m-d H:i:s");
				$this->mymodel->updateData('user', $dataup , array('id'=>$id));

				$this->alert->alertsuccess('Success Update Data');  
				// redirect('master/user/editUser/'.$id,'refresh');
			}
		}else{

			$dataup['updated_at'] = date("Y-m-d H:i:s");
			$this->mymodel->updateData('user', $dataup , array('id'=>$id));
			$this->alert->alertsuccess('Success Update Data');

			// redirect('master/user/editUser/'.$id,'refresh');
		}

	}

	public function update()
	{
		$this->form_validation->set_error_delimiters('<li>', '</li>');
    	$username = $_POST['dt']['username'];
    	$email = $_POST['dt']['email'];
    	$password = $this->input->post('password');

    	$username1 = $this->input->post('username');
		if($username!=$username1){
	        $this->form_validation->set_rules(
	        'dt[username]', '<strong>username</strong>',
	        'required|is_unique[user.username]',
	        array(
	                'required'      => 'You have not provided %s.',
	                'is_unique'     => 'This %s already exists.'
	        )
			);
    	}

    	$email1 = $this->input->post('email');
    	if($email!=$email1){
	        $this->form_validation->set_rules(
	        'dt[email]', '<strong>email</strong>',
	        'required|is_unique[user.email]',
	        array(
	                'required'      => 'You have not provided %s.',
	                'is_unique'     => 'This %s already exists.'
	        )
			);
    	}


    	if($password!=""){
	        	// $dt['password'] = md5($password);
			// $this->form_validation->set_rules('dt[password]', '<strong>Pasword</strong>', 'required');
			$this->form_validation->set_rules('password', '<strong>Pasword</strong>', 'required|min_length[6]|callback_password_check');
			$this->form_validation->set_rules('password_confirmation_field', 'Password Confirmation Field', 'required|matches[password]');

    	}


		$this->form_validation->set_rules('dt[name]', '<strong>Name</strong>', 'required');
		$this->form_validation->set_rules('dt[role_id]', '<strong>Role</strong>', 'required');
		$this->form_validation->set_rules('dt[desc]', '<strong>Description</strong>', 'required');


    	if ($this->form_validation->run() == FALSE){
			$error =  validation_errors();
			$this->alert->alertdanger($error);
             
        }else{
        	
        	$dt = $this->input->post('dt');
        	$id = $this->input->post('ids');
        	if($password!=""){
	        	$dt['password'] = md5($password);
        	}
        	// $dt['updated_at'] = date('Y-m-d H:i:s');
        	// $this->mymodel->updateData('user',$dt,array('id'=>$ids));
        	// $this->alert->alertsuccess('Success Send Data');
        	if (!empty($_FILES['file']['name'])){
	        		$dir  = "webfile/";
					$config['upload_path']          = $dir;
					$config['allowed_types']        = '*';
					$config['file_name']           = md5('smartsoftstudio').rand(1000,100000);
	        		$this->load->library('upload', $config);
				if ( ! $this->upload->do_upload('file')){
						$error = $this->upload->display_errors();
						$this->alert->alertdanger($error);		
					}else{
						$file = $this->upload->data();
						$data = array(
					   				'name'=> $file['file_name'],
					   				'mime'=> $file['file_type'],
					   				// 'size'=> $file['file_size'],
					   				'dir'=> $dir.$file['file_name'],
					   				'table'=> 'user',
					   				'table_id'=> $id,
					   				'updated_at'=>date('Y-m-d H:i:s')
					   	 		);
						$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'user'));
						@unlink($file['dir']);
						if($file==""){
							$this->mymodel->insertData('file', $data);
						}else{
							$this->mymodel->updateData('file', $data , array('id'=>$file['id']));
						}
						

						$dt['updated_at'] = date("Y-m-d H:i:s");
		        		$role = $this->mymodel->selectWhere('role',['id'=>$dt['role_id']]);
		        		$dt['role_slug'] = $role['slug'];
		        		$dt['role_name'] = $role['role'];
						$this->mymodel->updateData('user', $dt , array('id'=>$id));

						$this->alert->alertsuccess('Success Update Data');  
					}
				}else{
					$dt = $_POST['dt'];
		        	if($password!=""){
			        	$dt['password'] = md5($password);
		        	}
	        		$role = $this->mymodel->selectWhere('role',['id'=>$dt['role_id']]);
	        		$dt['role_slug'] = $role['slug'];
	        		$dt['role_name'] = $role['role'];
					$dt['updated_at'] = date("Y-m-d H:i:s");
					// print_r($dt);
					$this->mymodel->updateData('user', $dt , array('id'=>$id));
					$this->alert->alertsuccess('Success Update Data');  
				}



        }
	}

	public function delete($id)
	{
		// $this->mymodel->updateData('user',array('status'=>1),array('id'=>$id));

		$file = $this->mymodel->selectDataone('file',array('table_id'=>$id,'table'=>'user'));
		@unlink($file['dir']);
		
		$this->mymodel->deleteData('user',array('id'=>$id));
		$this->mymodel->deleteData('file',array('table_id'=>$id,'table'=>'user'));

		$this->session->set_flashdata('message', 'Success Delete Data');
		$this->session->set_flashdata('class', 'success');

		redirect('master/user');
	}

	public function password_check($str)
	{
		$this->form_validation->set_message('password_check',"password must combine alphabet and numeric");
	   $message = FALSE;
	   if (preg_match('#[0-9]#', $str) && preg_match('#[a-zA-Z]#', $str)) {
	    $message = TRUE;
	   }
	  return $message;
	}
	
	
	public function editUser_redirect($id){
	    $id = $this->template->sonEncode($id);
	    redirect('master/user/editUser/'.$id);
	}
}
