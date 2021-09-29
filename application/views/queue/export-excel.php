<?php
$daterange = $this->input->get('daterange');
$service_id = $this->input->get('service_id');
$locket_id = $this->input->get('locket_id');

header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Laporan Antrian.xls");
?>
<table class="table table-bordered dt-responsive nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="mytable" border="1">
    <thead>
    <tr>
        <th>Tanggal</th>
        <th>Nomor Antrian</th>
        <th>Layanan</th>
        <th>Loket</th>
        <th>Nama CS</th>
        <th>Datang</th>
        <th>Panggil</th>
        <th>Selesai</th>
        <th>Status</th>
    </tr>
    </thead>
    <tbody>
        <?php
        $this->db->select('queue.*,service.name as service,locket.name as locket,user.name as user');
        $this->db->join('service','queue.service_id=service.id','left');
        $this->db->join('locket','queue.locket_id=locket.id','left');
        $this->db->join('user','queue.user_id=user.id','left');
        if($locket_id){
            $this->db->where('queue.locket_id',$locket_id);
        }
        
        if($service_id){
            $this->db->where('queue.service_id',$service_id);
        }

        if($daterange){
            $date = explode(' - ',$daterange);
            $start = date('Y-m-d',strtotime($date[0]));
            $end = date('Y-m-d',strtotime($date[1]));  
            $this->db->where('DATE(date) >=', $start);
            $this->db->where('DATE(date) <=', $end);  
        }
        $queues = $this->mymodel->selectData('queue');
        foreach($queues as $queue){
        ?>
        <tr>
            <td> <?= date('Y-m-d',strtotime($queue['date'])) ?> </td>
            <td><?= $queue['number'] ?></td>
            <td><?= $queue['service'] ?></td>
            <td><?= $queue['locket'] ?></td>
            <td><?= $queue['user'] ?></td>
            <td><?= date('H:i:s',strtotime($queue['date'])) ?></td>
            <td><?= date('H:i:s',strtotime($queue['date_call'])) ?></td>
            <td><?= date('H:i:s',strtotime($queue['date_finish'])) ?></td>
            <td><?= $queue['status'] ?> </td>
        </tr>
        <?php } ?>
    </tbody>
</table>
