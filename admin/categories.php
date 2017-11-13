<?php  include "includes/admin_header.php" ?>

<?php if(!is_admin($_SESSION['username']))
{
    redirect('index.php');
}
?>


<div id="wrapper">

<!-- Navigation -->

<?php  include "includes/admin_navigation.php" ?>

<!--       navigation end-->

<div id="page-wrapper">

<div class="container-fluid">

<!-- Page Heading -->
<div class="row">
<div class="col-lg-12">


<h1 class="page-header">
Add Categories
<small></small>
</h1>

<div class="col-xs-6">


<?php
insert_categories();
?>


<form action="categories.php" method="post">

<div class="form-group">
<label for="cat_title"> Category</label>
<input type="text" class="form-control" name="cat_title"></div>


<div class="form-group">
<input type="submit" class="btn btn-primary"  name="submit" value="Add Category">
</div>

</form>


<?php //Update and Include QUERY

if(isset($_GET["edit"]))
{
    
$cat_title = $_GET["edit"];
include "includes/update_categories.php";
    
}

?>
</div>

<div class="col-xs-6">
<!--Add Categorey-->



<table class="table table-bordered table-hover">
<thead>
<tr>
<th>Id</th>
<th>Category Title</th>
<th>Delete</th>
<th>Edit</th>
</tr>
</thead>
<tbody>



<?php //find all category query

    
    findAllCategories();

echo "<tr>";   

?>



<?php

//Delete Query
deleteCategories();


?>


</tbody>
</table>
</div>





</div>
</div>
<!-- /.row -->

</div>
<!-- /.container-fluid -->

</div>
<!-- /#page-wrapper -->

<?php include "includes/admin_footer.php" ?>
