
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Locket extends MY_Controller {
		public function __construct()
		{
			parent::__construct();
			$role = $this->mymodel->selectDataone('role',['id'=>$this->session->userdata('role_id')]);
			if($role['role']!="Admin") redirect('/','refresh');
		}

		public function index()
		{
			$data['page_name'] = "locket";
			$this->template->load('template/template','master/locket/all-locket',$data);
		}
		

		public function create()
		{
			$data['page_name'] = "locket";
			$this->template->load('template/template','master/locket/add-locket',$data);
		}
		public function validate()
		{
			$this->form_validation->set_error_delimiters('<li>', '</li>');
			$this->form_validation->set_rules('dt[code]', '<strong>Code</strong>', 'required');
			$this->form_validation->set_rules('dt[name]', '<strong>Name</strong>', 'required');
			$this->form_validation->set_rules('dt[description]', '<strong>Description</strong>', 'required');
			$this->form_validation->set_rules('dt[json_service]', '<strong>Service</strong>', 'required');
			
		}

		public function store()
		{
			$this->validate();
			if ($this->form_validation->run() == FALSE){
				echo validation_errors();    
	        }else{
				$dt = $this->input->post('dt');
				
				$services = ($dt['json_service']);
				$jsonService = [];
				foreach($services as $service){
					$serviceData = $this->mymodel->selectDataone('service',['id'=>$service]);
					$jsonService[] = [
						'id'=>$serviceData['id'],
						'name'=>$serviceData['name'],
					];
				}
				$dt['json_service'] = json_encode($jsonService);
				$dt['created_by'] = $this->session->userdata('id');
				$dt['status'] = "ENABLE";
				$str = $this->mymodel->insertData('locket', $dt);
				
				echo 'success';

		   

			}
		}

		public function json()
		{
			$status = $_GET['status'];
			if($status=='') $status = 'ENABLE';
			
			header('Content-Type: application/json');
	        $this->datatables->select('locket.id,locket.code,locket.name,locket.description,locket.json_service,status');
	        $this->datatables->where('locket.status',$status);
	        $this->datatables->from('locket');
	        if($status=="ENABLE"){
				$this->datatables->add_column('view', '
																	<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-edit"></i> Edit</button>
																	<button type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button>
															', 'id');
	    	}else{
				$this->datatables->add_column('view', '
																	<button type="button" class="btn btn-sm btn-primary" onclick="edit($1,$(this))"><i class="fa fa-edit"></i> Edit</button>
																	<button type="button" onclick="hapus($1,$(this))" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i> Hapus</button>
															', 'id');
	    	}
	        echo $this->datatables->generate();
		}

		public function edit($id)
		{
			$data['locket'] = $this->mymodel->selectDataone('locket',array('id'=>$id));		
			$data['page_name'] = "locket";
			$this->template->load('template/template','master/locket/edit-locket',$data);
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
				$services = $dt['json_service'];
				$jsonService = [];
				foreach($services as $service){

					$serviceData = $this->mymodel->selectDataone('service',['id'=>$service]);

					$jsonService[] = [
						'id'=>$serviceData['id'],
						'name'=>$serviceData['name'],
					];

				}
				$dt['json_service'] = json_encode($jsonService);
				$dt['updated_at'] = date("Y-m-d H:i:s");
				$str = $this->mymodel->updateData('locket', $dt , array('id'=>$id));

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
			$str = $this->mymodel->deleteData('locket', array('id'=>$id));
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
				$this->db->delete('locket',[]);
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
			$this->mymodel->updateData('locket',array('status'=>$status),array('id'=>$id));
			redirect('master/Locket');
		}
	}
?>