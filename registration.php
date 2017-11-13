<?php  include "includes/db.php"; ?>
 <?php  include "includes/header.php"; ?>
  <?php  include "admin/functions.php"; ?>
 
 <?php
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  
    
    
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    
    
    
    $errors = [
        
      'username'=>'',
        'email'=>'',
        'password'=>''
        
        
    ];
    
    
        if(strlen($username) < 4){
        
        $errors['username'] = "Username needs to be Longer than 4 Character";
    }
      if(empty($username))
    {
         $errors['username'] = "Username can't be Empty";
        
    }
    

    

  
    
    if(username_exists($username)){
        
        $errors['username'] = "Username Already exist";
        
    }
    
 
    
    if($email == '')
    {
         $errors['email'] = "Email can't be Empty";
        
    }
    
    if(email_exists($email)){
        
        $errors['email'] = "Username Already exist <a href='index.php' >Please Login</a>";
        
    }
    

    if(strlen($password) < 4){
        
        $errors['password'] = "Password needs to be Longer than 4 Character";
    }
    
    if(empty($password))
    {
         $errors['password'] = "Password can't be Empty";
        
    }
 
    
    foreach($errors as $key => $value){
        
        if(empty($value)){
        unset($errors[$key]);
            
        }
       
    } // for each

    
    if(empty($errors)){
        
    register_user($username, $email, $password);  
    login_user($username, $password);
        
    }
    
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
                <h1>Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                   
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" autocomplete="on"  value= "<?php echo isset($username) ? $username : '' ?>" >
                     
                        
                          </div>
                        
                          <p>
                            
                          <?php echo isset($errors['username']) ? $errors['username'] : '' ?>  
                            
                        </p>
                        
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com"
                            autocomplete="on"
                             value= "<?php echo isset($email) ? $email : '' ?>">
                      
                             
                        </div>
                                   <p>
                            
                          <?php echo isset($errors['email']) ? $errors['email'] : '' ?>  
                            
                        </p>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                        </div>
                            <p>
                            
                          <?php echo isset($errors['password']) ? $errors['password'] : '' ?>  
                            
                        </p>
                
                        <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>


        <hr>



<?php include "includes/footer.php";?>
