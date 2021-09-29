<div class="container-fluid">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Master</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Layanan</a></li>
                        <li class="breadcrumb-item active">Data</li>
                    </ol>
                </div>
                <h4 class="page-title">Layanan</h4>
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
                            <small for="">Status</small>
                            <select onchange="loadtable(this.value)" id="select-status" style="" class="form-control input-sm">
                                <option value="ENABLE">ENABLE</option>
                                <option value="DISABLE">DISABLE</option>
                            </select>

                        </div>
                        <div class="col-8 text-right">
                            <button type="button" onclick="create()" class="btn btn-sm btn-success"><i class="fa fa-plus"></i> Tambah Layanan</button>

                        </div>
                    </div>
                    <br>
                    <input type="hidden" id="dataId">
                    <div id="load-table"></div>
                    <button class="btn btn-danger btn-sm" type="button" onclick="hapuspilihdata()" id="btn-hapus-data"><i class="fa fa-trash"></i> Hapus Data Terpilih</button>

                   
                </div>  <!--end card-body-->                                     
            </div><!--end card-->
        </div><!--end col-->
      
        
    </div><!--end row-->

</div><!-- container -->

  <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    	<div class="modal-dialog" role="document" style="z-index: 9999">

  	    <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mt-0" id="myLargeModalLabel">
                    <span id="title-form" ></span>
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
                <div class="modal-body" >
                    <div id="load-form"></div>
    	        </div>
                
  	  </div>
  	</div>
  </div>

  <script type="text/javascript">
    

    var idrow = "";
    var idbutton = "";

    function loadtable(status) {
          var table = '<table class="table table-bordered dt-responsive nowrap " style="border-collapse: collapse; border-spacing: 0; width: 100%;"  id="mytable">'+
                      '     <thead>'+
                      '     <tr>'+
                      '       <th style="width:20px">#</th>'+
                      '       <th style="width:20px">No</th>'+
                      '       <th>Kode Layanan</th>'+
                      '       <th>Nama Layanan</th>'+
                      '       <th style="width:100px">Status</th>'+
                      '       <th style="width:150px"></th>'+
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
                ajax: {"url": "<?= base_url('master/Service/json?status=') ?>"+status, "type": "POST"},
                columns: [
                    {"data": "id","orderable": false, "className": "text-center"},
                    {"data": "id","orderable": false},
                    {"data": "code"},
                    {"data": "name"},
                    {"data": "status", "className": "text-center"},
                    {"data": "view", "orderable": false
                    }
                ],
                order: [[1, 'asc']],
                columnDefs : [
                    { 
                      targets : [0],
                        render : function (data, type, row, meta) {
                          var cbinput = $("#dataId").val();
                          cb = cbinput.split(',');
                          var checked = "";
                          if(cb.includes(row['id'])) checked = "checked";
                          if(cbinput=="all") checked = "checked";
                          return "<input type='checkbox' onclick='checkdata($(this),"+row['id']+")' value='"+row['id']+"' "+checked+">";
                          }
                    },
                  
                    
                    { targets : [4],
                        render : function (data, type, row, meta) {
                                if(row['status']=='ENABLE'){
                                  var htmls = '<a href="<?= base_url('master/Service/status/') ?>'+row['id']+'/DISABLE">'+
                                            '    <button type="button" class="btn btn-sm btn-sm btn-warning"><i class="fa fa-power-off"></i> Non Active</button>'+
                                            '</a>';
                              }else{
                                  var htmls = '<a href="<?= base_url('master/Service/status/') ?>'+row['id']+'/ENABLE">'+
                                            '    <button type="button" class="btn btn-sm btn-sm btn-success"><i class="fa fa-check"></i> Active</button>'+
                                            '</a>';
                              }
                              return htmls;
                          }
                      }
                ],

                rowCallback: function(row, data, iDisplayIndex) {
                      var info = this.fnPagingInfo();
                    var page = info.iPage;
                    var length = info.iLength;
                    var index = page * length + (iDisplayIndex + 1);
                    $('td:eq(1)', row).html(index);
                    
                }
            });
         }
         loadtable($("#select-status").val());
           
      function edit(id,e) {
        idrow = e.parent().parent().parent();
        idbutton = e.parent().parent();
        $("#load-form").html('loading...');
        $("#modal-form").modal();
        $("#title-form").html('Edit Layanan');
        $("#load-form").load("<?= base_url('master/Service/edit/') ?>"+id);
      }

      function create() {
        $("#load-form").html('loading...');
        $("#modal-form").modal();
        $("#title-form").html('Tambah Layanan');
        $("#load-form").load("<?= base_url('master/Service/create/') ?>");
      }
                  
      function hapus(id,e) {
        idrow = e.parent().parent().parent();
        idbutton = e.parent().parent();
        Swal.fire({
            title: 'Warning ?',
          text: "Are you sure you delete this data",
          icon: 'warning',
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.isConfirmed) {
              $.ajax({
                  url: '<?= base_url('master/service/delete/')?>',
                type: 'post',
                dataType: 'html',
                data: {id: id},
                beforeSend:function () { },
                success:function(response, textStatus, xhr) {
                  var str = response;
                    if (str.indexOf("success") != -1){
                    //   idbutton.html('<label class="badge bg-red">Deleted</label> <label class="badge bg-red" style="cursor:pointer" onclick="loadtable($(\'#select-status\').val());"><i class="fa fa-refresh"></i> </label>');
                    //   idrow.addClass('bg-danger');
                    loadtable($("#select-status").val());

                      Swal.fire(
                          'Deleted!',
                        'Your data has been deleted.',
                        'success'
                      );
                    }else{
                      Swal.fire({
                        title: "Oppss!",
                        html: str,
                        icon: "error"
                      });
                    }
                }
              }); 
          }
        })
      }

      var array = [];
      function checkdata(e,id) {
        if(e.is(':checked')){
          if(!array.includes(e.val())) array.push(e.val());
        }else{ 
              var removeItem = e.val();
            array = jQuery.grep(array, function(value) {
                return value != removeItem;
            });
        }
        $("#dataId").val(array.join())
      }

      function hapuspilihdata() {
        var data = $('#dataId').val();
        Swal.fire({
        title: 'Warning ?',
        text: "Are you sure you delete this data",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
          if (result.isConfirmed) {
            $.ajax({
              url: '<?= base_url('master/service/Deletedata/')?>',
              type: 'post',
              dataType: 'html',
              data: {data: data},
              beforeSend:function () {

              },
              success:function() {
                loadtable($("#select-status").val());
                $('#dataId').val('');
                Swal.fire(
                            'Deleted!',
                          'Your data has been deleted.',
                          'success'
                        )
              }
            }); 
          }
        })
      }
  </script>