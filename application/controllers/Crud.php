<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Crud extends MY_Controller {
		public function __construct()
	{
			parent::__construct();
	}
	public function index()
	{
			$data['page_name'] = "crud";
		$this->template->load('template/template','crud/index',$data);
	}
	public function viewcode()
	{
			# code...
		// highlight_file('./application/controllers/master/Site.php');
	}
	public function generate()
	{
			if($_SERVER['REQUEST_METHOD']!="POST") redirect('crud');
		// print_r($_SERVER);
		$data['page_name'] = "crud";
		$this->template->load('template/template','crud/generate',$data);
		
	}
	public function get_kolom($table)
	{
			# code...
		$structure_query = "SELECT COLUMN_NAME,COLUMN_KEY,DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='".$this->db->database."' AND TABLE_NAME='".$table."'";
        $structure = $this->mymodel->selectWithQuery($structure_query);
        foreach ($structure as $stt) {
	        	$data[] = array(
	        					'value'=>$stt['COLUMN_NAME']
        					);
        }
        echo json_encode($data);
	}
	public function save_generate()
	{
			# code...
		$data = json_decode($_POST['json']);
		$kolom = $_POST['kolom'];
		$option = $_POST['option'];
		$value = $_POST['value'];
		// generate controller
		$c['path'] = dirname(__FILE__) ."/master/".$data->controller;
		$c['controller'] = $data->controller; 
		$c['table'] = $data->table; 
		$c['show'] = $data->show;
		$c['collum'] = $data->collum;
		$c['type_collum'] = $data->type;
		$c['kolom'] = $_POST['kolom'];
		$c['option'] = $_POST['option'];
		$c['value2'] = $_POST['value']; 
		$c['form_type'] = $data->form_type;
		$c['form_table'] = $data->form_table;
		$c['post_input'] = $_POST;
		// $c['filter_select']
		if(isset($data->file)){
				$c['file'] = true;
		}else{
				$c['file'] = false;
		}
		//generate all view
		$a['controller'] = $data->controller; 
		$a['table'] = $data->table; 
		$a['show'] = $data->show; 
		$a['collum'] = $data->collum;
		$a['label'] = $data->label;
		$a['type_collum'] = $data->type;
		$a['post_input'] = $_POST;
		$a['form_type'] = $data->form_type; 
		$a['form_table'] = $data->form_table;
		@mkdir("./application/views/master/".$data->table);
		$a['path'] = dirname(__FILE__) ."/../views/master/".$data->table."/all-".$data->table.".php";
		
		
		
		//generate all add
		$ad['controller'] = $data->controller; 
		$ad['table'] = $data->table; 
		$ad['show'] = $data->show; 
		$ad['kolom'] = $data->collum; 
		$ad['label'] = $data->label; 
		$ad['type'] = $data->type; 
		$ad['select_kolom'] = $kolom;
		$ad['select_option'] = $option;
		$ad['select_value'] = $value;
		// $c['kolom'] = $_POST['kolom'];
		$ad['post_input'] = $_POST;
		if(isset($data->file)){
				$ad['file'] = true;
		}else{
				$ad['file'] = false;
		}
		$ad['path'] = dirname(__FILE__) ."/../views/master/".$data->table."/add-".$data->table.".php";
		
		
		//generate edit
		$edit['controller'] = $data->controller; 
		$edit['table'] = $data->table; 
		$edit['show'] = $data->show; 
		$edit['kolom'] = $data->collum; 
		$edit['label'] = $data->label; 
		$edit['type'] = $data->type; 
		$edit['select_kolom'] = $kolom;
		$edit['select_option'] = $option;
		$edit['select_value'] = $value;
		$edit['form_type'] = $data->form_type;
		$edit['post_input'] = $_POST;
		if(isset($data->file)){
				$edit['file'] = true;
		}else{
				$edit['file'] = false;
		}
		$edit['path'] = dirname(__FILE__) ."/../views/master/".$data->table."/edit-".$data->table.".php";
		
		$this->load->view('crud/Controller',$c);
		$this->load->view('crud/All',$a);
		$this->load->view('crud/Add',$ad);
		$this->load->view('crud/Edit',$edit);
		
		
		$c = ucfirst(str_replace(".php", "", $data->controller));

		// redirect('master/'.$c);
		
	}

	public function save_generate_file()
	{
		$post = $this->input->post();
		// print_r($post);
		$this->template->createFile($post['all'], $post['path_all']);
		$this->template->createFile($post['controller'], $post['path_controller']);
		$this->template->createFile(str_replace("textareas","textarea",$post['add']), $post['path_add']);
		$this->template->createFile(str_replace("textareas","textarea",$post['edit']),$post['path_edit']);
	}

	public function api()
	{
			$data['page_name'] = "crud";
		$data['table'] = $_GET['table'];
		$this->template->load('template/template','crud/generate-api',$data);
	}
	public function api_generate()
	{
			// generate controller
		$controller = strtolower($_POST['controller']);
		$c['path'] = dirname(__FILE__) ."/api/".ucfirst($controller).".php";
		$c['controller'] = $controller; 
		$c['table'] = $controller; 
		
		$this->load->view('crud/Api',$c);
		redirect('crud/services');
	}
	public function services()
	{
			# code...
		$data['page_name'] = "crud";
		$this->template->load('template/template','crud/config',$data);
	}
}
/* End of file Crud.php */
/* Location: ./application/controllers/Crud.php */