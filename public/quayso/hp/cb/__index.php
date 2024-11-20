<!doctype html>
<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<title>Random Number</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" href="css/all.min.css">
	<link rel="stylesheet" type="text/css" href="css/sweetalert2.min.css" media="screen" />
	<link rel="stylesheet" href="css/style.css">
</head>
<body>
	<header>
		<div class="header-top">
			<div class="container">
				<div class="row">
					<div class="col-sm-6">
						<div class="logo">
							<a href="http://nhathuygroup.com.vn/" title="Nhất Huy Group"><img src="images/logo.png" alt="Nhất Huy Group" class="img-fluid"></a>
						</div>
					</div>
					<div class="col-sm-6 text-right text-uppercase font-weight-bold">
						Vòng Quay May Mắn
					</div>
				</div>
			</div>
		</div>
	</header>
	<section id="content">
		<div class="container">
			<div class="my-5">

	            <div class="d-flex justify-content-center form-inline">
		            <div class="form-group mx-sm-3 mb-2">
						<input type="text" class="form-control" id="nameplayer" placeholder="Tên người chơi">
					</div>
					<button type="button" id="btnspin" class="btn btn-primary mb-2">Quay thưởng</button>
				</div>
	            <div id="wrapper" style="">
	                <audio style="display: none;" controls src="http://random.com/nhacchuong.mp3" id="audio"></audio>
	                <div id="wheel">
	                    <div id="inner-wheel" style="transform: rotate(1802deg);">
	                    </div>
	                    <div id="spin" class="showing">
	                        <div id="inner-spin" style="background: rgba(0, 0, 0, 0) url('images/logoicon.png') no-repeat scroll center center;"></div>
	                    </div>
	                    <div id="shine"></div>
	                </div>
	            </div>
	            <h2>Kết quả vòng quay may mắn</h2> 
	            <div class="table-responsive">
					<table class="table table-striped table-hover">
						<thead class="thead-dark">
							<tr>
								<th>Hình ảnh</th>
								<th>Phần thưởng</th>
								<th>Người chơi</th>
								<th></th>
							</tr>
						</thead>
						<tbody id="results">
						</tbody>
					</table>
				</div>


				<!-- <div class="d-flex justify-content-center">
					<div id="shownumber" class="card card-body text-center h1"></div>
				</div>
				<div class="d-flex justify-content-center">
					<div id="shownumber"></div>
					<div class="form">
						<div class="form-row">
							<div class="form-group col-md-6">
								<label for="nummin">Số bé nhất</label>
								<input type="number" class="form-control" id="nummin" placeholder="Số bé nhất">
							</div>
							<div class="form-group col-md-6">
								<label for="nummax">Số lớn nhất</label>
								<input type="number" class="form-control" id="nummax" placeholder="Số lớn nhất">
							</div>
						</div>
						<button type="button" class="btn btn-primary btn-block btn-sm" onclick="getnumber()">Lấy số</button>
					</div>
				</div> -->
			</div>
		</div>
	</section>
	<footer>
	    <div class="footer-wrap">
	        <div class="w-100 d-lg-flex justify-content-between text-center">
	            <small class="d-block text-sm-left d-sm-inline-block">Copyright © 2018 <a href="http://vsmartweb.com/" target="_blank">V-Smart Web</a>. All rights reserved.</small>
	            <small>VSWCMS version 1.0.0</small>
	        </div>
	    </div>
	</footer>


	

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/sweetalert2.all.min.js"></script>
    <script src="js/rotation.js"></script>
    <!-- <script type="text/javascript">
    	function getRandomInteger() {
			min = Math.ceil($('#nummin').val());
			max = Math.floor($('#nummax').val());
			return Math.floor(Math.random() * (max - min)) + min;
		}
		function getnumber(){
			$('#shownumber').text(getRandomInteger());
		};
    </script> -->
</body>
</html>