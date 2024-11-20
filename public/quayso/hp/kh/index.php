<!doctype html>
<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Random Number</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="css/all.min.css">
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<!--  -->
	<div class="container-fluid" id="firework">
		<div class="row">
			<div class="col-sm-10">
				<section id="boxtext">
					<div class="container">
						<div class="showtext">
							  Gala Gold Hunter 2020<br>
						</div>
					</div>
				</section>
				<section id="content">
					<div class="container">
						<div class="my-3">
							<audio style="display: none;" controls src="nhacchuong.mp3" id="audio"></audio>
							<audio style="display: none;" controls src="phaohoa.mp3" id="audio2"></audio>
							<div id="boxnumber" class="d-flex">
								<button type="button" id="getit" class="mr-2"><span>Quay số</span></button>
								<div class="box">
									<div id="randomnumber1"></div>
								</div>
								<div class="box">
									<div id="randomnumber2"></div>
								</div>
								<div class="box">
									<div id="randomnumber3"></div>
								</div>
							</div>
						</div>

						<div class="d-flex justify-content-center">
							<div class="w-75 p-2 d-flex justify-content-center">
								<div class="form-check form-check-inline bg1">
								  <input class="form-check-input" type="radio" name="awards" id="awards1" value="1" checked>
								  <label class="form-check-label" for="awards1">Lần 1</label>
								</div>
								<div class="form-check form-check-inline bg2">
								  <input class="form-check-input" type="radio" name="awards" id="awards2" value="2">
								  <label class="form-check-label" for="awards2">Lần 2</label>
								</div>
							</div>
						</div>
					</div>
				</section>
			</div>
			<div class="col-sm-2 lottery-results">
				<header>
					<div class="header-top">
						<div class="logo">
							<a href="https://work.weldcom.vn" title="Weldcom"><img src="images/logo.png" alt="Weldcom" class="img-fluid"></a>(Customer)
						</div>
					</div>
				</header>
				<div class="mt-3">
					<button type="button" id="delallnum" class="btn btn-sm btn-block btn-danger mb-2"><span>Xoá dữ liệu</span></button>
					<div id="shownum"></div>
				</div>
			</div>
		</div>
	</div>
	<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/descrambler.min.js"></script>
	<script src="js/jquery.fireworks.js"></script>
    <script src="js/lottery.js"></script>
	
</body>
</html>