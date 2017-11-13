<?php   

if(isset($_SESSION['user_role']))
{
    $user_role = $_SESSION['user_role'];
    
    if($user_role != 'admin')
    {
     
        header("Location: ./index.php ");
    
    }
    
}

?>
   




<?php    
if(isset($_POST['create_user']))
{
 

   $user_firstname = escape($_POST['user_firstname']);
    $user_lastname = escape($_POST['user_lastname']);
    $user_role = escape($_POST['user_role']);

//    $post_image = $_FILES['image']['name'];
//    $post_image_temp = $_FILES['image']['tmp_name'];
    
    $username = escape($_POST['username']);
    $user_email = escape($_POST['user_email']);
    $user_password = escape($_POST['user_password']);
    //$user_date = date('d-m-y');
//    $post_comment_count = 4;   
    
    
    //function for image
    
//    move_uploaded_file($post_image_temp,"../images/$post_image");
    
            
    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10) );
       
    
    
    

$query =  "INSERT INTO users(user_firstname, user_lastname, user_role, username, user_email, user_password, user_date) " ;
    
    $query .= "VALUES ('{$user_firstname}', '{$user_lastname}', '{$user_role}', '{$username}', '{$user_email}', '{$user_password}', now()) ";
    
    $create_user_query= mysqli_query($connection, $query);
    
  confirm($create_user_query);
    echo " User Created ";
    header("Location: ./users.php");

}

?>
    

    
    <form action="" method="post" enctype="multipart/form-data">

    <div class="form-group">
    <label for="user_firstname">Firstname</label>
    <input type="text" class="form-control" name="user_firstname">
    </div>
    
    <div class="form-group">
    <label for="user_lastname">Lastname</label>
    <input type="text" class="form-control" name="user_lastname">
    </div>
    
 
     
   <div class="form-group">
    <select name="user_role"  class ='btn btn-primary' data-style="btn-primary"  id="">
    <option value="Subscriber">Select Option</option>
    <option value="admin">Admin</option>
    <option value="subscriber">Subscriber</option>
   
    </select>
    </div>
    
    
     
 
<!--
    <div class="form-group">
    <label for="image">Post Image</label>
    <input type="file" name="image">
    </div>
-->
    
    <div class="form-group">
    <label for="username">Username</label>
    <input type="text" class="form-control" name="username">
    </div>
    
    <div class="form-group">
    <label for="user_email">Email</label>
    <input type="email" class="form-control" name="user_email">
    </div>
    
     <div class="form-group">
    <label for="user_email">Password</label>
    <input type="password" class="form-control" name="user_password">
    </div>
    
    <div class="form-group">
    <input type="submit" class="btn btn-primary" name="create_user" value="Add User">
    </div>
</form>