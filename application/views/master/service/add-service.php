
  <form method="POST" action="<?= base_url('master/Service/store') ?>" id="upload-create" enctype="multipart/form-data">
    <div class="show_error"></div>
      <div class="form-group">
          <label for="form-code">Kode Layanan</label>
          <input type="text" class="form-control" id="form-code" placeholder="Masukan Kode Layanan" name="dt[code]">
      </div>

      <div class="form-group">
          <label for="form-name">Nama Layanan</label>
          <input type="text" class="form-control" id="form-name" placeholder="Masukan Nama Layanan" name="dt[name]">
      </div>

    <div class="text-right"> 
      <button type="submit" class="btn btn-primary btn-send" ><i class="fa fa-save"></i> Save</button>
      <button type="reset" class="btn btn-danger"><i class="fa fa-refresh"></i> Reset</button>
    </div>
  </form>

  <!-- /.content-wrapper -->
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

                setTimeout(function(){ 
                    loadtable($('#select-status').val());
                    $("#modal-form").modal('hide');
                }, 1000);
                $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
            }else{
                $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
                Swal.fire({
                    title: "Oppss!",
                    html: str,
                    icon: "error"
                });
            }
        },
        error: function(xhr, textStatus, errorThrown) {
            console.log(xhr.responseText);
            Swal.fire({
                    title: "Oppss!",
                    text: xhr,
                    icon: "error"
                });
            $(".btn-send").removeClass("disabled").html('<i class="fa fa-save"></i> Save').attr('disabled',false);
        }
    });
    return false;

    });
    $('.select2').select2();
    $('.tgl').datepicker({
      autoclose: true,
      format:'yyyy-mm-dd'
    });

  </script>