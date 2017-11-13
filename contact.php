<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
  <?php  include "admin/functions.php"; ?>
 
<?php

if(isset($_POST['submit'])){
    

    $to = "avinash.7355@gmail.com";
    $subject = wordwrap($_POST['subject'], 70);
    $body = $_POST['body'];
    $header = "From: ". $_POST['email'];
    

    mail($to, $subject, $body, $header);
    
    
}


?> 


    <!-- Navigation -->
    
    <?php  include "includes/navigation.php"; ?>
    
 
    <!-- Page Content -->
    <div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1>Contact Form</h1>
                    <form role="form" action="" method="post" id="login-form" autocomplete="off">
                       <h6 class="text-center"></h6>
                       
                       
                           <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email"  class="form-control" placeholder="somebody@example.com">
                        </div>
                
                         <div class="form-group">
                            <label for="text" class="sr-only">Subject</label>
                            <input type="text" name="subject" class="form-control" placeholder="Enter Subject">
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            
                            <textarea class="form-control" name="body" id=""  rows="10"></textarea>
                            
                            
                        </div>
                
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Submit">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
