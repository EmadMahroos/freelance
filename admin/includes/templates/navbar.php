
            <div class="pagehead container">
                <div class="row">
                    <div class="col-lg-2 col-md-4  col-sm-3 col-xl-2 col-3 logo">
                        <img src="600px-Volkswagen_logo_2019.svg.png"/>
                    </div>
             
                        <?php
                            if(isset($_SESSION['user'])){
                                    $email=$_SESSION['user'];
                                   $rows=  getTable("*","clients","where email = '$email'");
                                   $client_id=$rows[0]['client_id'];
                        
                        ?>
                        
                    <div class="col-lg-8 col-md-4  col-sm-5 col-xl-8 col-5 ">
                        <div class="profile-logo-div">
                          <ul class="profile-logo">
                            <li>
                              <img src="uploads/imgs/<?php echo $rows[0]['logo'];?>"/>
                              <ul class="profile-logo-options">
                                <li><a href="clients.php?do=edit&client_id=<?php echo $client_id ;?>"><?php echo $rows[0]['client_name']?></a></li>
                                <li><a href="../">visit shop</a></li>
                                <li><a href="logout.php">log out</a></li>
                              </ul>                            
                            </li>
                          </ul>
                       </div>
                    
                    </div>
                    <?php }else{?>
                    <div class="col-lg-2 col-md-4  col-sm-4 col-xl-2 col-4 offset-lg-8 offst-md-4 offset-sm-5 offset-xl-8 offset-5 login-div ">
                      <a href="login.php">log in | sign up</a>
                    </div>
                    <?php }?>

                    
                </div>
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark  ">
                  <a class="navbar-brand" href="index.php"><i class="fa fa-home"></i></a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                      <li class="nav-item active">
                        <a class="nav-link" href="clients.php?do=manage">clients <span class="sr-only">(current)</span></a>
                      </li>                    
                     <li class="nav-item dropdown active">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                          jobs
                        </a>
                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                          <a class="dropdown-item" href="jobs.php?do=manage">jobs under working</a>
                          <a class="dropdown-item" href="jobs.php?do=pending">not activated jobs </a>
                          <a class="dropdown-item" href="jobs.php?do=finished_jobs">finished jobs </a>
                        </div>
                     </li>
                      <li class="nav-item active">
                        <a class="nav-link" href="comments.php?do=manage">comments <span class="sr-only">(current)</span></a>
                      </li>  
                      <li class="nav-item active">
                        <a class="nav-link" href="contacts.php">contacts <span class="sr-only">(current)</span></a>
                      </li> 
                    
                
                    </ul>
                    <form class="form-inline my-2 my-lg-0" action="search.php" method="POST">
                      <select class="form-control mr-sm-2" name="category">
                        <option value="">choose category</option>
                        <option value="users"> users </option>
                        <option value="finished_jobs"> finished jobs</option>
                        <option value="jobs"> not finished jobs</option>
                        <option value="contacts"> contacts</option>
                        <option value="comments"> comments</option>
                        <option value="feedbacks"> feedbacks</option>
                        
                      </select>                        
                      <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search" name="search">
                      <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="submit_search">Search</button>
                    </form>
                  </div>
                </nav>
            </div>
             


