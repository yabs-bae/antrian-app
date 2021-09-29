
<script src="<?= base_url('assets/') ?>bower_components/jquery/dist/jquery.min.js"></script>

<link rel=stylesheet href="<?= base_url('assets/bower_components/codemirror-5.57.0')?>/doc/docs.css">
<link rel="stylesheet" href="<?= base_url('assets/bower_components/codemirror-5.57.0')?>/lib/codemirror.css">
<script src="<?= base_url('assets/bower_components/codemirror-5.57.0')?>/lib/codemirror.js"></script>
<script src="<?= base_url('assets/bower_components/codemirror-5.57.0')?>/addon/edit/matchbrackets.js"></script>
<script src="<?= base_url('assets/bower_components/codemirror-5.57.0')?>/mode/htmlmixed/htmlmixed.js"></script>
<script src="<?= base_url('assets/bower_components/codemirror-5.57.0')?>/mode/xml/xml.js"></script>
<script src="<?= base_url('assets/bower_components/codemirror-5.57.0')?>/mode/javascript/javascript.js"></script>
<script src="<?= base_url('assets/bower_components/codemirror-5.57.0')?>/mode/css/css.js"></script>
<script src="<?= base_url('assets/bower_components/codemirror-5.57.0')?>/mode/clike/clike.js"></script>
<script src="<?= base_url('assets/bower_components/codemirror-5.57.0')?>/mode/php/php.js"></script>
<link href="<?= base_url('assets/bower_components/codemirror-5.57.0')?>/theme/dracula.css" rel="stylesheet"></link>

<?php
$query = "SELECT COLUMN_NAME,COLUMN_KEY FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='".$this->db->database."' AND TABLE_NAME='".$table."' AND COLUMN_KEY = 'PRI'";
$pri = $this->mymodel->selectWithQuery($query);
$primary = $pri[0]['COLUMN_NAME'];
$c = ucfirst(str_replace(".php", "", $controller));
$string = "
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class ".$c." extends MY_Controller {
		public function __construct()
		{
			parent::__construct();
		}

		public function index()
		{
			\$data['page_name'] = \"".$table."\";
			\$this->template->load('template/template','master/".$table."/all-".$table."',\$data);
		}
		";
if($form_type=="page"){
$string .=	"

		public function create()
		{
			\$data['page_name'] = \"".$table."\";
			\$this->template->load('template/template','master/".$table."/add-".$table."',\$data);
		}";
}else{
$string .=	"
		public function create()
		{
			\$this->load->view('master/".$table."/add-".$table."');
		}";
}
$string .=	"
		public function validate()
		{
			\$this->form_validation->set_error_delimiters('<li>', '</li>');
		";
foreach ($show as $key => $value) {
$string .=	"	\$this->form_validation->set_rules('dt[".$value."]', '<strong>".$this->template->label($value)."</strong>', 'required');\n\t\t";
}
$string .="	
		}

		public function store()
		{
			\$this->validate();
			if (\$this->form_validation->run() == FALSE){
				echo validation_errors();    
	        }else{
				\$dt = \$this->input->post('dt');
				\$dt['created_by'] = \$this->session->userdata('id');
				\$dt['status'] = \"ENABLE\";
				\$str = \$this->mymodel->insertData('".$table."', \$dt);
				";
	if($file==true){	
	$string .="	    
				\$last_id = \$this->db->insert_id();
				if (!empty(\$_FILES['file']['name'])){
					\$directory = 'webfile/';
					\$filename = \$_FILES['file']['name'];
					\$allowed_types = 'gif|jpg|png';
					\$max_size = '2000';
					\$result = \$this->uploadfile->upload('file',\$filename,\$directory,\$allowed_types, \$max_size);
					if(\$result['alert'] == 'success'){
						\$data = array(
							'id' => '',
							'name'=> \$result['message']['name'],
							'mime'=> \$result['message']['mime'],
							'dir'=> \$result['message']['dir'],
							'table'=> '".$table."',
							'table_id'=> \$last_id,
							'status'=>'ENABLE',
							'created_at'=>date('Y-m-d H:i:s')
						);
						\$str = \$this->mymodel->insertData('file', \$data);
						echo 'success';
					}else{
						echo \$result['message'];
					}
				}else{
					\$data = array(
						'name'=> '',
						'mime'=> '',
						'dir'=> '',
						'table'=> '".$table."',
						'table_id'=> \$last_id,
						'status'=>'ENABLE',
						'created_at'=>date('Y-m-d H:i:s')
					);
					\$str = \$this->mymodel->insertData('file', \$data);
					echo 'success';
				}
					 ";
}else{
$string	.= "
			echo 'success';

		";
}
$string .=	"   

			}
		}

		public function json()
		{
			\$status = \$_GET['status'];
			if(\$status=='') \$status = 'ENABLE';
			";
	if(!empty($post_input['filter_select'])){
		// echo "asdasd";
		foreach($post_input['filter_select'] as $fs){
$string.= 			"
			\$".$fs." = \$this->input->post('filter_".$fs."');";
		}
	}
$string.= "
			header('Content-Type: application/json');
	        ";
			$select = "";
			
	        foreach ($show as $key => $value) {
		        	$select.= $table.'.'.$value.",";
	        }

 $string .= "\$this->".$form_table."->select('".$table.".".$primary.",".$select."status');";

		if(!empty($post_input['filter_select'])){
		// echo "asdasd";
		foreach($post_input['filter_select'] as $fs){
		$string.= "
			if(\$".$fs."){
				\$this->".$form_table."->where('".$table.".".$fs."',\$".$fs.");
			}
		";
		}
	}
 $string .= "
	        \$this->".$form_table."->where('".$table.".status',\$status);
	        \$this->".$form_table."->from('".$table."');
	        if(\$status==\"ENABLE\"){
				\$this->".$form_table."->add_column('view', '<div class=\"btn-group\">
																	<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"edit(\$1,$(this))\"><i class=\"fa fa-pencil\"></i> Edit</button>
																	<button type=\"button\" onclick=\"hapus(\$1,$(this))\" class=\"btn btn-sm btn-danger\"><i class=\"fa fa-trash-o\"></i> Hapus</button>
															</div>', '".$primary."');
	    	}else{
				\$this->".$form_table."->add_column('view', '<div class=\"btn-group\">
																	<button type=\"button\" class=\"btn btn-sm btn-primary\" onclick=\"edit(\$1,$(this))\"><i class=\"fa fa-pencil\"></i> Edit</button>
																	<button type=\"button\" onclick=\"hapus(\$1,$(this))\" class=\"btn btn-sm btn-danger\"><i class=\"fa fa-trash-o\"></i> Hapus</button>
															</div>', '".$primary."');
	    	}
	        echo \$this->".$form_table."->generate();
		}";
if($form_type=="page"){
$string .=	"

		public function edit(\$id)
		{
			\$data['".$table."'] = \$this->mymodel->selectDataone('".$table."',array('".$primary."'=>\$id));";
if($file==true){	
$string.=	"	
			\$data['file'] = \$this->mymodel->selectDataone('file',array('table_id'=>\$id,'table'=>'".$table."'));";
}
$string.="		
			\$data['page_name'] = \"".$table."\";
			\$this->template->load('template/template','master/".$table."/edit-".$table."',\$data);
		}";
}else{
$string .=	"
		
		public function edit(\$id)
		{
			\$data['".$table."'] = \$this->mymodel->selectDataone('".$table."',array('".$primary."'=>\$id));";
if($file==true){	
$string.=		"\$data['file'] = \$this->mymodel->selectDataone('file',array('table_id'=>\$id,'table'=>'".$table."'));";
}
$string.="		
			\$data['page_name'] = \"".$table."\";
			\$this->load->view('master/".$table."/edit-".$table."',\$data);
		}";
}
$string .=	"

		public function update()
		{
			\$this->form_validation->set_error_delimiters('<li>', '</li>');
			\$this->validate();

			if (\$this->form_validation->run() == FALSE){
				echo validation_errors();   
	        }else{
				\$id = \$this->input->post('".$primary."', TRUE);";
	if($file==true){	
$string.=		"
				if (!empty(\$_FILES['file']['name'])){
					\$directory = 'webfile/';
					\$filename = \$_FILES['file']['name'];
					\$allowed_types = 'gif|jpg|png';
					\$max_size = '2000';
					\$result = \$this->uploadfile->upload('file',\$filename,\$directory,\$allowed_types, \$max_size);
					if(\$result['alert'] == 'success'){
						\$data = array(
							'name'=> \$result['message']['name'],
							'mime'=> \$result['message']['mime'],
							'dir'=> \$result['message']['dir'],
							'table'=> '".$table."',
							'table_id'=> \$id,
						);
						\$file = \$this->mymodel->selectDataone('file',array('table_id'=>\$id,'table'=>'".$table."'));
						@unlink(\$file['dir']);
						if(\$file==\"\"){
							\$this->mymodel->insertData('file', \$data);
						}else{
							\$this->mymodel->updateData('file', \$data , array('id'=>\$file['id']));
						}

						\$dt = \$this->input->post('dt');
						\$dt['updated_by'] = \$this->session->userdata('id');
						\$str =  \$this->mymodel->updateData('".$table."', \$dt , array('".$primary."'=>\$id));
						if(\$str==true){
							echo 'success';
						}else{
							echo 'Something error in system';
						}
					}else{
						echo \$result['message'];
					}

				}else{
					\$dt = \$this->input->post('dt');
					\$dt['updated_at'] = date(\"Y-m-d H:i:s\");
					\$str = \$this->mymodel->updateData('".$table."', \$dt , array('".$primary."'=>\$id));
					if(\$str==true){
						echo 'success';
					}else{
						echo 'Something error in system';
					}
				}";
}else{
		$string.= "		
				\$dt = \$this->input->post('dt');
				\$dt['updated_at'] = date(\"Y-m-d H:i:s\");
				\$str = \$this->mymodel->updateData('".$table."', \$dt , array('".$primary."'=>\$id));
				if(\$str==true){
					echo \"success\";
				}else{
					echo \"Something error in system\";
				}  ";
}
$string.=	"
			}
		}

		public function delete()
		{
			\$id = \$this->input->post('".$primary."', TRUE);";
	if($file==true){	
	$string.=	"
			\$file = \$this->mymodel->selectDataone('file',array('table_id'=>\$id,'table'=>'".$table."'));
			@unlink(\$file['dir']);
			\$this->mymodel->deleteData('file',  array('table_id'=>\$id,'table'=>'".$table."'));
			\$str = \$this->mymodel->deleteData('".$table."',  array('".$primary."'=>\$id));
			if(\$str==true){
				echo \"success\";
			}else{
				echo \"Something error in system\";
			}  
					";
}else{
	$string.=	"
			\$str = \$this->mymodel->deleteData('".$table."', array('".$primary."'=>\$id));
			if(\$str==true){
				echo \"success\";
			}else{
				echo \"Something error in system\";
			}  
		";
} 
$string.=	"
		}

		public function deleteData()
		{
			\$data = \$this->input->post('data');
			if(\$data!=\"\"){
				\$id = explode(',',\$data);
				\$this->db->where_in('".$primary."',\$id);
				\$this->db->delete('".$table."',[]);
				if(\$str==true){
					echo \"success\";
				}else{
					echo \"Something error in system\";
				} 
			}else{
				echo \"success\";
			}
		}

		public function status(\$id,\$status)
		{
			\$this->mymodel->updateData('".$table."',array('status'=>\$status),array('".$primary."'=>\$id));
			redirect('master/".$c."');
		}";
		$b = 0;
		$g = 1;
		foreach ($collum as $key => $value) {
			if(in_array($value, $show)){
		if($type_collum[$key] == 'SELECT OPTION' && $post_input['kolomstatus'.$b] == 'ajax'){
			$string .= "
		
		public function loadAjaxField_".$value."(\$id)
		{
			echo \"<label class='badge bg-red'>Silahkan isi ajax disini</label>\";
		}
			";
		}

			if($type_collum[$key] == 'SELECT OPTION'){
					$b++;
			}
			$g++;
		  }
		}

$string .= "
	}
?>";
		$this->template->createFile($string, $path);
	
?>
<form action="<?= base_url('crud/save_generate_file') ?>" method="POST" id="upload-create">
<label>Location : <?= $path ?></label>
<textarea id="editor" name="controller"><?= $string ?></textarea>
<input type="hidden" name="path_controller" value="<?= $path ?>" id="">
<script>
var editor = CodeMirror.fromTextArea(document.getElementById('editor'), {
		mode: "application/x-httpd-php",
        theme: "dracula",
        lineNumbers: true,
        autoCloseTags: true
      });
	  editor.setSize(null, 500);
</script>