<?php

function escape($string)
{
    
    global $connection;
    
  return mysqli_real_escape_string($connection, trim($string));  
    
    
}



function redirect($location){
    
    
   return header("Location: ".$location); 
   
}


function  ifItIsMethod($method = null)
{
    
    if($_SERVER['REQUEST_METHOD'] == strtoupper($method)){
      return true;  
        
    }
    
    return false;
    
    
    
}




function isLoggedIn()
{
    
    if(isset($_SESSION['user_role'])){
        
       return true; 
    }
    
  return false;    
}


function checkIfUserIsLoggedInAndRedirect($redirectLocation=null)
{   
  if(isLoggedIn()){
      
      
      redirect($redirectLocation);
      
  }  

}







function users_online(){
    
    
    if(isset($_GET['onlineusers'])){
        
     global $connection;
        

        if(!$connection)
        {
        session_start();
        include("../includes/db.php");
        }
           
    $session = session_id();
    $time = time();
    $time_out_in_seconds = 05;
    $time_out = $time - $time_out_in_seconds;
    
    
    $query = "SELECT * FROM users_online WHERE session = '{$session}' ";
    $send_query = mysqli_query($connection, $query);
    $count = mysqli_num_rows($send_query);
    
    if($count == NULL){
        
        mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES('$session', '$time' )" );
        
    }
   else{
       
        mysqli_query($connection, "UPDATE users_online SET time = '{$time}' WHERE session = '{$session}' " );
       
   }

         $mysqli_online_query = mysqli_query($connection, "SELECT * FROM users_online WHERE time > '{$time_out}' " );
         echo $count_user = mysqli_num_rows( $mysqli_online_query );

          
        
        
        
    }   //getRequest isset()
        
   
     }
        
        

users_online();



function confirm($result)
{
    global $connection;
        if(!$result)
    {
        die("Query Failed".mysqli_error($connection));
    }
    
}





function insert_categories() 
{
    
    
     global $connection;
    if(isset($_POST['submit']))
{


$cat_title = $_POST['cat_title'];

if($cat_title == "" || empty($cat_title) || strlen($cat_title)<1 ){
echo "This field should not be Empty";
}

else{


$query = "INSERT INTo categories(cat_title) ";

$query .= "VALUE('$cat_title')" ;

$create_category_query = mysqli_query($connection, $query);

if(!$create_category_query)
{
die("Query Failed ".mysqli_error($connection));
}
}

}


}



function findAllCategories()
{
   global $connection;
    
    $query= "SELECT * FROM categories";
$select_categories = mysqli_query($connection,$query);
while($row = mysqli_fetch_assoc($select_categories))
{
$cat_id = $row["cat_id"];
$cat_title = $row["cat_title"];
echo "<tr>";
echo "<td>{$cat_id}</td>";
echo "<td>{$cat_title}</td>";
echo "<td><a href='categories.php?delete={$cat_id}'>Delete</a></td>";
echo "<td><a href='categories.php?edit={$cat_id}'>Edit</a></td>";
}
 
}



function deleteCategories()
{
       global $connection;
if(isset($_GET["delete"])){
$thecat_id = $_GET["delete"];
$value=1;
$query = "DELETE FROM categories WHERE cat_id = {$thecat_id} ";
$delete_query = mysqli_query($connection,$query);
//it gonna refresh for us
    $alterquery = "ALTER TABLE categories AUTO_INCREMENT =$value ";
  $result=  mysqli_query($connection,$alterquery);
header("Location: categories.php");
if(!$result)
{
  die("Query Failed ".mysqli_error($connection));  
}
}
}



function recordCount($table)
{
    global $connection;
    
      $username = $_SESSION['username'] ;
    
    if(is_admin($_SESSION['username']) || $table == 'categories' || $table == 'users' )
    {
        
    $query = "SELECT * FROM ". $table;
        
    }
    
    else
    {
        if($table == 'comments')
        {
      
          
        $query = "SELECT post_id FROM posts WHERE post_user =  '{$username}' ";
        $select_post_user_query = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($select_post_user_query);
        $post_comment_id = $row['post_id'];

        $query= "SELECT * FROM comments WHERE comment_post_id = {$post_comment_id} ";
 
        }
        
        if($table == 'posts')
        {
              $query = "SELECT * FROM posts WHERE post_user = '{$username}' ";
        }
        

        
        
    }
$select_all_posts = mysqli_query($connection, $query);
 $result = mysqli_num_rows($select_all_posts);
    
    confirm($result);
    return $result;
    
    
}


function is_admin($username = '')
{
    global $connection;
    
    
    $query = "SELECT user_role FROM users WHERE username = '$username' ";
    
    $result = mysqli_query($connection, $query);
    confirm($result);
    
    $row = mysqli_fetch_array($result);
    
    if($row['user_role'] == 'admin'){
        
      return true;  
        
    }
    else
    {
        return false;
    }
    
   
    
}






function username_exists($username)
{
    
    global $connection;
    
    
    $query = "SELECT username FROM users WHERE username = '$username' ";
    $result = mysqli_query($connection, $query);
    confirm($result);
    
    if(mysqli_num_rows($result) >0 ){
        return true;
    }
    
    else
    {
        return false;
    }
    
}


function email_exists($email)
{
    
    global $connection;
    
    
    $query = "SELECT user_email FROM users WHERE user_email = '$email' ";
    $result = mysqli_query($connection, $query);
    confirm($result);
    
    if(mysqli_num_rows($result) >0 ){
        return true;
    }
    
    else
    {
        return false;
    }
    
}





function register_user($username, $email, $password){
    
    
    global $connection;

    $username = mysqli_real_escape_string($connection, $username);
    $email = mysqli_real_escape_string($connection, $email);
    $password = mysqli_real_escape_string($connection, $password);
         
    $password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 12) );
       
        
//    
//    $query = "SELECT user_randSalt FROM users";
//    $select_randSalt_query = mysqli_query($connection, $query);
//        
//        if(!$select_randSalt_query){
//            
//            die("Query Failed".mysqli_error($connection));
//        }
//
//       $row = mysqli_fetch_array($select_randSalt_query);
//        
//        $salt = $row['user_randSalt'];
//        $password = crypt($password, $salt);
        
        
        $query = "INSERT INTO users (username, user_email, user_password, user_role, user_date) ";
        $query .= "VALUES('{$username}', '{$email}', '{$password}', 'subscriber',  now() )";
        $register_user_query = mysqli_query($connection, $query);
         
        
        confirm($register_user_query);


    
}




function login_user($username, $password){
    
global $connection;
$username = trim($username);
$password = trim($password);
$username = mysqli_real_escape_string($connection, $username);
$password = mysqli_real_escape_string($connection, $password);
$query = "SELECT * FROM users WHERE username = '{$username}' ";
$select_user_query = mysqli_query($connection, $query);
confirm($select_user_query);
while($row = mysqli_fetch_array($select_user_query)){
       $db_user_id = $row['user_id'];
       $db_username = $row['username'];
       $db_user_password = $row['user_password'];
       $db_user_firstname = $row['user_firstname'];
       $db_user_lastname = $row['user_lastname'];
       $db_user_role = $row['user_role'];
if($username === $db_username &&  password_verify($password,                
       $db_user_password)){  
        $_SESSION["username"] = $db_username;
        $_SESSION["firstname"] = $db_user_firstname;
        $_SESSION["lastname"] = $db_user_lastname;
        $_SESSION["user_role"] = $db_user_role;
        redirect("index.php");
}
else{   
return false;
}
}         
return true;     
}

?>