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
                        <h1 class="page-header">
                            Welcome to Adminstration
                            <small><?php echo $_SESSION['username']; ?></small>
                        </h1>
                    </div>
                </div>
                <!-- /.row -->
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-file-text fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">

                

                    <div class='huge'> <?php echo $post_counts = recordCount('posts'); ?> </div>
                    

                        <div>Posts</div>
                    </div>
                </div>
            </div>
            <a href="posts.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">

            
                        <div class='huge'><?php echo $comment_counts = recordCount('comments'); ?></div>
                     
                        
                      <div>Comments</div>
                    </div>
                </div>
            </div>
            <a href="comments.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    
    <?php           
       if(is_admin($_SESSION['username']) == true )
            {
      ?>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                    
                               <div class='huge'><?php echo $user_counts = recordCount('users'); ?></div>
                  
                        
                        
                        <div> Users</div>
                    </div>
                </div>
            </div>
            <a href="users.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    

    
    
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-list fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">

                
                   
                            <div class='huge'><?php echo $categories_counts  = recordCount('categories'); ?></div>
                  
                        
                         <div>Categories</div>
                    </div>
                </div>
            </div>
            <a href="categories.php">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    
        <?php  } ?>
    
    
    
</div>
                <!-- /.row -->
                
        <?php

        $user_role = $_SESSION['user_role'];        
        $username = $_SESSION["username"] ;        
                

        
        if($user_role == 'admin')
        {
        $query_published = "SELECT * FROM posts WHERE post_status = 'published' ";
        $query_draft = "SELECT * FROM posts WHERE post_status = 'draft' ";        
        $query_unapprove = "SELECT * FROM comments WHERE comment_status = 'unapproved' ";                                      
        $query_subscriber = "SELECT * FROM users WHERE user_role = 'subscriber' ";     
        }
        
        elseif($user_role == 'subscriber')
        {
            
        $query_published = "SELECT * FROM posts WHERE post_status = 'published' AND post_user = '{$username}' ";
        $query_draft = "SELECT * FROM posts WHERE post_status = 'draft' AND post_user = '{$username}' ";
            
        $query = "SELECT post_id FROM posts WHERE post_user =  '{$username}' ";
        $select_post_user_query = mysqli_query($connection, $query);
        $row = mysqli_fetch_array($select_post_user_query);
        $post_comment_id = $row['post_id'];

            
            
        $query_unapprove = "SELECT * FROM comments WHERE comment_status = 'unapproved' AND comment_post_id = {$post_comment_id} ";                                      
        $query_subscriber = "SELECT * FROM users WHERE user_role = 'subscriber' AND username = '{$username}' ";   
            
            
        }
                
                
        $select_all_published_posts = mysqli_query($connection, $query_published);
        $post_published_counts = mysqli_num_rows($select_all_published_posts);
                

       
        $select_all_draft_posts = mysqli_query($connection, $query_draft);
        $post_draft_counts = mysqli_num_rows($select_all_draft_posts);


        
        $unapproved_comments = mysqli_query($connection, $query_unapprove);
        $unapproved_comment_counts = mysqli_num_rows($unapproved_comments);

   
        $select_all_subscribers = mysqli_query($connection, $query_subscriber);
        $subscribers_counts = mysqli_num_rows($select_all_subscribers );



        ?>
                
                
                
                
                <div class="row">
                    
      <script type="text/javascript">
      google.charts.load('current', {'packages':['bar']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Date', 'Count'],
            
            <?php
            
              
       if(is_admin($_SESSION['username']) == false )
            {

            $username = $_SESSION['username'] ;
       
       
            $elememt_text = ['All Post', 'Active Posts', 'Draft_Posts', 'Comments', 'Pending Comments'];
            
            $elememt_count = [$post_counts, $post_published_counts, $post_draft_counts, $comment_counts, $unapproved_comment_counts];
            
            
            for( $i = 0; $i < 5 ; $i++ ) {
             echo "['{$elememt_text[$i]}'" . ",". " {$elememt_count[$i]}],";   
                
            }
       
       
       
           }
            
            
            
            
            
            else
            {
          
            
            $elememt_text = ['All Post', 'Active Posts', 'Draft_Posts', 'Comments', 'Pending Comments', 'Users', 'Subscribers', 'Categories'];
            
            $elememt_count = [$post_counts, $post_published_counts, $post_draft_counts, $comment_counts, $unapproved_comment_counts, $user_counts, $subscribers_counts, $categories_counts];
            
            
            for( $i = 0; $i < 7 ; $i++ ) {
             echo "['{$elememt_text[$i]}'" . ",". " {$elememt_count[$i]}],";   
                
            }
            }
 
            ?>
            
            
            
//          ['Post', 1000]
        
        ]);

        var options = {
          chart: {
            title: '',
            subtitle: '',
          }
        };

        var chart = new google.charts.Bar(document.getElementById('columnchart_material'));

        chart.draw(data, google.charts.Bar.convertOptions(options));
      }
    </script>  
                    
                    
    <div id="columnchart_material" style="width: 'auto'; height: 500px;"></div>                
                    
                    
                </div>
                
           
                
                     
                               
                
                
                
                
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

   <?php include "includes/admin_footer.php" ?>