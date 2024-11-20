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
	<div id="firework">
		<div class="row no-gutters">
			<div class="col-sm-10">
				<section id="boxtext" class="d-none">
					<div class="container">
						<div class="showtext">
							Year End Party 2020<br>
						</div>
					</div>
				</section>
				<section id="content" class="h-100">
					<div class="container">
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
				</section>
			</div>
			<div class="col-sm-2 lottery-results d-none d-lg-block">
				<header>
					<div class="header-top">
						<div class="logo px-3">
							<!-- <a href="https://work.weldcom.vn" title="Weldcom"><img src="images/logo.png" alt="Weldcom" class="img-fluid"></a> -->
						</div>
					</div>
				</header>
				<div class="mt-3">
					<div class="px-3 mb-3">
						<!-- <div class="form-group">
							<label>Số vé</label>
							<div class="row no-gutters">
								<div class="col-4">
									<input type="number" class="form-control" id="nummax1">
								</div>
								<div class="col-4">
									<input type="number" class="form-control" id="nummax2">
								</div>
								<div class="col-4">
									<input type="number" class="form-control" id="nummax3">
								</div>
							</div>
						</div> -->
						<div class="form-group">
							<select class="form-control form-control-sm" id="awards">
								<option value="1">Giải đặc biệt</option>
								<option value="2">Giải nhất</option>
								<option value="3">Giải nhì</option>
								<option value="4">Giải ba</option>
								<option value="5">Khuyến khích</option>
							</select>
						</div>
						<button type="button" id="delallnum" class="btn btn-sm btn-block btn-danger mb-2"><span>Xoá dữ liệu</span></button>
						<button onclick="exportData()" class="btn btn-sm btn-block btn-primary">Tải về file Excel</button>
					</div>
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
	<script src="https://cdn.jsdelivr.net/gh/linways/table-to-excel@v1.0.4/dist/tableToExcel.js"></script>
    <script src="js/lottery.js"></script>
	
</body>
</html>