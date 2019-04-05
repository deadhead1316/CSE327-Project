<?php
    session_start();
    if(isset($_SESSION['username'])){
        include 'dbmanager.php';
        $username=$_SESSION['username'];
        $dp=$_SESSION['dp'];
        $searchuser=$_GET['searchkey'];
        $isFriend = false;
        $requestSent=true;
        $db = new dbmanager();
        $con = $db->dbConnection();
        $details = $db->userInformation($con,$searchuser);
        $friendStatus = $db->searchFriendRequestStatus($con,$username,$searchuser);
        if($friendStatus==1){
          $isFriend=true;
          $searchuserpost=$db->readUserPost($con,$searchuser);
        }elseif($friendStatus==-1){
          $requestSent=false;
        }
    }else{
        header('Location : index.php');
    }
?>
<!doctype html>
<html lang="en">


  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- My CSS LINK -->
    <link rel="stylesheet" type="text/css" href="css/profile.css">
    <title><?php echo $searchuser; ?></title>
    <!-- Adding jquery-->
    <script src="js/jquery-3.3.1.min.js"></script>
    <!--My JavaScript-->
    <script src="js/userprofile.js"></script>

  </head>


  <body>

    <!-- Navbar Start-->
    <nav class="navbar navbar-expand-md bg-dark navbar-dark sticky-top">
      
      <!-- Button For Toggling Navbar -->
      <button class="navbar-toggler" data-toggle="collapse" data-target="#target">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Username and Navbar profile picture generated by php -->
      <span class="navbar-text ml-auto">
          <a href="profile.php">
              <?php echo $username; ?>
          </a>
      </span>
      <a class="navbar-brand "><img id="userImage" src="image/avatar/<?php echo $dp; ?>.png" alt="smoke" width="50px" height="50px"></a>

      <!-- Wrapping the collapse items inside a div -->
      <div class="collapse navbar-collapse" id="target">

        <!-- Search Bar and Search button -->
        <form class="form-inline ml-auto" action="searchusers.php" method="post">
          <input class="form-control mr-sm-2" name = "searchkey" type="search" placeholder="Search" aria-label="Search">
          <button type="btn btn-light my-sm-0" type="submit">Search</button>
        </form>

        <!-- Link List -->
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a href="newsfeed.php" class="nav-link">Newsfeed</a>
          </li>
        </ul>
        <ul class="navbar-nav ">
          <li class="nav-item">
            <a class="nav-link">Strategy</a>
          </li>
        </ul>
        <ul class="navbar-nav">
          <li class="nav-item">
            <a href="logoutprocess.php" class="nav-link">Logout</a>
          </li>
        </ul>
        <!-- End List -->

      </div>
      <!-- End Div -->

    </nav>
    <!-- End Nav -->







    <!-- This div containes all post, image and buttons -->
    <div class="mx-auto col-sm-10 bg-dark text-light" id="container1">

      <!-- Profile Picture -->
      <img src="image/avatar/<?php echo $details['dp']; ?>.png" width="200px" height="200px" alt="Smoke" class="img-thumbnail mx-auto d-block" id="profilePic">

      <!-- Tab Div -->
      <div class="container-fluid">

        <div class="row">
            <?php
                if($isFriend){
                    echo "<div class=\"col text-center tabcol\">Pictures</div>";
                    echo "<div onclick=\"redirectMyProfile()\" class=\"col text-center tabcol\">Profile</div>";
                }elseif (!$requestSent){
                    echo "<div class=\"col text-center tabcol send-request\">Send Request</div>";
                }elseif($requestSent){
                    echo "<div class=\"col text-center tabcol\">Friend Request Sent</div>";
                }

            ?>


        </div>

      </div>
      <!-- Tab Div End -->
      
      


      <!-- Post Div -->
      <div class="container-fluid" id="postdiv">

        <div class="container-fluid">
          <div class="row">
              <h3><b>
                    <?php
                        if($isFriend){
                            echo "Posts of ".$details['username'];
                        }
                    ?>
              </b></h3>
          </div>
        </div>
        <?php
            if(!$isFriend){
                echo "<div class=\"col-sm-12 text-center\">
                <div class=\"col-sm-12\">
                    <h3>".$details['username']."</h3>
                </div>
                <div>
                    <h3>".$details['email']."</h3>
                </div>
                </div>";
            }
        ?>



        

      
      </div>
      <!-- End of Post Div-->






    </div>
    <!-- End of div containing all post, image and buttons -->






    





    <!-- Optional JavaScript -->
    <!-- Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>