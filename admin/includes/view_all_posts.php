<?php  include ("delete_modal.php");  ?>
<h1 class="page-header">
All Posts
</h1>
<?php
if(isset($_POST['checkBoxArray'])){
$bulk_options = escape($_POST['bulk_options']);    
foreach($_POST['checkBoxArray'] as $postValueId){

switch($bulk_options){
        
    case 'published':
        $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} "; 
        $update_to_published_status = mysqli_query($connection, $query);
        break;
        
       case 'draft':
        $query = "UPDATE posts SET post_status = '{$bulk_options}' WHERE post_id = {$postValueId} ";
        $update_to_draft_status = mysqli_query($connection, $query);
        break;
        
        case 'delete':
        $query = "DELETE FROM posts WHERE post_id = {$postValueId} ";
        $update_to_delete_status = mysqli_query($connection, $query);
        break;  
       } } } ?>
<form action="" method="post">
   <table class="table table-bordered table-hover" >
 <div id="bulkOptionContainer" class="col-xs-4"><select name="bulk_options" id="" class="form-control">
         <option value="">Select Options</option>
         <option value="published">publish</option>
         <option value="draft">Draft</option>
         <option value="delete">Delete</option>
     </select>
     </div>
     <div class="col-xs-4">
      <input type="submit" name="submit" value="Apply" class="btn btn-success">
      <a href="./posts.php?source=add_post" class="btn btn-primary">Add New</a>
      </div>  
       <thead>
        <tr>
           <th><input type="checkbox" id="selectAllBoxes"></th>
            <th>Id</th>
            <th>Users</th>
            <th>Title</th>
            <th>Category</th>
            <th>Status</th>
            <th>Image</th>
            <th>Tags</th>
            <th>Comments</th>
            <th>Date</th>
            <th>View</th>
            <th>Views</th>
            <th>Edit</th>
            <th>Delete</th>
        </tr>
    </thead>
    <tbody>
       
       
       <?php
         $username = $_SESSION['username'];
    if(is_admin($_SESSION['username']) == false ){
        $query = "SELECT posts.post_id, posts.post_author, posts.post_user, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, ";
        $query .= "posts.post_tags, posts.post_comment_count, posts.post_date, posts.post_views_count, categories.cat_id, categories.cat_title ";
        $query .= "FROM posts ";
        $query .= "LEFT JOIN categories ON posts.post_category_id = categories.cat_id WHERE post_user = '{$username}' ORDER BY posts.post_id DESC";}
        
    else{
        $query = "SELECT posts.post_id, posts.post_author, posts.post_user, posts.post_title, posts.post_category_id, posts.post_status, posts.post_image, ";
        $query .= "posts.post_tags, posts.post_comment_count, posts.post_date, posts.post_views_count, categories.cat_id, categories.cat_title ";
        $query .= "FROM posts ";
        $query .= "LEFT JOIN categories ON posts.post_category_id = categories.cat_id  ORDER BY posts.post_id DESC";
    }
        
$select_posts = mysqli_query($connection,$query);
confirm($select_posts);
while($row = mysqli_fetch_assoc($select_posts))
{
$post_id = $row["post_id"];
$post_author = $row["post_author"];
$post_user = $row["post_user"];
$post_title = $row["post_title"];
$post_category_id = $row["post_category_id"];
$post_status = $row["post_status"];
$post_image = $row["post_image"];
$post_tags = $row["post_tags"];
$post_comment_count = $row["post_comment_count"];
$post_date = $row["post_date"];
$post_views_count = $row["post_views_count"];
$cat_title = $row["cat_title"];
$cat_id = $row["cat_id"];
echo "<tr>";
?>
<td><input type='checkbox' name='checkBoxArray[]' class='checkBoxes' value='<?php echo $post_id;  ?>'></td>
<?php
echo "<td>$post_id </td>";
    if(!empty($post_author)){
        echo "<td>$post_author</td>";
    } elseif(!empty($post_user)) {
       echo "<td>$post_user</td>";  
    }
 echo "<td>$post_title</td>";
//    
//$query= "SELECT * FROM categories WHERE cat_id = {$post_category_id} ";
//$select_categories_id = mysqli_query($connection,$query);
//while($row = mysqli_fetch_assoc($select_categories_id))
//{
//    
//$cat_id = $row["cat_id"];
//$cat_title = $row['cat_title'];
//    
echo "<td>{$cat_title}</td>";
//}

    echo "<td>$post_status</td>";
    echo "<td><img class='img-responsive' width='100' src='../images/$post_image' alt='image' ></td>";
    echo "<td>$post_tags</td>";    
    $query = "SELECT * FROM comments WHERE comment_post_id = $post_id ";
    $send_comment_query = mysqli_query($connection, $query);
    $row = mysqli_fetch_array($send_comment_query);
    $comment_id = $row['comment_id'];
    $count_comments = mysqli_num_rows($send_comment_query);
    echo "<td><a href='post_comments.php?id={$post_id}'>$count_comments</a></td>";
    echo "<td>$post_date</td>";
    echo "<td><a class ='btn btn-primary' href='../post.php?p_id=$post_id' >$post_title</a></td>";
    echo "<td>$post_views_count</td>";
    echo "<td><a class ='btn btn-info' href='posts.php?source=edit_post&p_id={$post_id}'>Edit</a></td>";
//    echo "<td><a onClick=\" javascript: return confirm('Are you sure you want to delete'); \"  href='posts.php?delete={$post_id}'>Delete</a></td>";
    ?>
    <form action="" method="post">  
        <input type="hidden" name="post_id" value="<?php echo $post_id ?>"> 
        <?php echo '<td><input type="submit" class="btn btn-danger" value="Delete" name="delete"></td>'; ?>
    </form>
    <?php 
//     echo "<td><a rel='{$post_id}' class='delete_link' href='javascript:void(0)' >Delete</a></td>";
    echo "</tr>";
} ?>
</tbody>
<?php
    if(isset($_POST['delete'])){
       $the_post_id = escape($_POST['post_id']);
        $query = "DELETE FROM posts WHERE post_id = {$the_post_id} ";
        $delete_query = mysqli_query($connection, $query);
        header("Location: posts.php?source=posts.php");
    } ?>
</table>
</form>
<script>
$(document).ready(function(){
$(".delete_link").on('click', function(){
var id = $(this).attr("rel");
var delete_url = "posts.php?delete="+ id +" ";
$(".modal_delete_link").attr("href", delete_url);
$("#myModal").modal('show'); }); });
</script>