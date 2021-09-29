<main class="flex-shrink-0">
    <div class="container pt-5">
      <div class="row justify-content-lg-center">
        <div class="col-lg-5 mb-4">
          <div class="px-4 py-3 mb-4 bg-white rounded-2 shadow-sm">
            <!-- judul halaman -->
            <div class="d-flex align-items-center me-md-auto">
              <i class="bi-people-fill text-success me-3 fs-3"></i>
              <h1 class="h5 pt-2"><?= $locket['name'] ?> - <?= $service['name'] ?></h1>
            </div>
          </div>

          <div class="card border-0 shadow-sm">
            <div class="card-body text-center d-grid p-5">
              <div class="border border-success rounded-2 py-2 mb-5">
                <h3 class="pt-4">ANTRIAN</h3>
                <!-- menampilkan informasi jumlah antrian -->
                <h1 id="antrian" class="display-1 fw-bold text-success text-center lh-1 pb-2"></h1>
              </div>
              <!-- button pengambilan nomor antrian -->
              <button id="insert"  class="btn btn-success btn-block rounded-pill fs-5 px-5 py-4 mb-2">
                <i class="bi-person-plus fs-4 me-2"></i> Ambil Nomor
              </button>
              <a href="<?= base_url('queue') ?>" class="btn btn-light btn-block fs-5 px-5 py-4 mt-2">
                <i class="bi-arrow-left-circle-fill fs-4 me-2"></i> Kembali
              </a>
            </div>
          </div>

           
            
        </div>
      </div>
    </div>
  </main>

  <script>
      $(document).ready(function() {
      // tampilkan jumlah antrian
      $('#antrian').load('<?= base_url() ?>/queue/get-queue/<?= $locket['id'] ?>/<?= $service['id'] ?>');

      // proses insert data
      $('#insert').on('click', function() {
        let antrian = $('#antrian').html();
        $('#insert').attr('disabled',true)

        $.ajax({
          type: 'POST',                     // mengirim data dengan method POST
          url: '<?= base_url('queue/send-queue/'.$locket['id'].'/'.$service['id']) ?>?number='+antrian,                // url file proses insert data
          success: function(result) {       // ketika proses insert data selesai
            // jika berhasil
            if (result === 'Sukses') {
              // tampilkan jumlah antrian
              $('#antrian').load('<?= base_url() ?>/queue/get-queue/<?= $locket['id'] ?>/<?= $service['id'] ?>').fadeIn('slow');

              setTimeout(() => {
                let antrian = $('#antrian').html();
                location.href='<?= base_url('queue/') ?>?number='+antrian
              }, 1000);
            }
          },
        });
      });
    });
  </script>