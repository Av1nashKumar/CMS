</form>

<form action="" method="post">
<div class="form-group">
<label for="cat_title">Edit Category</label>

<?php


if(isset($_GET['edit']))
{
$cat_id= escape($_GET['edit']);

$query= "SELECT * FROM categories WHERE cat_id = $cat_id ";

$select_categories = mysqli_query($connection,$query);

while($row = mysqli_fetch_assoc($select_categories))
{

$cat_id = $row["cat_id"];
$cat_title = $row["cat_title"];    
?>

<input  value ="<?php  if(isset($_GET['edit'])){echo $cat_title; } ?>"   type="text" class="form-control" name="cat_title">

<?php } } ?>


<?php     

//Update Query


if(isset($_POST["update_category"])){

$the_cat_title = escape($_POST["cat_title"]);

$query = " UPDATE categories SET cat_title = '{$the_cat_title}' WHERE cat_id = {$cat_id} ";
$update_query = mysqli_query($connection,$query);
if(!$update_query)
{
die("Query FAILED".mysqli_error($connection));
}

} ?>

</div>

<div class="form-group">
<input type="submit" class="btn btn-primary"  name="update_category" value="Update"></div>

</form>