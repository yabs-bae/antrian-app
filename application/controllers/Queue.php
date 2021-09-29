<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Queue extends MY_Controller {
	public function __construct()
	{
		parent::__construct();
		
	}
	public function index()
	{
		$data['page_name'] = "home";
		$this->template->load('template/queue','queue/home',$data);
		
	}

	public function report()
	{
		$data['page_name'] = "home";
		$this->template->load('template/template','queue/report-queue',$data);
		
	}

	public function export()
	{
		$this->load->view('queue/export-excel');
	}

    public function get_number($locketId,$serviceId)
	{
		$data['page_name'] = "home";
        $locket = $this->mymodel->selectDataone('locket',['id'=>$locketId]);
        $service = $this->mymodel->selectDataone('service',['id'=>$serviceId]);
        $data = ['service'=>$service,'locket'=>$locket];
		$this->template->load('template/queue','queue/get-number',$data);
		
	}

    public function get_queue($locketId,$serviceId)
	{
		$this->db->select('(COUNT(*)+1) as jumlah');
		$antrian = $this->mymodel->selectDataone('queue',['DATE(date)'=>date('Y-m-d'),'locket_id'=>$locketId,'service_id'=>$serviceId]);
        $locket = $this->mymodel->selectDataone('locket',['id'=>$locketId]);
        $service = $this->mymodel->selectDataone('service',['id'=>$serviceId]);
		echo $kode = $locket['code'].sprintf("%'03d", ($antrian['jumlah']));

    }

	
	public function send_queue($locketId,$serviceId)
	{
		$number  = $this->input->get('number');
		$data = [
			'number'=>$number,
			'date'=>date('Y-m-d H:i:s'),
			'locket_id'=>$locketId,
			'service_id'=>$serviceId,
		];

		$this->mymodel->insertData('queue',$data);
		echo 'Sukses';
	}

	public function call($locketId)
	{
        $locket = $this->mymodel->selectDataone('locket',['id'=>$locketId]);
		$data['locket'] = $locket;
		$data['page_name'] = "locket";
		$this->template->load('template/template','queue/call-queue',$data);
	}

	public function locket()
	{
		$data['page_name'] = "locket";
		$this->template->load('template/template','queue/get-locket',$data);
	}

	public function json_queue($locketId)
	{
		header('Content-Type: application/json');
		$this->db->select('queue.id,number,service.name as service,queue.status');
		$this->db->join('service','service.id = queue.service_id');
		$queue = $this->mymodel->selectWhere("queue",['DATE(date)'=>date('Y-m-d'),'locket_id'=>$locketId]);
		echo json_encode(['data'=>$queue]);
		# code...
	}

	public function json_numberqueue($locketId)
	{
		header('Content-Type: application/json');
		$this->db->select('count(*) as jml');
		$queueTotal = $this->mymodel->selectDataone("queue",['DATE(date)'=>date('Y-m-d'),'locket_id'=>$locketId])['jml'];
		if($queueTotal==null) $queueTotal = 0;
		$this->db->select('number as jml');
		$queueNow = $this->mymodel->selectDataone("queue",['DATE(date)'=>date('Y-m-d'),'locket_id'=>$locketId,'status'=>'call'])['jml'];
		if($queueNow==null) $queueNow = '-';

		$this->db->select('number as jml');
		$queueNext = $this->mymodel->selectDataone("queue",['DATE(date)'=>date('Y-m-d'),'locket_id'=>$locketId,'status'=>'pending'])['jml'];
		if($queueNext==null) $queueNext = '-';

		$this->db->select('count(*) as jml');
		$queueRest  = $this->mymodel->selectDataone("queue",['DATE(date)'=>date('Y-m-d'),'locket_id'=>$locketId,'status'=>'pending'])['jml'];
		if($queueRest==null) $queueNow = 0;
		
		$data = [
			'queueTotal'=>$queueTotal,
			'queueNow'=>$queueNow,
			'queueNext'=>$queueNext,
			'queueRest'=>$queueRest
		];

		echo json_encode($data);
		# code...
	}

	public function json_queue_detail($id)
	{
		header('Content-Type: application/json');
		$this->db->select('queue.*,locket.name as locket');
		$this->db->join('locket','locket.id = queue.locket_id');
		$queue = $this->mymodel->selectDataone('queue',['queue.id'=>$id]);
		echo json_encode(['data'=>$queue]);
		# code...
	}

	public function update_queue()
	{
		$id = $this->input->post('id');
		$status = $this->input->post('status');
		$queue = $this->mymodel->selectDataone('queue',['id'=>$id]);

		if($status=='call'){

			$this->mymodel->updateData('queue',['status'=>'finish','date_finish'=>date('Y-m-d H:i:s')],['locket_id'=>$queue['locket_id'],'status'=>'call']);
			$this->mymodel->updateData('queue',['status'=>$status,'date_call'=>date('Y-m-d H:i:s'),'user_id'=>$this->session->userdata('id')],['id'=>$id]);
			$this->mymodel->insertData('log',['activity'=>'memanggil nomor antrian '.$queue['number'],'user_id'=>$this->session->userdata('id')]);
		
		}else if($status=='reject'){
			$this->mymodel->updateData('queue',['status'=>$status,'date_finish'=>date('Y-m-d H:i:s'),'user_id'=>$this->session->userdata('id')],['id'=>$id]);
			$this->mymodel->insertData('log',['activity'=>'membatalkan nomor antrian '.$queue['number'],'user_id'=>$this->session->userdata('id')]);
		
		}
		
	}

   

}
/* End of file Home.php */
/* Location: ./application/controllers/Home.php */