<div class="container-fluid">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Laporan</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Loket</a></li>
                        <li class="breadcrumb-item active">Antrian</li>
                    </ol>
                </div>
                <h4 class="page-title">Laporan </h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">                                       
                <div class="card-body"> 
                    <form action="">
                    <div class="row">
                       
                        <div class="col-4">
                                <label class="col-form-label text-right">Dari - Sampai</label>
                                <div class="input-group">                                            
                                    <input type="text" class="form-control" name="daterange" value="<?= $this->input->get('daterange') ?>">
                                    <div class="input-group-append">
                                        <span class="input-group-text"><i class="dripicons-calendar"></i></span>
                                    </div>
                                </div>
                        </div>
                        <div class="col-3">
                            <div class="form-group">
                                <label for="example-date-input" class="col-form-label text-right">Loket</label>
                                <select class="select2 form-control mb-3 custom-select" name="locket_id" style="width: 100%; height:36px;">
                                <?php
                                    $lockets = $this->mymodel->selectWhere('locket',['status'=>'ENABLE']);
                                    foreach($lockets as $locket){
                                ?>
                                    <option value="<?= $locket['id'] ?>" <?= ($locket['id']==$this->input->get('locket_id'))? 'selected' : '' ?>><?= $locket['name'] ?></option>
                                <?php
                                    }
                                ?>
                                </select>
                            </div>
                        </div>

                        <div class="col-3">
                            <div class="form-group">
                                <label for="example-date-input"  class="col-form-label text-right">Layanan</label>
                                <select class="select2 form-control mb-3 custom-select" name="service_id" style="width: 100%; height:36px;">
                                <?php
                                    $services = $this->mymodel->selectWhere('service',['status'=>'ENABLE']);
                                    foreach($services as $service){
                                ?>
                                    <option value="<?= $service['id'] ?>" <?= ($service['id']==$this->input->get('service_id'))? 'selected' : '' ?>><?= $service['name'] ?></option>
                                <?php
                                    }
                                ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <br>
                            <br>
                            <button class="btn btn-primary"><i class="fa fa-search"></i> Filter</button>
                            <button class="btn btn-success" type="button" onclick="location.href='<?= base_url('queue/export?daterange='.$this->input->get('daterange').'&locket_id='.$this->input->get('locket_id').'&service_id='. $this->input->get('service_id')) ?>'"><i class="fa fa-file-excel"></i> Export</button>
                        </div>
                    </div>
                    </form>
                    <br>
                    
                    <div class="row">
                        <div class="col-12">
                        <?php
                       $daterange = $this->input->get('daterange');
                       

                       $service_id = $this->input->get('service_id');
                       $locket_id = $this->input->get('locket_id');

                        
                        ?>
                        <table class="table table-bordered dt-responsive nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="mytable">
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
                                 <?php if($daterange){ ?>
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
                                     <td>
                                        <?php if($queue['status']=="pending"){ ?>
                                            <button class="btn btn-gradient-warning btn-sm waves-effect waves-light">pending</button>
                                        <?php }else if($queue['status']=="call"){ ?>
                                            <button class="btn btn-gradient-primary btn-sm waves-effect waves-light">call</button>
                                        <?php }else if($queue['status']=="finish"){ ?>
                                            <button class="btn btn-gradient-success btn-sm waves-effect waves-light">finish</button>
                                        <?php }else if($queue['status']=="reject"){ ?>
                                            <button class="btn btn-gradient-danger btn-sm waves-effect waves-light">reject</button>

                                        <?php } ?>

                                     </td>
                                 </tr>
                                 <?php } ?>
                                 <?php } ?>
                             </tbody>
                         </table>
                        </div>
                    </div>
                </div>  <!--end card-body-->                                     
            </div><!--end card-->
        </div><!--end col-->
      
        
    </div><!--end row-->

</div><!-- container -->
<script>
    $("#mytable").DataTable();
</script>