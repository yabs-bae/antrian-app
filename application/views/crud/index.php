  <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
          CRUD
          <small>Generator</small>
        </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
          <li><a href="#">CRUD</a></li>
          <li class="active">Generator</li>
        </ol>
      </section>
      <!-- Main content -->
      <section class="content">
        <div class="row">
          <div class="col-xs-12">
            <div class="box">
              <!-- <div class="box-header">
                <h3 class="box-title">
                </h3>
              </div> -->
              <!-- /.box-header -->
              <div class="box-body">
                  <div class="row">
                    <div class="col-md-4">
                      <?php 
                      $name_table = @$_GET['table'];

                      $query = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA='".$this->db->database."' ORDER BY TABLE_NAME ASC";
                      $tables = $this->mymodel->selectWithQuery($query);
                     ?>
                     <small>Table <span class="text-danger">*</span></small>
                      <select class="form-control select2" onchange="loadtable(this.value)">
                        <option value="">Pilih Table</option>
                      <?php 
                        foreach ($tables as $table) {
                            if($table['TABLE_NAME']=="file" OR $table['TABLE_NAME']=="site" OR $table['TABLE_NAME']=="user" OR $table['TABLE_NAME']=="role" OR $table['TABLE_NAME']=="access_control" OR $table['TABLE_NAME']=="access" OR $table['TABLE_NAME']=="menu_master"){

                          }else{
                         ?>
                        <option value="<?= $table['TABLE_NAME'] ?>" <?php if($name_table==$table['TABLE_NAME']) echo "selected"; ?>><?= $table['TABLE_NAME'] ?></option>
                      <?php } } ?>
                      </select>
                    </div>
                  </div>
                  <hr>
                  <form method="POST" action="<?= base_url('crud/generate') ?>">
                    <input type="hidden" name="table" value="<?= $name_table ?>">
                  <div class="row">
                    <?php 
                      if(!empty($name_table)){
                        $structure_query = "SELECT COLUMN_NAME,COLUMN_KEY,DATA_TYPE FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='".$this->db->database."' AND TABLE_NAME='".$name_table."'";
                      $structure = $this->mymodel->selectWithQuery($structure_query);

                     ?>
                    <div class="col-md-8">
                     <table class="table table-condensed table-bordered datatables" id="sortable">
                       <thead>
                         <tr class="bg-gray">
                           <th></th>
                           <th>COLUMN_NAME</th>
                           <th>LABEL</th>
                           <th>COLUMN_KEY</th>
                           <th>DATA_TYPE</th>
                           <th></th>
                         </tr>
                       </thead>
                       <tbody>
                        <?php 
                          foreach ($structure as $st) { 
                            $COLUMN_NAME[] = $st['COLUMN_NAME'];      
                                             
                          ?>
                          <?php if($st['COLUMN_KEY']!="PRI" AND $st['COLUMN_NAME']!="status" AND $st['COLUMN_NAME']!="created_at" AND $st['COLUMN_NAME']!="updated_at" AND $st['COLUMN_NAME']!="updated_by" AND $st['COLUMN_NAME']!="created_by"){ ?>
                         <tr style="cursor:move">
                           <td>
                             <input type="hidden" name="collum[]" value="<?= $st['COLUMN_NAME'] ?>">
                              <?php if($st['COLUMN_KEY']!="PRI" AND $st['COLUMN_NAME']!="status" AND $st['COLUMN_NAME']!="created_at" AND $st['COLUMN_NAME']!="updated_at" AND $st['COLUMN_NAME']!="updated_by" AND $st['COLUMN_NAME']!="created_by"){ ?>

                             <input type="checkbox" name="show[]" checked="" value="<?= $st['COLUMN_NAME'] ?>">
                          <?php } ?>
                           </td>
                           <td><?= $st['COLUMN_NAME'] ?></td>

                           <td style="width:230px">
                              <?php if($st['COLUMN_KEY']!="PRI" AND $st['COLUMN_NAME']!="status" AND $st['COLUMN_NAME']!="created_at" AND $st['COLUMN_NAME']!="updated_at" AND $st['COLUMN_NAME']!="updated_by" AND $st['COLUMN_NAME']!="created_by"){ ?>

                              <input type="text" name="label[<?= $st['COLUMN_NAME'] ?>]" id="" class="form-control input-sm" value="<?= str_replace('_',' ',ucfirst(strtolower($st['COLUMN_NAME'])))  ?>">
                              <?php } ?>  
                            </td>
                           <td><?= $st['COLUMN_KEY'] ?></td>
                           <td><?= $st['DATA_TYPE'] ?></td>
                           <td>
                              <?php if($st['COLUMN_KEY']!="PRI" AND $st['COLUMN_NAME']!="status" AND $st['COLUMN_NAME']!="created_at" AND $st['COLUMN_NAME']!="updated_at" AND $st['COLUMN_NAME']!="updated_by" AND $st['COLUMN_NAME']!="created_by"){ ?>

                             <select name="type[]" class="form-control input-sm">
                               <option value="TEXT">TEXT</option>
                               <option value="PRICE">PRICE</option>
                               <option value="TEXTAREA">TEXTAREA</option>
                               <option value="TINY MCE">TINY MCE</option>
                               <option value="SELECT OPTION">SELECT OPTION DYNAMIC</option>
                               <option value="SELECT OPTION STATIC">SELECT OPTION STATIC</option>
                               <option value="DATE">DATE</option>
                             </select>
                          <?php }else{ ?>
                            <input type="hidden" name="type[]" value="HIDDEN">
                          <?php } ?>
                           </td>
                         </tr>
                         <?php } ?>
                       <?php } ?>

                       </tbody>
                     </table>

                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                          <label for="">Controller File</label>
                          <input type="text" class="form-control" id="" name="controller" placeholder="Controller" value="<?= ucfirst($name_table) ?>.php">
                        </div>
                        <div class="form-group">
                          <label for="">Table</label><br>
                          <input type="radio" value="datatables" name="form_table" checked="">Datatables <br>
                          <input type="radio" value="datatables_search" name="form_table">Datatables Search
                        </div>
                        <div class="form-group">
                          <label for="">Create/Edit Form</label><br>
                          <input type="radio" value="page" name="form_type" checked="">Page <br>
                          <input type="radio" value="modal" name="form_type">Modal
                        </div>
                        <div class="form-group">
                          <label for="">File</label><br>
                          <input type="checkbox" value="1" name="file" checked=""> <em>Centang apabila menggunakan input file</em>
                        </div>
                    </div>
                    <div class="col-md-12">
                    <?php 
  $li="";
   if (!in_array("status", $COLUMN_NAME)){
       $li.= "<li><em>ALTER TABLE ".$name_table." ADD COLUMN status ENUM('ENABLE','DISABLE');</em></li>";
     }

     if (!in_array("created_at", $COLUMN_NAME)){
         $li.= "<li><em>ALTER TABLE ".$name_table." ADD COLUMN created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP() AFTER status</em></li>";
     }

     if (!in_array("created_by", $COLUMN_NAME)){
          $li.= "<li><em>ALTER TABLE ".$name_table." ADD COLUMN created_by INT AFTER created_at;</em></li>";
      }
      
     if (!in_array("updated_at", $COLUMN_NAME)){
         $li.= "<li><em>ALTER TABLE ".$name_table." ADD COLUMN updated_at DATETIME NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP() AFTER created_at;</em></li>";
     }

     if (!in_array("updated_by", $COLUMN_NAME)){
      $li.= "<li><em>ALTER TABLE ".$name_table." ADD COLUMN updated_by INT AFTER updated_at;</em></li>";
  }



    

   
    
  if($li!=""){
    ?>  
  <div class="alert alert-danger">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Copy ke SQL!</strong>
  <ul>
   <?php echo $li; ?>
  </ul>
  </div>
  <?php } ?>
  <br>
                      <button class="btn btn-danger" type="submit"><i class="fa fa-cog"></i> GENERATE</button>
                      <a class="btn btn-warning" href="<?= base_url('crud/api?table='.$name_table) ?>"><i class="fa fa-cog"></i> GENERATE API</a>
                    </div>
                    <?php } ?>
                  </div>
                  </form>

              </div>
              <!-- /.box-body -->
            </div>
            <!-- /.box -->
            <!-- /.box -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
    <script type="text/javascript">
      function loadtable(val) {
          // body...
        window.location.href = "<?= base_url('crud?table=') ?>"+val;
      }

      $(function() {
      $("#sortable tbody").sortable({
        cursor: "move",
        placeholder: "sortable-placeholder",
        helper: function(e, tr)
        {
          var $originals = tr.children();
          var $helper = tr.clone();
          $helper.children().each(function(index)
          {
          // Set helper cell sizes to match the original sizes
          $(this).width($originals.eq(index).width());
          });
          return $helper;
        }
      }).disableSelection();
    });
    </script>
