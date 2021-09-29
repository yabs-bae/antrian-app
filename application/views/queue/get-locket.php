<div class="container-fluid">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Master</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Antrian</a></li>
                        <li class="breadcrumb-item active">Data</li>
                    </ol>
                </div>
                <h4 class="page-title"><i class="fa fa-microphone"></i> Panggilan Antrian</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <?php
        $lockets = $this->mymodel->selectWhere('locket',['status'=>'ENABLE']);
    ?>
    <div class="row">
        <?php
        foreach($lockets as $locket){
        ?>
        <div class="col-lg-3">
            <div class="card dash-data-card text-center" onclick="location.href='<?= base_url('queue/call/'.$locket['id']) ?>'" style="cursor:pointer">
                <div class="card-body"> 
                    <div class="icon-info mb-3">
                        <i class="fas fa-ticket-alt  bg-soft-warning"></i>
                    </div>
                    <!-- <h3 class="text-dark">184</h3> -->
                    <h6 class="font-14 text-dark"><?= $locket['name'] ?></h6> 
                    <p class="text-muted font-12"><?= $locket['description'] ?></p>                                                                                                                           
                </div><!--end card-body--> 
            </div><!--end card-->   
        </div><!-- end col-->
        <?php
        }
        ?>
                          
    </div>
   

</div><!-- container -->
