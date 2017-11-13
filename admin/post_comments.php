<?php  include "includes/admin_header.php" ?>




<div id="wrapper">

<!-- Navigation -->

<?php  include "includes/admin_navigation.php" ?>

<!--       navigation end-->

<div id="page-wrapper">

<div class="container-fluid">

<!-- Page Heading -->
<div class="row">                                                                                                                                           
<div class="col-lg-12">


<?php   
    
    if(isset($_GET['id'])){
        
    $the_post_id = $_GET['id'];
        
    $query = "SELECT * FROM posts WHERE post_id = {$the_post_id} ";
    $select_post_Author_query = mysqli_query($connection, $query);
    $row = mysqli_fetch_assoc($select_post_Author_query);
        
    $author = $row['post_author'];
        
    }
    
    
    ?>


<h1 class="page-header">
Comments 
<small>on <?php echo $author; ?> post</small>
</h1>

   

   <table class="table table-bordered table-hover" >
    <thead>
        <tr>
            <th>Id</th>
            <th>Author</th>
            <th>Comments</th>
            <th>Email</th>
            <th>Status</th>
            <th>In Response to</th>
              <th>Date</th>
            <th>Approve</th>
            <th>Unapprove</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
       
       
       <?php
       
    
$query= "SELECT * FROM comments WHERE comment_post_id =". mysqli_real_escape_string($connection, $_GET['id']) . " ";
        
$select_comment = mysqli_query($connection,$query);
while($row = mysqli_fetch_assoc($select_comment))
{
$comment_id = $row["comment_id"];
$comment_post_id = $row["comment_post_id"];
$comment_author = $row["comment_author"];
$comment_content = $row["comment_content"];
$comment_email = $row["comment_email"];
$comment_status = $row["comment_status"];
$comment_date = $row["comment_date"];


echo "<tr>";
echo "<td>$comment_id</td>";
    echo "<td>$comment_author</td>";
    echo "<td>$comment_content</td>";

    
//    
//$query= "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
//$select_categories_id = mysqli_query($connection,$query);
//while($row = mysqli_fetch_assoc($select_categories_id))
//{
//    
//$cat_id = $row["cat_id"];
//$cat_title = $row['cat_title'];
//    
//echo "<td>{$cat_title}</td>";
//    
//}
//    
    
    
    
    

    echo "<td>$comment_email </td>";
    echo "<td>$comment_status</td>";
    
    $query = "SELECT * FROM posts WHERE post_id = $comment_post_id ";
    $select_post_id_query = mysqli_query($connection, $query);
    while($row = mysqli_fetch_assoc($select_post_id_query))
    {
        $post_id = $row['post_id'];
        $post_title = $row['post_title'];
        
         echo "<td><a href='../post.php?p_id=$post_id' >$post_title</a></td>";
        
    }
    
    
    
   
    
    
    
    
    
    
    
    echo "<td>$comment_date </td>";
        echo "<td><a href='post_comments.php?approve={$comment_id}&id=" . $_GET['id'] ."'>Approve</a></td>";
    echo "<td><a href='post_comments.php?unapprove={$comment_id}&id=" . $_GET['id'] ."'>UnApprove</a></td>";
    
    echo "<td><a  onClick=\" javascript: return confirm('Are you sure you want to delete'); \"   href=' post_comments.php?delete={$comment_id}&id=" . $_GET['id'] . "'>Delete</a></td>";

echo "</tr>";
}
    

    ?>
       
  
    
    </tbody>
    </table>
    
    
    <?php


      if(isset($_GET['approve']))
    {
       $the_comment_id = $_GET['approve'];
        $the_post_id = $_GET['id'];
        $query = "UPDATE comments SET comment_status = 'approved' where comment_id = {$the_comment_id} ";
        
        $approve_comment_query = mysqli_query($connection, $query);
        header("Location: post_comments.php?id={$the_post_id}" );
    }
    




        if(isset($_GET['unapprove']))
    {
       $the_comment_id = $_GET['unapprove'];
            $the_post_id = $_GET['id'];
        
        $query = "UPDATE comments SET comment_status = 'unapproved' where comment_id = {$the_comment_id} ";
        
        $unapprove_comment_query = mysqli_query($connection, $query);
        header("Location: post_comments.php?id={$the_post_id}");
    }
    







    if(isset($_GET['delete']))
    {
       $the_comment_id = $_GET['delete'];
        
        $query = "DELETE FROM comments WHERE comment_id = {$the_comment_id} ";
        $delete_query = mysqli_query($connection, $query);
        header("Location: post_comments.php?id={$the_post_id}");
//        $countquery = "UPDATE post SET post_comment_count = post_comment_count -1 ";
//        $countquery .= "WHERE post_id = $the_post_id  ";
//        $update_comment_count = mysqli_query($connection, $countquery); 

    }
    
    
    ?>


</div>
</div>
<!-- /.row -->

</div>
<!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

<?php include "includes/admin_footer.php" ?>
