
<?php 

if($this->session->userdata('session_sop')=="") {
        redirect('login/');
}
?>
<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>Antrian Online | Admin Dashboard</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="" name="author" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        <!-- App favicon -->
        <link rel="shortcut icon" href="<?= base_url('assets/admin/') ?>images/favicon.ico">

        <!-- App css -->
        <link href="<?= base_url('assets/admin/') ?>css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/admin/') ?>css/jquery-ui.min.css" rel="stylesheet">
        <link href="<?= base_url('assets/admin/') ?>css/icons.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/admin/') ?>css/metisMenu.min.css" rel="stylesheet" type="text/css" />

        <link href="<?= base_url('assets/admin/web/') ?>plugins/daterangepicker/daterangepicker.css" rel="stylesheet" />
        <link href="<?= base_url('assets/admin/web/') ?>plugins/select2/select2.min.css" rel="stylesheet" type="text/css" />

        <link href="<?= base_url('assets/admin/') ?>css/app.min.css" rel="stylesheet" type="text/css" />

        <!-- DataTables -->
        <link href="<?= base_url('assets/admin/web/') ?>plugins/datatables/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <link href="<?= base_url('assets/admin/web/') ?>plugins/datatables/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
        <!-- Responsive datatable examples -->
        <link href="<?= base_url('assets/admin/web/') ?>plugins/datatables/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" /> 
        <script src="<?= base_url('assets/admin/') ?>js/jquery.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>

        <script src="<?= base_url('assets/admin/web/') ?>plugins/moment/moment.js"></script>
        <script src="<?= base_url('assets/admin/web/') ?>plugins/daterangepicker/daterangepicker.js"></script>
        <script src="<?= base_url('assets/admin/web/') ?>plugins/select2/select2.min.js"></script>


         <!-- Responsive examples -->
     <!-- Required datatable js -->
        <script src="<?= base_url('assets/admin/web/') ?>plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="<?= base_url('assets/admin/web/') ?>plugins/datatables/dataTables.bootstrap4.min.js"></script>
        <script>
            $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings){
                return {
                    "iStart": oSettings._iDisplayStart,
                    "iEnd": oSettings.fnDisplayEnd(),
                    "iLength": oSettings._iDisplayLength,
                    "iTotal": oSettings.fnRecordsTotal(),
                    "iFilteredTotal": oSettings.fnRecordsDisplay(),
                    "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                    "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
                };
            };
        </script>
    </head>

    <body>
        
         <!-- Top Bar Start -->
         <div class="topbar">

            <!-- LOGO -->
            <div class="topbar-left">
                <a href="<?= base_url('') ?>" class="logo">
                    <span>
                        <img src="<?= base_url('assets/admin/') ?>images/logo-sm.png" alt="logo-small" class="logo-sm">
                    </span>
                    <span>ANTRIAN ONLINE</span>
                    <!-- <span>
                        <img src="<?= base_url('assets/admin/') ?>images/logo.png" alt="logo-large" class="logo-lg logo-light">
                        <img src="<?= base_url('assets/admin/') ?>images/logo-dark.png" alt="logo-large" class="logo-lg">
                    </span> -->
                </a>
            </div>
            <!--end logo-->
            <!-- Navbar -->
            <nav class="navbar-custom">    
                <ul class="list-unstyled topbar-nav float-right mb-0"> 
                  
                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle waves-effect waves-light nav-user" data-toggle="dropdown" href="#" role="button"
                            aria-haspopup="false" aria-expanded="false">
                            <?php if($this->session->userdata('avatar')!=base_url()) $img = $this->session->userdata('avatar');
                                    else $img = base_url('assets/admin/images/users/user-1.png')
                            ?>
                            <img src="<?= $img; ?>" alt="profile-user" class="rounded-circle" /> 
                            
                            <span class="ml-1 nav-user-name hidden-sm"> <?= $this->session->userdata('name');?> - <?php $role = $this->mymodel->selectDataone('role',array('id'=>$this->session->userdata('role_id'))); echo $role['role']; ?> <i class="mdi mdi-chevron-down"></i> </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <!-- <a class="dropdown-item" href="#"><i class="ti-user text-muted mr-2"></i> Profile</a>
                            <a class="dropdown-item" href="#"><i class="ti-wallet text-muted mr-2"></i> My Wallet</a>
                            <a class="dropdown-item" href="#"><i class="ti-settings text-muted mr-2"></i> Settings</a>
                            <a class="dropdown-item" href="#"><i class="ti-lock text-muted mr-2"></i> Lock screen</a> -->
                            <div class="dropdown-divider mb-0"></div>
                            <a class="dropdown-item" href="<?= base_url('login/logout') ?>"><i class="ti-power-off text-muted mr-2"></i> Logout</a>
                        </div>
                    </li>
                </ul><!--end topbar-nav-->
    
                <ul class="list-unstyled topbar-nav mb-0">                        
                    <li>
                        <button class="nav-link button-menu-mobile waves-effect waves-light">
                            <i class="ti-menu nav-icon"></i>
                        </button>
                    </li>
                    
                </ul>
            </nav>
            <!-- end navbar-->
        </div>
        <!-- Top Bar End -->

        
        <!-- Left Sidenav -->
        <div class="left-sidenav">
            <ul class="metismenu left-sidenav-menu">
                <li>
                    <a href="javascript: void(0);"><i class="ti-bar-chart"></i><span>Dashboard</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('queue/locket') ?>"><i class="ti-control-record"></i>Layanan Antrian</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('queue/report') ?>"><i class="ti-control-record"></i>Laporan Antrian</a></li> 
                    </ul>
                </li>
            <?php
            if( $role['role']=="Admin"){
            ?>
                <li>
                    <a href="javascript: void(0);"><i class="ti-server"></i><span>Master</span><span class="menu-arrow"><i class="mdi mdi-chevron-right"></i></span></a>
                    <ul class="nav-second-level" aria-expanded="false">
                        
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('master/locket') ?>"><i class="ti-control-record"></i>Loket</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('master/service') ?>"><i class="ti-control-record"></i>Layanan</a></li>
                        <li class="nav-item"><a class="nav-link" href="<?= base_url('master/user') ?>"><i class="ti-control-record"></i>User</a></li>
                        
                    </ul>
                </li> 
                <?php } ?>                  

            </ul>
        </div>
        <!-- end left-sidenav-->

        <div class="page-wrapper">
            <!-- Page Content-->
            <div class="page-content">

               <?= $contents ?>

                <footer class="footer text-center text-sm-left">
                    &copy; 2020 Antrian Online <span class="text-muted d-none d-sm-inline-block float-right">Crafted with <i class="mdi mdi-heart text-danger"></i> by Putri</span>
                </footer><!--end footer-->
            </div>
            <!-- end page content -->
        </div>
        <!-- end page-wrapper -->

        


        <!-- jQuery  -->
        <script src="<?= base_url('assets/admin/') ?>js/bootstrap.bundle.min.js"></script>
        <script src="<?= base_url('assets/admin/') ?>js/metismenu.min.js"></script>
        <script src="<?= base_url('assets/admin/') ?>js/waves.js"></script>
        <script src="<?= base_url('assets/admin/') ?>js/feather.min.js"></script>
        <script src="<?= base_url('assets/admin/') ?>js/jquery.slimscroll.min.js"></script>
        <script src="<?= base_url('assets/admin/') ?>js/jquery-ui.min.js"></script>

        <!-- App js -->
        <script src="<?= base_url('assets/admin/') ?>js/app.js"></script>

        <script>
             $('input[name="daterange"]').daterangepicker({
                opens: 'left'
            }, function(start, end, label) {
                console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
            });

            $(".select2").select2({
                width: '100%'
            });
        </script>
        
    </body>

</html>