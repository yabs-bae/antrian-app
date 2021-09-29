<div class="container-fluid">
    <!-- Page-Title -->
    <div class="row">
        <div class="col-sm-12">
            <div class="page-title-box">
                <div class="float-right">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Master</a></li>
                        <li class="breadcrumb-item"><a href="javascript:void(0);">Loket</a></li>
                        <li class="breadcrumb-item active">Tambah</li>
                    </ol>
                </div>
                <h4 class="page-title">Loket</h4>
            </div><!--end page-title-box-->
        </div><!--end col-->
    </div>
    <!-- end page title end breadcrumb -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="mt-0 header-title">Buat Loket Baru</h4>
                        <form method="POST" action="<?= base_url('master/Locket/store') ?>" id="upload-create" enctype="multipart/form-data">
                            <div class="show_error"></div>
                            <div class="form-group">
                                <label for="form-code">Kode</label>
                                <input type="text" class="form-control" id="form-code" placeholder="Masukan Kode" name="dt[code]">
                            </div>

                            <div class="form-group">
                                <label for="form-name">Nama Loket</label>
                                <input type="text" class="form-control" id="form-name" placeholder="Masukan Nama Loket" name="dt[name]">
                            </div>

                            <div class="form-group">
                                <label for="form-description">Deskripsi</label>
                                <textarea name="dt[description]" class="form-control"></textarea>
                            </div>

                        <div class="form-group">
                            <label for="form-json_service">Layanan</label>
                            <select name="dt[json_service][]" class="form-control select2" style="width:100%" multiple="multiple">
                                <?php 
                                $service = $this->mymodel->selectWhere('service',null);
                                foreach ($service as $service_record) {
                                    echo "<option value=".$service_record['id'].">".$service_record['name']."</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-gradient-primary btn-send" ><i class="fa fa-save"></i> Save</button>
                        <button type="reset" class="btn btn-gradient-danger"><i class="fa fa-refresh"></i> Reset</button>
                    </form>                                           
                </div><!--end card-body-->
            </div>
        </div><!--end col-->
      
        
    </div><!--end row-->

</div><!-- container -->
<script type="text/javascript">


      $("#upload-create").submit(function(){
              var form = $(this);
            var mydata = new FormData(this);
            $.ajax({
                  type: "POST",
                url: form.attr("action"),
                data: mydata,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend : function(){
                      $(".btn-send").addClass("disabled").html("<i class='la la-spinner la-spin'></i>  Processing...").attr('disabled',true);
                    form.find(".show_error").slideUp().html("");
                },
                success: function(response, textStatus, xhr) {
                  
                      // alert(mydata);
                   var str = response;
                    if (str.indexOf("success") != -1){
                          Swal.fire({
                              title: "It works!",
                              text: "Successfully added data",
                              icon: "success"
                          });
                          // form.find(".show_error").hide().html(response).slideDown("fast");
                        setTimeout(function(){ 
                             window.location.href = "<?= base_url('master/Locket') ?>";
                        }, 1000);
                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
                    }else{
                        Swal.fire({
                          title: "Oppss!",
                          html: str,
                          icon: "error"
                        });
                          // form.find(".show_error").hide().html(response).slideDown("fast");
                        $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);

                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log(xhr);
                    Swal.fire({
                        title: "Oppss!",
                        text: xhr,
                        icon: "error"
                    });
                    $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
                    // form.find(".show_error").hide().html(xhr).slideDown("fast");
                }
            });
            return false;

        });
  </script>