
  <main class="flex-shrink-0">
    <div class="container pt-5">
      <!-- tampilkan pesan selamat datang -->
      <div class="alert alert-light d-flex align-items-center mb-5" role="alert">
        <i class="bi-info-circle text-success me-3 fs-3"></i>
        <div>
          Selamat Datang di <strong>Aplikasi Antrian Berbasis Web</strong>. Silahkan pilih halaman yang ingin ditampilkan.
        </div>
      </div> 
      <?php if($this->input->get('number')){ ?>
      <div class="alert alert-info d-flex align-items-center mb-5" role="alert" id="alert-nomor">
        <i class="bi-info-circle text-success me-3 fs-3"></i>
        <div>
          Anda mendapatkan nomor antrian <strong><?= $this->input->get('number') ?></strong>
        </div>
      </div>
      <script>
        setTimeout(() => {
            $("#alert-nomor").remove();
        }, 5000);
      </script>
      <?php } ?>

      <div class="row gx-5">
        <!-- link halaman nomor antrian -->
        <?php
        $lockets = $this->mymodel->selectWhere('locket',['status'=>'ENABLE']);
        foreach($lockets as $locket){
            $services = json_decode($locket['json_service'])
        ?>
        <div class="col-lg-6 mb-4">
          <div class="card border-0 shadow-sm">
            <div class="card-body p-5">
              <div class="feature-icon-1 bg-success bg-gradient mb-4">
                <i class="bi-people"></i>
              </div>
              <h3><?= $locket['name'] ?></h3>
              <p class="mb-4">Silahkan pilih Layanan yang anda perlukan.</p>
              <?php
                foreach($services as $service){
                    $cek = $this->mymodel->selectDataone('service',['id'=>$service->id,'status'=>'ENABLE']);
                    if($cek){
              ?>
              <a href="<?= base_url('queue/get-number/'.$locket['id'].'/'.$service->id) ?>" class="btn btn-success rounded-pill px-4 py-2">
                <?= $service->name ?> <i class="bi-chevron-right ms-2"></i>
              </a>
              <?php }} ?>
            </div>
          </div>
        </div>
        <?php } ?>
       
      </div>
    </div>
    </main>