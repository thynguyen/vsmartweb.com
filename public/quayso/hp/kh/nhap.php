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
					<div class="col-sm-6">
					</div>
				</div>
			</div>
		</div>
	</header>
	<section id="content">
		<div class="container">
			<div class="my-5">
				<div class="row">
					<div class="col-md-6">
			            <h2>Kết quả vòng quay may mắn</h2> 
			            <div id="test"></div>
			              <table class="table" style="color: black;">
			                <thead style="display: block">
			                  <tr>
			                    <th>Số thứ tự</th>
			                    <th>Kết quả</th>
			                  </tr>
			                </thead>
			                <tbody id="results" style="display: block;">
			                </tbody>
			              </table>
			        </div>
			        <div class="col-md-6">
			            <div id="wrapper" style="">
			                <audio style="display: none;" controls src="http://random.com/nhacchuong.mp3" id="audio"></audio>
			                <div id="wheel">
			                    <div id="inner-wheel" style="transform: rotate(1802deg);">
			                    </div>
			                    <div id="spin" class="showing">
			                        <div id="inner-spin" style="background: rgba(0, 0, 0, 0) url('{{ asset('assets/images/2010/logo.jpg') }}') no-repeat scroll center center;"></div>
			                    </div>
			                    <div id="shine"></div>
			                </div>
			            </div>
			        </div>
				</div>



				<div class="d-flex justify-content-center">
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
				</div>
			</div>
		</div>
	</section>
	<footer></footer>


	

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="js/sweetalert2.all.min.js"></script>
    <script type="text/javascript">
    	var degree = 18000,
		    clicks = 10000;

		function getRotationDegrees(e) {
		    var r = e.css("-webkit-transform") || e.css("-moz-transform") || e.css("-ms-transform") || e.css("-o-transform") || e.css("transform");
		    if ("none" !== r) var s = r.split("(")[1].split(")")[0].split(","),
		        n = s[0],
		        t = s[1],
		        a = Math.round(Math.atan2(t, n) * (180 / Math.PI));
		    else a = 0;
		    return a < 0 ? a + 360 : a
		}
		$(document).ready(function() {
		    var data = {
		        '1name': '1.jpg',
		        '2name': '2.jpg',
		        '3name': '3.jpg',
		        '4name': '4.jpg',
		        '5name': '5.jpg',
		        '6name': '6.jpg',
		        '7name': '7.jpg',
		        '8name': '8.jpg',
		        '9name': '9.jpg',
		        '10name': '10.jpg',
		        '11name': '11.jpg',
		        '12name': '12.jpg',
		        '13name': '13.jpg',
		        '14name': '14.jpg',
		        '15name': '15.jpg',
		        '16name': '16.jpg',
		        '17name': '17.jpg',
		        '18name': '18.jpg',
		        '19name': '19.jpg',
		        '20name': '20.jpg',
		        '21name': '21.jpg',
		        '22name': '22.jpg',
		        '23name': '23.jpg',
		        '24name': '24.jpg',
		        '25name': '25.jpg',
		        '26name': '26.jpg',
		        '27name': '27.jpg',
		        '28name': '28.jpg',
		        '29name': '29.jpg',
		        '30name': '30.jpg',
		        '31name': '31.jpg',
		        '32name': '32.jpg',
		        '33name': '33.jpg',
		        '34name': '34.jpg',
		        '35name': '35.jpg',
		        '36name': '36.jpg',
		    };
		    for (let i in data) {
		        $('#inner-wheel').append(`
		            <div class="sec">
		                <img data-name="${i}" src="/images/spin/${data[i]}">
		            </div>
		        `);
		    }
		    $("#spin").click(function() {
		        play(); // thực hiện audio, mình giải thích ở dưới hàm nhé.
		        var e = degree * ++clicks + (Math.floor(360 * Math.random()) + 1),
		            r = 360 - e % 360;
		        $("#spin").removeClass("showing"), $("#inner-spin").css("background", ""), $("#inner-wheel").css({
		            transform: "rotate(" + e + "deg)"
		        }), setTimeout(function() {
		            $("#wheel div.sec").each(function(e, s) {
		                var n = getRotationDegrees($(s));
		                if (0 === n && (n = 360), n - 5 < r && r <= n + 5) {
		                    var t = $(s).children("img").attr("src"),u = $(s).children("img").attr("data-name");
		                    html = '<tr>\
								<td>'+t.split('/')[3]+'</td>\
								<td>'+u+'</td>\
							</tr>';
		                    $('#results').append(html);
		                    $("#inner-spin").css("background", "url(" + t + ") center center no-repeat"), $("#spin").addClass("showing"), !1
		                    volume();
		                }
		            })
		        }, 6000)
		    })
		    function play(){
		       var audio = document.getElementById("audio");
		       audio.currentTime=0;
		       audio.volume = 1; // âm lượng nè
		       audio.play();
		    }

		    function volume() {
		       var audio = document.getElementById("audio");
		       audio.volume = 0.2;
		    }
		});


    	function getRandomInteger() {
			min = Math.ceil($('#nummin').val());
			max = Math.floor($('#nummax').val());
			return Math.floor(Math.random() * (max - min)) + min;
		}
		function getnumber(){
			$('#shownumber').text(getRandomInteger());
		};
    </script>
</body>
</html>