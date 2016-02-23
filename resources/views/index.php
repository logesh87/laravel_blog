<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Angular-Laravel Blog</title>
        <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.css">
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body ng-app="blogApp">

        <nav class="navbar navbar-inverse navbar-fixed-top">
          <div class="container">
            <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
              <a class="navbar-brand" href="#">Project name</a>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
              <ul class="nav navbar-nav">
                <li ui-sref-active="active"><a ui-sref="home">Home</a></li>
                <li ui-sref-active="active" ><a ui-sref="posts">Blog</a></li>
                <!-- <li><a ui-sref="contact">Contact</a></li>  -->               
                <li ui-sref-active="active"  ng-if="!isAuthenticated()"><a ui-sref="login">Login</a></li>
                <li ui-sref-active="active" ng-if="!isAuthenticated()"><a ui-sref="signup">Sign up</a></li>
                <li ui-sref-active="active"  ng-if="isAuthenticated()"><a ui-sref="logout">Logout</a></li>
              </ul>
            </div><!--/.nav-collapse -->
          </div>
        </nav>

        <div class="container">
            <div class="wrap" ui-view></div>
        </div>        

    </body>

    <!-- Application Dependencies -->
    <script src="node_modules/angular/angular.js"></script>
    <script src="node_modules/angular-ui-router/release/angular-ui-router.js"></script>
    <script src="node_modules/satellizer/satellizer.js"></script>

    <!-- Application Scripts -->
    <script src="scripts/app.js"></script>
    <script src="scripts/authController.js"></script>
    <script src="scripts/userController.js"></script>
    <script src="scripts/postsController.js"></script>
</html>