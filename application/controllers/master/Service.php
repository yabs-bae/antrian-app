
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Service extends MY_Controller {
		public function __construct()
		{
			parent::__construct();
			$role = $this->mymodel->selectDataone('role',['id'=>$this->session->userdata('role_id')]);
			if($role['role']!="Admin") redirect('/','refresh');
		}

		public function index()
		{
			$data['page_name'] = "service";
			$this->template->load('template/template','master/service/all-service',$data);
		}
		
		public function create()
		{
			$this->load->view('master/service/add-service');
		}
		public function validate()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->form_validation->set_rules('dt[code]', '<strong>Code</strong>', 'required');
			$this->form_validation->set_rules('dt[name]', '<strong>Name</strong>', 'required');
			
		}

		public function store()
		{
			$this->validate();
			if ($this->form_validation->run() == FALSE){
				echo validation_errors();    
	        }else{
				$dt = $this->input->post('dt');
				$dt['created_by'] = $this->session->userdata('id');
				$dt['status'] = "ENABLE";
				$str = $this->mymodel->insertData('service', $dt);
				
			echo 'success';

		   

			}
		}

		public function json()
		{
			$status = $_GET['status'];
			if($status=='') $status = 'ENABLE';
			
			header('Content-Type: application/json');
	        $this->datatables->select('service.id,service.code,service.name,status');
	        $this->datatables->where('service.status',$status);
	        $this->datatables->from('service');
	        if($status=="ENABLE"){
				$this->datatables->add_column('view', '<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-edit"></i> Edit</button>
													  <button type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button>', 'id');
	    	}else{
				$this->datatables->add_column('view', '<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-edit"></i> Edit</button>
														<button type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button>', 'id');
	    	}
	        echo $this->datatables->generate();
		}
		
		public function edit($id)
		{
			$data['service'] = $this->mymodel->selectDataone('service',array('id'=>$id));		
			$data['page_name'] = "service";
			$this->load->view('master/service/edit-service',$data);
		}

		public function update()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->validate();

			if ($this->form_validation->run() == FALSE){
				echo validation_errors();   
	        }else{
				$id = $this->input->post('id', TRUE);		
				$dt = $this->input->post('dt');
				$dt['updated_at'] = date("Y-m-d H:i:s");
				$str = $this->mymodel->updateData('service', $dt , array('id'=>$id));
				if($str==true){
					echo "success";
				}else{
					echo "Something error in system";
				}  
			}
		}

		public function delete()
		{
			$id = $this->input->post('id', TRUE);
			$str = $this->mymodel->deleteData('service', array('id'=>$id));
			if($str==true){
				echo "success";
			}else{
				echo "Something error in system";
			}  
		
		}

		public function deleteData()
		{
			$data = $this->input->post('data');
			if($data!=""){
				$id = explode(',',$data);
				$this->db->where_in('id',$id);
				$this->db->delete('service',[]);
				if($str==true){
					echo "success";
				}else{
					echo "Something error in system";
				} 
			}else{
				echo "success";
			}
		}

		public function status($id,$status)
		{
			$this->mymodel->updateData('service',array('status'=>$status),array('id'=>$id));
			redirect('master/Service');
		}
	}
?>