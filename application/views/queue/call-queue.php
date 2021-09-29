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
                <h4 class="page-title"><i class="fa fa-microphone"></i> Panggilan Antrian - <?= $locket['name'] ?></h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-lg-3">
            <div class="card dash-data-card text-center">
                <div class="card-body"> 
                    <div class="icon-info mb-3">
                        <i class="fas fa-users bg-soft-warning"></i>
                    </div>
                    <h3 class="text-dark" id="queueTotal">0</h3>
                    <h6 class="font-14 text-dark">Jumlah Antrian</h6>                                                                                                                            
                </div><!--end card-body--> 
            </div><!--end card-->   
        </div><!-- end col-->
        <div class="col-lg-3">
            <div class="card dash-data-card text-center">
                <div class="card-body"> 
                    <div class="icon-info mb-3">
                        <i class="fas fa-user bg-soft-pink"></i>
                    </div>
                    <h3 class="text-dark" id="queueNow">0</h3>
                    <h6 class="font-14 text-dark">Antrian Sekarang</h6>                                                                                                                            
                </div><!--end card-body--> 
            </div><!--end card-->   
        </div><!-- end col-->  
        <div class="col-lg-3">
            <div class="card dash-data-card text-center">
                <div class="card-body"> 
                    <div class="icon-info mb-3">
                        <i class="fas fa-user-plus bg-soft-success"></i>
                    </div>
                    <h3 class="text-dark" id="queueNext">0</h3>
                    <h6 class="font-14 text-dark">Antrian Selanjutnya</h6>                                                                                                                            
                </div><!--end card-body--> 
            </div><!--end card-->   
        </div><!-- end col-->
        <div class="col-lg-3">
            <div class="card dash-data-card text-center">
                <div class="card-body"> 
                    <div class="icon-info mb-3">
                        <i class="fas fa-user bg-soft-primary"></i>
                    </div>
                    <h3 class="text-dark" id="queueRest">0</h3>
                    <h6 class="font-14 text-dark">Sisa Antrian</h6>                                                                                                                            
                </div><!--end card-body--> 
            </div><!--end card-->   
        </div><!-- end col-->                       
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">

                      <table class="table table-bordered dt-responsive nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%;"  id="tabel-antrian">
                           <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nomor Antrian</th>
                                    <th>Layanan</th>
                                    <th>Panggil</th>
                                </tr>
                           </thead>
                       </table>
                </div>
            </div>
           
        </div><!--end col-->
    </div><!--end row-->

</div><!-- container -->
<audio id="tingtung" src="<?=  base_url('assets/queue') ?>/audio/tingtung.mp3"></audio>
<script src="https://code.responsivevoice.org/responsivevoice.js?key=jQZ2zcdq"></script>
<script type="text/javascript">
    $(document).ready(function() {
  
      // menampilkan data antrian menggunakan DataTables
      var table = $('#tabel-antrian').DataTable({
        "lengthChange": false,              // non-aktifkan fitur "lengthChange"
        "searching": false,                 // non-aktifkan fitur "Search"
        "ajax": "<?= base_url('queue/json_queue/'.$locket['id']) ?>",          // url file proses tampil data dari database
        "order": [
          [0, "desc"]             // urutkan data berdasarkan "no_antrian" secara descending
        ],
        "iDisplayLength": 10,
        "columns": [
            {
                "data": "id",
                "visible": false

            },{
                "data": "number",
                "width": '250px',
                "className": 'text-center'
            },
            {
                "data": "service",
                "visible": true,
                "orderable": false,
                "searchable": false,
            },
            {
                "data": "status",
                "orderable": false,
                "searchable": false,
                "className": 'text-center',
                "render": function(data, type, row) {
                    let btn;
                    if (row["status"] === "pending") {
                         btn = `<button class="btn btn-success btn-sm rounded-circle" onclick="bell(${row['id']},'call')"><i class="fa fa-microphone"></i></button>`;
                    }else if (row["status"] === "call") {
                         btn = `<button class="btn btn-info btn-sm rounded-circle" onclick="bell(${row['id']},'call')"><i class="fa fa-microphone"></i></button>
                                    <button class="btn btn-danger btn-sm rounded-circle" onclick="bell(${row['id']},'reject')"><i class="fa fa-times"></i></button>`;
                    }else if (row["status"] === "finish") {
                         btn = `<button class="btn btn-info btn-sm rounded-circle" onclick="bell(${row['id']},'finsih')"><i class="fa fa-microphone"></i></button>`;
                    } else {
                         btn = "-";
                    }
                    return btn;
                }

            },
        ],
      });
    


      setInterval(function() {
            table.ajax.reload(null, false);

        }, 5000);
    });
    function bell(id,status){
        // alert(id)
        var bell = document.getElementById('tingtung');

        if(status!='reject'){
            // mainkan suara bell antrian
            bell.pause();
            bell.currentTime = 0;
            bell.play();
        }

        // set delay antara suara bell dengan suara nomor antrian
        durasi_bell = bell.duration * 770;

        
        // mainkan suara nomor antrian
        setTimeout(function() {
            if(status!='reject'){
                $.get("<?= base_url('queue/json_queue_detail/') ?>"+id, function(data, status){
                    let resultResponse = data.data;
                    responsiveVoice.speak(`Nomor Antrian, ${resultResponse.number}, menuju, ${resultResponse.locket}`, "Indonesian Male", {
                        rate: 0.9,
                        pitch: 1,
                        volume: 1
                    });
                }); 
            }
            callNumber()
        }, durasi_bell);

        $.ajax({
            type: "POST",               // mengirim data dengan method POST
            url: "<?= base_url('queue/update_queue') ?>",          // url file proses update data
            data: { id : id, status : status  }            // tentukan data yang dikirim
          
        });
    }

    function callNumber(){
        $.get("<?= base_url('queue/json_numberqueue/'.$locket['id']) ?>", function(data, status){
            console.log(status)
            setTimeout(() => {
                $("#queueTotal").html(data.queueTotal);
                $("#queueNow").html(data.queueNow);
                $("#queueNext").html(data.queueNext);
                $("#queueRest").html(data.queueRest); 
            }, 1000);
           
        });
    }
    callNumber()
  </script>