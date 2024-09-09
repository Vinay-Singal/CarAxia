<header>
  <!-- double header if you want paste code of header2 -->
  
  <!-- Navigation -->
  <nav id="navigation_bar" class="navbar navbar-default">
    <div class="container">
      <div class="navbar-header">
        <!-- Add CarAxia text -->
        <a class="navbar-brand" href="#" style="color: white; font-family: 'Sofia', sans-serif; position: relative;">
  <span style="color: white; text-decoration: none;">
    <span style="color: red;">C</span>a
    <span style="color: white;">r</span>
    <span style="color: red;">A</span>
    <span style="color: white;">xi</span>
    <span style="color: red;">a</span>
  </span>
  <svg viewBox="0 0 100 10" preserveAspectRatio="none" style="position: absolute; bottom: -2px; left: 0; width: 100%;">
    <path d="M0,10 C10,10 30,0 50,10 A70,0 90,10 100,0" stroke="url(#grad)" stroke-width="2" fill="none" />
    <defs>
      <linearGradient id="grad" x1="0%" y1="0%" x2="100%" y2="0%">
        <stop offset="0%" style="stop-color:red;stop-opacity:1" />
        <stop offset="20%" style="stop-color:orange;stop-opacity:1" />
        <stop offset="40%" style="stop-color:yellow;stop-opacity:1" />
        <stop offset="60%" style="stop-color:green;stop-opacity:1" />
        <stop offset="80%" style="stop-color:blue;stop-opacity:1" />
        <stop offset="100%" style="stop-color:white;stop-opacity:1" />
      </linearGradient>
    </defs>
  </svg>
</a>
        <button id="menu_slide" data-target="#navigation" aria-expanded="false" data-toggle="collapse" class="navbar-toggle collapsed" type="button"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      </div>
      <div class="header_wrap">
        <div class="user_login">
          <ul>
            <li class="dropdown"> <a href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fa fa-user-circle" aria-hidden="true"></i> 
              <?php 
                $email=@$_SESSION['login'];
                $sql ="SELECT FullName FROM tblusers WHERE EmailId=:email ";
                $query= $dbh->prepare($sql);
                $query->bindParam(':email', $email, PDO::PARAM_STR);
                $query->execute();
                $results=$query->fetchAll(PDO::FETCH_OBJ);
                if($query->rowCount() > 0) {
                  foreach($results as $result) {
                    echo htmlentities($result->FullName);
                  }
                }
              ?>
              <i class="fa fa-angle-down" aria-hidden="true"></i></a>
              <ul class="dropdown-menu">
                <?php if(!empty($_SESSION['login'])) { ?>
                  <li><a href="profile.php">Profile Settings</a></li>
                  <li><a href="update-password.php">Update Password</a></li>
                  <li><a href="my-booking.php">My Booking</a></li>
                  <li><a href="post-testimonial.php">Post a Testimonial</a></li>
                  <li><a href="my-testimonials.php">My Testimonial</a></li>
                  <li><a href="logout.php">Sign Out</a></li>
                <?php } else { ?>
                  <li id="loginTrigger"><a href="#loginform" data-toggle="modal" data-dismiss="modal">Login</a></li>
                  <li><a href="#signupform" data-toggle="modal" data-dismiss="modal">Register</a></li>
                <?php } ?>
              </ul>
            </li>
          </ul>
        </div>
        <div class="header_search">
          <div id="search_toggle"><i class="fa fa-search" aria-hidden="true"></i></div>
          <form action="search.php" method="post" id="header-search-form">
            <input type="text" placeholder="Search..." name="searchdata" class="form-control" required="true">
            <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
          </form>
        </div>
      </div>
      <div class="collapse navbar-collapse" id="navigation">
        <ul class="nav navbar-nav">
          <!-- Add Car Listing link -->
          <li><a href="index.php" style="color: white;">Home</a></li>
          <li><a href="page.php?type=aboutus" style="color: white;">About Us</a></li>
          <li><a href="car-listing.php" style="color: white;">Car Listing</a></li>
          <li><a href="page.php?type=faqs" style="color: white;">FAQs</a></li>
          <li><a href="contact-us.php" style="color: white;">Contact Us</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <!-- Navigation end --> 
  
</header>
