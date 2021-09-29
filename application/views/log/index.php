<div class="container-fluid">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Master</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Log</a></li>
                        <li class="breadcrumb-item active">Data</li>
                    </ol>
                </div>
                <h4 class="page-title">Log</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">                                       
                <div class="card-body"> 
                    <div class="row">
                        <div class="col-4">
                            <small for="">User</small>
                            <select onchange="loadtable(this.value)" id="select-status" style="" class="form-control select2 input-sm">
                                <?php
                                    $users = $this->mymodel->selectWhere('user',[]);
                                    foreach($users as $user){
                                ?>
                                    <option value="<?= $user['id'] ?>"><?= $user['name'] ?></option>
                                <?php } ?>
                            </select>

                        </div>
                        <div class="col-8 text-right">

                        </div>
                    </div>
                    <br>
                    <div id="load-table"></div>

                   
                </div>  <!--end card-body-->                                     
            </div><!--end card-->
        </div><!--end col-->
      
        
    </div><!--end row-->

</div><!-- container -->


  <script type="text/javascript">
    

    var idrow = "";
    var idbutton = "";

    function loadtable(user = '') {
        var table = '<table class="table table-bordered dt-responsive nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%;" id="mytable">'+
                      '     <thead>'+
                      '     <tr>'+
                      '       <th style="width:20px">No</th>'+
                      '       <th>Tanggal</th>'+
                      '       <th>User</th>'+
                      '       <th>Aktivitas</th>'
                      '     </tr>'+

                      '     </thead>'+
                      '     <tbody>'+
                      '     </tbody>'+
                      ' </table>';
             // body...
             $("#load-table").html(table)
              var t = $("#mytable").DataTable({
                  initComplete: function() {
                      var api = this.api();
                    $('#mytable_filter input')
                            .off('.DT')
                            .on('keyup.DT', function(e) {
                                  if (e.keyCode == 13) {
                                      api.search(this.value).draw();
                        }
                    });
                },
                oLanguage: {
                      sProcessing: "loading..."
                },
                processing: true,
                serverSide: true,
                ajax: {"url": "<?= base_url('log/json?user_id=') ?>"+user, "type": "POST"},
                columns: [
                    {"data": "id","orderable": false},
                    {"data": "date"},
                    {"data": "name"},
                    {"data": "activity"}
                ],
                order: [[1, 'desc']],
                columnDefs : [
                ],

                rowCallback: function(row, data, iDisplayIndex) {
                      var info = this.fnPagingInfo();
                    var page = info.iPage;
                    var length = info.iLength;
                    var index = page * length + (iDisplayIndex + 1);
                    $('td:eq(0)', row).html(index);
                    
                }
            });
         }
         loadtable();
  </script>