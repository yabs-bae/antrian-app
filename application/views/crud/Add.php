<?php 
$query = "SELECT COLUMN_NAME,COLUMN_KEY FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='".$this->db->database."' AND TABLE_NAME='".$table."' AND COLUMN_KEY = 'PRI'";
$pri = $this->mymodel->selectWithQuery($query);
$primary = $pri[0]['COLUMN_NAME'];
$c = ucfirst(str_replace(".php", "", $controller));
if($form_type=="page"){
    $stringadd = "
  <!-- Content Wrapper. Contains page content -->
  <div class=\"content-wrapper\">
    <!-- Content Header (Page header) -->
    <section class=\"content-header\">
      <h1>
        ".$this->template->label($table)."
        <small>Master</small>
      </h1>
      <ol class=\"breadcrumb\">
        <li><a href=\"#\"><i class=\"fa fa-dashboard\"></i> Home</a></li>
        <li><a href=\"#\">master</a></li>
        <li class=\"active\">".$this->template->label($table)."</li>
      </ol>
    </section>
    <!-- Main content -->
    <section class=\"content\">
    <form method=\"POST\" action=\"<?= base_url('master/".$c."/store') ?>\" id=\"upload-create\" enctype=\"multipart/form-data\">
      <div class=\"row\">
        <div class=\"col-xs-8\">
          <div class=\"panel\">
            <!-- /.panel-header -->
            <div class=\"panel-heading\">
              <h5 class=\"panel-title\">
                  Tambah ".$this->template->label($table)."
              </h5>
            </div>
            <div class=\"panel-body\">
                <div class=\"show_error\"></div>";
$i=0;
$select = 0;
$select_static = 0;
foreach ($kolom as $klm) {
    $tipe = $type[$i]; 
  if($tipe!="HIDDEN"){
    if($tipe=="TEXT"){
    $stringadd .=  "
                    <div class=\"form-group\">
                        <label for=\"form-".$klm."\">".$label->$klm."</label>
                        <input type=\"text\" class=\"form-control\" id=\"form-".$klm."\" placeholder=\"Masukan ".$label->$klm."\" name=\"dt[".$klm."]\">
                    </div>\n";
  }
  if($tipe=="PRICE"){
      $stringadd .=  "
                    <div class=\"form-group\">
                        <label for=\"form-".$klm."\">".$label->$klm."</label>
                        <input type=\"text\" class=\"form-control money\" id=\"form-".$klm."\" placeholder=\"Masukan ".$label->$klm."\" name=\"dt[".$klm."]\">
                    </div>\n";
    }
 if($tipe=="DATE"){ 
    $stringadd .=  "
                    <div class=\"form-group\">
                        <label for=\"form-".$klm."\">".$label->$klm."</label>
                        <input type=\"text\" class=\"form-control tgl\" id=\"form-".$klm."\" placeholder=\"Masukan ".$label->$klm."\" name=\"dt[".$klm."]\">
                    </div>\n";
  }
 if($tipe=="TEXTAREA"){ 
    $stringadd .=  "
                    <div class=\"form-group\">
                        <label for=\"form-".$klm."\">".$label->$klm."</label>
                        <textareas name=\"dt[".$klm."]\" class=\"form-control\"></textareas>
                    </div>\n";
  }

  if($tipe=="TINY MCE"){ 
    $stringadd .=  "
                    <div class=\"form-group\">
                        <label for=\"form-".$klm."\">".$label->$klm."</label>
                        <textareas name=\"dt[".$klm."]\" class=\"form-control tinymce\" id=\"form-".$klm."\"></textareas>
                    </div>\n";
  }

  if($tipe=="SELECT OPTION"){ 
    $stringadd .=  "
                  <div class=\"form-group\">
                      <label for=\"form-".$klm."\">".$label->$klm."</label>
                      <select name=\"dt[".$klm."]\" class=\"form-control select2\" style=\"width:100%\">
                        <?php 
                        \$".$select_kolom[$select]." = \$this->mymodel->selectWhere('".$select_kolom[$select]."',null);
                        foreach (\$".$select_kolom[$select]." as \$".$select_kolom[$select]."_record) {
                            echo \"<option value=\".\$".$select_kolom[$select]."_record['".$select_value[$select]."'].\">\".\$".$select_kolom[$select]."_record['".$select_option[$select]."'].\"</option>\";
                        }
                        ?>
                      </select>
                  </div>\n";
    $select++;
  }
  if($tipe=="SELECT OPTION STATIC"){ 
      $stringstatic = '';
    $name_arr_option_static = 'option_static'.$post_input['static_select'][$select_static];
    $name_arr_value_static = 'value_static'.$post_input['static_select'][$select_static];
    foreach($post_input[$name_arr_option_static] as $pi => $val){
         $stringstatic .= "<option value=\"".$post_input[$name_arr_value_static][$pi]."\">".$val."</option>
       "; 
    }
  $stringadd .=  "
                <div class=\"form-group\">
                    <label for=\"form-".$klm."\">".$label->$klm."</label>
                    <select name=\"dt[".$klm."]\" class=\"form-control\">
                      <option value=\"\">Pilih</option>
                      ".$stringstatic."
                    </select>
                </div>\n";
    $select_static++;
  }
  }
$i++;
}
if($file==true){
    $stringadd .=  "
                  <div class=\"form-group\">
                      <label for=\"form-file\">File</label>
                      <input type=\"file\" class=\"form-control\" id=\"form-file\" placeholder=\"Masukan File\" name=\"file\">
                  </div>\n";
}
  $stringadd .=  "
            </div>
            <div class=\"panel-footer\">
                <button type=\"submit\" class=\"btn btn-primary btn-send\" ><i class=\"fa fa-save\"></i> Save</button>
                <button type=\"reset\" class=\"btn btn-danger\"><i class=\"fa fa-refresh\"></i> Reset</button>

            </div>
            <!-- /.panel-body -->
          </div>
          <!-- /.panel -->
          <!-- /.panel -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
      </form>
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <script type=\"text/javascript\">


      \$(\"#upload-create\").submit(function(){
              var form = \$(this);
            var mydata = new FormData(this);
            \$.ajax({
                  type: \"POST\",
                url: form.attr(\"action\"),
                data: mydata,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend : function(){
                      \$(\".btn-send\").addClass(\"disabled\").html(\"<i class='la la-spinner la-spin'></i>  Processing...\").attr('disabled',true);
                    form.find(\".show_error\").slideUp().html(\"\");
                },
                success: function(response, textStatus, xhr) {
                  
                      // alert(mydata);
                   var str = response;
                    if (str.indexOf(\"success\") != -1){
                          Swal.fire({
                              title: \"It works!\",
                              text: \"Successfully added data\",
                              icon: \"success\"
                          });
                          // form.find(\".show_error\").hide().html(response).slideDown(\"fast\");
                        setTimeout(function(){ 
                             window.location.href = \"<?= base_url('master/".$c."') ?>\";
                        }, 1000);
                        \$(\".btn-send\").removeClass(\"disabled\").html('<i class=\"fa fa-save\"></i> Save').attr('disabled',false);
                    }else{
                        Swal.fire({
                          title: \"Oppss!\",
                          html: str,
                          icon: \"error\"
                        });
                          // form.find(\".show_error\").hide().html(response).slideDown(\"fast\");
                        \$(\".btn-send\").removeClass(\"disabled\").html('<i class=\"fa fa-save\"></i> Save').attr('disabled',false);

                    }
                },
                error: function(xhr, textStatus, errorThrown) {
                    console.log(xhr);
                    Swal.fire({
                        title: \"Oppss!\",
                        text: xhr,
                        icon: \"error\"
                    });
                    \$(\".btn-send\").removeClass(\"disabled\").html('<i class=\"fa fa-save\"></i> Save').attr('disabled',false);
                    // form.find(\".show_error\").hide().html(xhr).slideDown(\"fast\");
                }
            });
            return false;

        });
  </script>";
}else{
  



   $stringadd = "
  <form method=\"POST\" action=\"<?= base_url('master/".$c."/store') ?>\" id=\"upload-create\" enctype=\"multipart/form-data\">
    <div class=\"show_error\"></div>";
$i=0;
$select = 0;
$select_static = 0;
foreach ($kolom as $klm) {
    $tipe = $type[$i]; 
  if($tipe!="HIDDEN"){
    if($tipe=="TEXT"){
    $stringadd .=  "
      <div class=\"form-group\">
          <label for=\"form-".$klm."\">".$label->$klm."</label>
          <input type=\"text\" class=\"form-control\" id=\"form-".$klm."\" placeholder=\"Masukan ".$label->$klm."\" name=\"dt[".$klm."]\">
      </div>\n";
}
  if($tipe=="PRICE"){
      $stringadd .=  "
      <div class=\"form-group\">
          <label for=\"form-".$klm."\">".$label->$klm."</label>
          <input type=\"text\" class=\"form-control money\" id=\"form-".$klm."\" placeholder=\"Masukan ".$label->$klm."\" name=\"dt[".$klm."]\">
      </div>\n";

    }
 if($tipe=="DATE"){ 
    $stringadd .=  "
      <div class=\"form-group\">
          <label for=\"form-".$klm."\">".$label->$klm."</label>
          <input type=\"text\" class=\"form-control tgl\" autocomplete=\"off\" id=\"form-".$klm."\" placeholder=\"Masukan ".$label->$klm."\" name=\"dt[".$klm."]\">
      </div>\n";
  }
 if($tipe=="TEXTAREA"){ 
    $stringadd .=  "
      <div class=\"form-group\">
          <label for=\"form-".$klm."\">".$label->$klm."</label>
          <textareas name=\"dt[".$klm."]\" class=\"form-control\" id=\"form-".$klm."\"></textareas>
      </div>\n";
  }

  if($tipe=="TINY MCE"){ 
    $stringadd .=  "
      <div class=\"form-group\">
          <label for=\"form-".$klm."\">".$label->$klm."</label>
          <textareas name=\"dt[".$klm."]\" class=\"form-control tinymce\" id=\"form-".$klm."\"></textareas>
      </div>\n";
  }

  if($tipe=="SELECT OPTION"){ 
    $stringadd .=  "
      <div class=\"form-group\">
          <label for=\"form-".$klm."\">".$label->$klm."</label>
          <select name=\"dt[".$klm."]\" class=\"form-control select2\" style=\"width:100%\" id=\"form-".$klm."\">
            <?php 
            \$".$select_kolom[$select]." = \$this->mymodel->selectWhere('".$select_kolom[$select]."',null);
            foreach (\$".$select_kolom[$select]." as \$".$select_kolom[$select]."_record) {
                echo \"<option value=\".\$".$select_kolom[$select]."_record['".$select_value[$select]."'].\">\".\$".$select_kolom[$select]."_record['".$select_option[$select]."'].\"</option>\";
            }
            ?>
          </select>
      </div>\n";
    $select++;
  }
  if($tipe=="SELECT OPTION STATIC"){ 
      $stringstatic = '';
    $name_arr_option_static = 'option_static'.$post_input['static_select'][$select_static];
    $name_arr_value_static = 'value_static'.$post_input['static_select'][$select_static];
    foreach($post_input[$name_arr_option_static] as $pi => $val){
         $stringstatic .= "<option value=\"".$post_input[$name_arr_value_static][$pi]."\">".$val."</option>
       "; 
    }
  $stringadd .=  "
      
      <div class=\"form-group\">
          <label for=\"form-".$klm."\">".$label->$klm."</label>
          <select name=\"dt[".$klm."]\" class=\"form-control\" id=\"form-".$klm."\">
            <option value=\"\">Pilih</option>
            ".$stringstatic."
          </select>
      </div>\n";
    $select_static++;
  }
  }
$i++;
}
if($file==true){
    $stringadd .=  "
      <div class=\"form-group\">
          <label for=\"form-file\">File</label>
          <input type=\"file\" class=\"form-control\" id=\"form-file\" placeholder=\"Masukan File\" name=\"file\">
      </div>\n";
}
  $stringadd .=  "
    <div class=\"text-right\"> 
      <button type=\"submit\" class=\"btn btn-primary btn-send\" ><i class=\"fa fa-save\"></i> Save</button>
      <button type=\"reset\" class=\"btn btn-danger\"><i class=\"fa fa-refresh\"></i> Reset</button>
    </div>
  </form>

  <!-- /.content-wrapper -->
  <script type=\"text/javascript\">


  $(\"#upload-create\").submit(function(){
    var form = $(this);
    var mydata = new FormData(this);
    $.ajax({
          type: \"POST\",
        url: form.attr(\"action\"),
        data: mydata,
        cache: false,
        contentType: false,
        processData: false,
        beforeSend : function(){
              $(\".btn-send\").addClass(\"disabled\").html(\"<i class='la la-spinner la-spin'></i>  Processing...\").attr('disabled',true);
        },
        success: function(response, textStatus, xhr) {
              // alert(mydata);
            var str = response;
            if (str.indexOf(\"success\") != -1){
                Swal.fire({
                    title: \"It works!\",
                    text: \"Successfully added data\",
                    icon: \"success\"
                });

                setTimeout(function(){ 
                    $(\"#mytable tbody\").prepend('<tr class=\"bg-warning\">'+
                                                  '   <td>#</td>'+
                                                  '   <td></td>'+\n";
      foreach ($kolom as $klm) {
$stringadd .="                                                  '   <td>'+$(\"#form-".$klm."\").val()+'</td>'+
";
      }

$stringadd .="
                                                  '   <td></td>'+
                                                  '   <td><label class=\"badge bg-orange\">Created</label> <label class=\"badge bg-red\" style=\"cursor:pointer\" onclick=\"loadtable($(\'#select-status\').val());\"><i class=\"fa fa-refresh\"></i> </label></td>'+
                                                  ' </tr>');
                    $(\"#modal-form\").modal('hide');
                }, 1000);
                $(\".btn-send\").removeClass(\"disabled\").html('<i class=\"fa fa-save\"></i> Save').attr('disabled',false);
            }else{
                $(\".btn-send\").removeClass(\"disabled\").html('<i class=\"fa fa-save\"></i> Save').attr('disabled',false);
                Swal.fire({
                    title: \"Oppss!\",
                    html: str,
                    icon: \"error\"
                });
            }
        },
        error: function(xhr, textStatus, errorThrown) {
            console.log(xhr.responseText);
            Swal.fire({
                    title: \"Oppss!\",
                    text: xhr,
                    icon: \"error\"
                });
            $(\".btn-send\").removeClass(\"disabled\").html('<i class=\"fa fa-save\"></i> Save').attr('disabled',false);
        }
    });
    return false;

    });
    $('.select2').select2();
    $('.tgl').datepicker({
      autoclose: true,
      format:'yyyy-mm-dd'
    });

  </script>";
}
    $this->template->createFile(str_replace("textareas","textarea",$stringadd), $path);
?>

<label>Location : <?= $path ?></label>
<textarea id="editoradd" name="add"><?= $stringadd ?></textarea>
<input type="hidden" name="path_add" value="<?= $path ?>" id="">

<script>
var editoradd = CodeMirror.fromTextArea(document.getElementById('editoradd'), {
		mode: "application/x-httpd-php",
        theme: "dracula",
        lineNumbers: true,
        autoCloseTags: true
      });
	  editoradd.setSize(null, 500);
</script>