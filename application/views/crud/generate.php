  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          GENERATE
          <small></small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="#">Tables</a></li>
          <li class="active">Data tables</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-md-8">
            <div class="box">
              <!-- <div class="box-header">
                <h3 class="box-title">

                </h3>
              </div> -->
              <!-- /.box-header -->
              <form action="<?= base_url('crud/save_generate') ?>" method="POST">
              <div class="box-body">
                <?php 
                $json = json_encode($_POST);
                $name_table = $_POST['table'];
                $controller = $_POST['controller'];
                $collum = $_POST['collum'];

                $type = $_POST['type'];
                ?>
                <textarea name="json" class="hide"><?= $json ?></textarea>
                <div class="row">
                  <div class="col-md-12">
                    <?php if(in_array("SELECT OPTION", $type)){ ?>
                  <div class="col-md-12">

                    <table class="table table-condenseed table-bordered datatables">
                      <caption><i class="fa fa-cogs"></i> Setting Form Select option (Dinamis)</caption>
                      <thead class="bg-gray">
                        <tr>
                          <th rowspan="2" width="200">COLUMN_NAME</th>
                          <th rowspan="2" width="200">TABLE</th>
                          <th rowspan="2" width="200">OPTION</th>
                          <th rowspan="2" width="200">VALUE</th>
                          <th rowspan="2">FILTER<br>TABLE</th>
                          <th colspan="2">LOAD COLUMN</th>
                        </tr>
                        <tr>
                          <th>JOIN</th>
                          <th>AJAX</th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php 
                        $i=0;
                        $b = 0;
                        foreach ($collum as $kolom) {
                          // $type = $_POST['type'][$i];
                        if($type[$i]=="SELECT OPTION"){
                          ?>
                        <tr>
                          <input type="hidden" name="id_select_dinamis[]">
                          <td><?= $kolom ?></td>
                          <td>
                            <?php 
                            $query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='".$this->db->database."'";
                            $tables = $this->mymodel->selectWithQuery($query);
                           ?>
                            <select onchange="loadtable(this.value,'<?= $kolom ?>')" name="kolom[]" required class="form-control select2 input-sm" width="100%">
                              <option value="">Choose Table</option>
                            <?php 
                              foreach ($tables as $table) {
                               ?>
                              <option value="<?= $table['TABLE_NAME'] ?>"><?= $table['TABLE_NAME'] ?></option>
                            <?php } ?>
                            </select>
                          </td>
                          <td>
                            <select id="<?= $kolom ?>-option" name="option[]" required class="form-control input-sm select2"></select>
                          </td>
                          <td>
                            <select id="<?= $kolom ?>-value" name="value[]" required class="form-control input-sm select2"></select>

                          </td>
                          <td class="text-center">
                            <input type="checkbox" value="<?= $kolom ?>" name="filter_select[]">
                          </td>
                          <td class="text-center"><input type="radio" name="kolomstatus<?=$b?>" value="join" checked></td>
                          <td class="text-center"><input type="radio" name="kolomstatus<?=$b?>" value="ajax"></td>
                        </tr>
                        <?php 
                        	$b++;
                    } $i++; } ?>
                      </tbody>
                    </table>

                  </div>
                     <?php
                     $b++;
                      } ?>
                     <?php if(in_array("SELECT OPTION STATIC", $type)){ ?>
                    <div class="col-md-8">
                      <table class="table table-condenseed table-bordered datatables">
                        <caption><i class="fa fa-cogs"></i> Setting Form Select option (Static)</caption>
                        <thead>
                          <tr class="bg-gray">
                            <th>COLUMN_NAME</th>
                            <th>FIELD</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                          $i=0;
                          foreach ($collum as $kolom) {
                            // $type = $_POST['type'][$i];
                          if($type[$i]=="SELECT OPTION STATIC"){
                            ?>
                          <tr>
                            <td width="200"><?= $kolom ?></td>
                            <td>
                                <input type="hidden" name="static_select[]" value="<?=$i?>">
                              <div class="col-md-12 row-select" style="margin-bottom: 10px">
                              <div class="col-md-5 no-padding">
                                <label>OPTION</label>
                              <input type="text" class="form-control input-sm" name="option_static<?=$i?>[]" required>
                              </div>
                              <div class="col-md-5 no-padding">
                                <label>VALUE</label>
                              <input type="text" class="form-control input-sm" name="value_static<?=$i?>[]" required>
                              </div>
                              <div class="col-md-2 no-padding">
                                <button class="btn btn-primary btn-sm add-row-select" data-row-id="<?=$i?>" type="button" style="margin-top: 22px;border-radius: 0px" ><i class="fa fa-plus"></i></button>
                              </div>
                            </div>
                            </td>
                          </tr>
                          <?php } $i++; } ?>
                        </tbody>
                      </table>

                    </div>
                     <?php } ?>
                    <button class="btn btn-success btn-block btn-flat"><i class="fa fa-download"></i> SAVE FILE</button>
                   </div>
                </div>
              </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
    <script type="text/javascript">
      $('.add-row-select').click(function(){
          // var htmls = ;
        var htmls = '<div class="col-md-12 row-select" style="margin-bottom: 10px">'+
                            '<div class="col-md-5 no-padding">'+
                            '<input type="text" class="form-control input-sm" name="option_static'+$(this).attr('data-row-id')+'[]" required>'+
                            '</div>'+
                            '<div class="col-md-5 no-padding">'+
                            '<input type="text" class="form-control input-sm" name="value_static'+$(this).attr('data-row-id')+'[]" required>'+
                            '</div>'+
                            '<div class="col-md-2 no-padding">'+
                              '<button class="btn btn-danger btn-sm delete-row-select" type="button" style="border-radius: 0px" ><i class="fa fa-minus"></i></button>'+
                            '</div>'+
                          '</div>';
        $(this).closest('td').append(htmls);
        deleteRowSelect();
      });
      deleteRowSelect();
      function deleteRowSelect(){
        $('.delete-row-select').click(function(){
          // var htmls = ;
        $(this).closest('.row-select').remove();
      });
    }
      function loadtable(table,kolom) {
          $.getJSON("<?= base_url('crud/get_kolom/') ?>"+table, function(jsonData){
               $("#"+kolom+"-option").empty();
             $("#"+kolom+"-value").empty();
             cb = '';
             $.each(jsonData, function(i,data){
                   cb+='<option value="'+data.value+'">'+data.value+'</option>';
             });
             $("#"+kolom+"-option").append(cb);
             $("#"+kolom+"-value").append(cb);
        });
      }
    </script>
