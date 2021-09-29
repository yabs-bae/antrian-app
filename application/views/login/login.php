<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="utf-8" />
        <title>ANTRIAN ONLINE | Login</title>
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
        <link href="<?= base_url('assets/admin/') ?>css/app.min.css" rel="stylesheet" type="text/css" />

    </head>

    <body class="account-body ">

        <!-- Log In page -->
        <div class="container">
            <div class="row vh-100 ">
                <div class="col-12 align-self-center">
                    <div class="auth-page">
                        <div class="card auth-card shadow-lg">
                            <div class="card-body">
                                <div class="px-3">
                                   
                                    <div class="text-center auth-logo-text">
                                        <h4 class="mt-0 mb-3 mt-5">Antrian Web-apps</h4>
                                        <p class="text-muted mb-0">Sign in to continue to web apps.</p>  
                                    </div> <!--end auth-logo-text-->  
    
                                    
                                    <form class="form-horizontal auth-form my-4" action="<?= base_url('login/act_login')?>" method="post" id="upload">
                                    <div class="show_error" style="margin-bottom:10px">
                                    </div>
                                        <div class="form-group">
                                            <label for="username">Username</label>
                                            <div class="input-group mb-3">
                                                <span class="auth-form-icon">
                                                    <i class="dripicons-user"></i> 
                                                </span>                                                                                                              
                                                <input type="text" class="form-control" name="username" id="username" placeholder="Enter username">
                                            </div>                                    
                                        </div><!--end form-group--> 
            
                                        <div class="form-group">
                                            <label for="userpassword">Password</label>                                            
                                            <div class="input-group mb-3"> 
                                                <span class="auth-form-icon">
                                                    <i class="dripicons-lock"></i> 
                                                </span>                                                       
                                                <input type="password" class="form-control" name="password" id="userpassword" placeholder="Enter password">
                                            </div>                               
                                        </div><!--end form-group--> 
            
                                       
            
                                        <div class="form-group mb-0 row">
                                            <div class="col-12 mt-2">
                                                <button class="btn btn-gradient-primary btn-round btn-block waves-effect waves-light" type="submit" id="send-btn">Log In <i class="fas fa-sign-in-alt ml-1"></i></button>
                                                <button class="btn btn-gradient-success btn-round btn-block waves-effect waves-light" type="button" onclick="location.href='<?= base_url('queue') ?>'">Halaman Antrian <i class="fas fa-users ml-1"></i></button>
                                            </div><!--end col--> 
                                        </div> <!--end form-group-->                           
                                    </form><!--end form-->
                                </div><!--end /div-->
                                
                              
                            </div><!--end card-body-->
                        </div><!--end card-->
                        
                    </div><!--end auth-page-->
                </div><!--end col-->           
            </div><!--end row-->
        </div><!--end container-->
        <!-- End Log In page -->

        


        <!-- jQuery  -->
        <script src="<?= base_url('assets/admin/') ?>js/jquery.min.js"></script>
        <script src="<?= base_url('assets/admin/') ?>js/jquery-ui.min.js"></script>
        <script src="<?= base_url('assets/admin/') ?>js/bootstrap.bundle.min.js"></script>
        <script src="<?= base_url('assets/admin/') ?>js/metismenu.min.js"></script>
        <script src="<?= base_url('assets/admin/') ?>js/waves.js"></script>
        <script src="<?= base_url('assets/admin/') ?>js/feather.min.js"></script>
        <script src="<?= base_url('assets/admin/') ?>js/jquery.slimscroll.min.js"></script>        

        <!-- App js -->
        <script src="<?= base_url('assets/admin/') ?>js/app.js"></script>
        <script type="text/javascript">
            $("#upload").submit(function(){
                var mydata = new FormData(this);
                var form = $(this);
                $.ajax({
                    type: "POST",
                    url: form.attr("action"),
                    data: mydata,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend : function(){
                        $("#send-btn").addClass("disabled").html("<i class='fa fa-spinner fa-spin'></i>  Send...");
                        form.find(".show_error").slideUp().html("");
                    },
                        success: function(response, textStatus, xhr) {
                        var str = response;
                        if (str.indexOf("oke") != -1){
                            document.getElementById('upload').reset();
                            $("#send-btn").removeClass("disabled").html("Sign in");
                            location.href = '<?= base_url("/") ?>';
                        }else{
                            $("#send-btn").removeClass("disabled").html("Sign in");
                            form.find(".show_error").hide().html(response).slideDown("fast");
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) {
                    }
                });
                return false;
                });
            </script>
    </body>

</html>