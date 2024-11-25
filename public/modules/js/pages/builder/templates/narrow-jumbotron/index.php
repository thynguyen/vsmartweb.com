<?php
$http = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')?"https://":"http://";
?>
<!DOCTYPE html>
<html>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <!-- Bootstrap core CSS -->
    <link href="<?php echo $http.$_SERVER['HTTP_HOST'] ?>/modules/js/pages/builder/css/editor.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo $http.$_SERVER['HTTP_HOST'] ?>/modules/js/pages/builder/templates/narrow-jumbotron/narrow-jumbotron.css" rel="stylesheet">
  </head>
	
  <body>

      <header class="header clearfix container" id="top-header">
        <nav>
          <ul class="nav nav-pills float-right">
            <li class="nav-item">
              <a class="nav-link active" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="#">Contact</a>
            </li>
          </ul>
        </nav>
        <h3 class="text-muted">Project name</h3>
      </header>

      <section class="jumbotron container" id="jumbotron">
        <h1 class="display-3">Jumbotron heading</h1>
        <p class="lead">Cras justo odio, dapibus ac facilisis in, egestas eget quam. Fusce dapibus, tellus ac cursus commodo, tortor mauris condimentum nibh, ut fermentum massa justo sit amet risus.</p>
        <p><a class="btn btn-lg btn-success" href="#" role="button">Sign up today</a></p>
      </section>

      <section class="container" id="marketing">
		  <div class="row marketing">
			<div class="col-lg-6">
			  <h4>Subheading</h4>
			  <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>

			  <h4>Subheading</h4>
			  <p>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>

			  <h4>Subheading</h4>
			  <p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
			</div>

			<div class="col-lg-6" >
			  <h4>Subheading</h4>
			  <p>Donec id elit non mi porta gravida at eget metus. Maecenas faucibus mollis interdum.</p>

			  <h4>Subheading</h4>
			  <p data-vvveb-disabled>Morbi leo risus, porta ac consectetur ac, vestibulum at eros. Cras mattis consectetur purus sit amet fermentum.</p>

			  <h4>Subheading</h4>
			  <p>Maecenas sed diam eget risus varius blandit sit amet non magna.</p>
			</div>
		  </div>
      </section>

      <footer class="footer container" id="page-footer">
        <p>© Company 2017</p>
      </footer>


</body>
</html>
