
            <div class="pagehead container">
                <div class="row sm-head">
                    <div class="col-3 logo">
                        <img src="admin/uploads/imgs/600px-Volkswagen_logo_2019.svg.png"/>
                    </div>
             
                        <?php
                        if(isset($_SESSION['client'])||isset($_SESSION['user']))
                        {
                                    if(isset($_SESSION['client']))
                                    {
                                                $email=$_SESSION['client'];
                                                

                                    }
                                    
                                    if(isset($_SESSION['user']))
                                    {
                                                $email=$_SESSION['user'];

                                    }
                                   $rows=  getTable("*","clients","where email = '$email'");
                                   $client_id=$rows[0]['client_id'];
                                   $logo = $rows[0]['logo'];
                        
                                    ?>
                                    
                                <div class="col-5  user">
                                    <div class="profile-logo-div">
                                      <ul class="profile-logo " style="padding: 0px;">
                                        <li class="pf-li">
                                          <img src="admin/uploads/imgs/<?php echo $logo?>"/>
                                          <ul class="profile-logo-options">
                                            <li><a href="profiles.php?client_id=<?php echo $client_id ;?>"><?php echo $rows[0]['client_name']?></a></li>
                                            
                                            <li><a href="logout.php">log out</a></li>
                                          </ul>                            
                                        </li>
                                      </ul>
                                   </div>
                                </div>                         
                                    <div class="col-3 not">
                                                <i class="far fa-bell notifications"><span class="notifications_num"></span></i>
                                                <span class="notifications_content"></span>
                                                <i class="fas fa-sms sms"> <span class="sms_num"></span></i>
                                                <span class="sms_content"></span>

                                                <div class="notifications_shower"></div>
                                                <div class="sms_shower"></div>
                                    </div>
                                                                    
                                <?php
                        }           
                        else
                        {
                                    ?>
                                    <div class="col-9 login-div ">
                                                <a href="login.php">log in | sign up</a>
                                    </div>
                                    
                                    <?php
                        }
                        ?>

                    
                </div>
                      
                <nav class="navbar navbar-expand-lg navbar-dark bg-dark  ">
                  <a class="navbar-brand" href="index.php"><i class="fa fa-home"  data-sender="<?php echo $client_id?>"></i></a>
                  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                  </button>
                
                  <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                      <li class="nav-item active">
                        <a class="nav-link" href="jobs.php?do=manage">jobs <span class="sr-only">(current)</span></a>
                      </li>
                      <li class="nav-item active">
                        <a class="nav-link" href="#contact_us">Contact Us <span class="sr-only">(current)</span></a>
                      </li>
                      <li class="nav-item active">
                        <a class="nav-link" href="job_details.php"> make your job <span class="sr-only">(current)</span></a>
                      </li>                      
                      <?php
                        if(isset($_SESSION['client'])||isset($_SESSION['user']))
                        {                      
                      ?>
                      <li class="nav-item active">
                        <a class="nav-link" href="profiles.php?client_id=<?php echo $client_id ;?>">My Profile<span class="sr-only">(current)</span></a>
                      </li>
                      <?php
                      }
                      ?>
                    </ul>
                    <form class="form-inline my-2 my-lg-0" action="search.php" method="POST">
                      <select class="form-control mr-sm-2" name="category">
                        <option value="">choose category</option>
                        <option value="admins"> admins </option>
                      <?php
                        if(isset($_SESSION['user']))
                        {                                
                      ?>
                        <option value="users_s"> users</option>
                      <?php
                      }
                      ?>                      
                        <option value="websites"> websites</option>
                      </select>
                      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="search">
                      <button class="btn btn-outline-success my-2 my-sm-0" type="submit" name="submit_search">Search</button>
                      
                    </form>
                  </div>
                </nav>
            </div>
             


