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
						Quay số may mắn
					</div>
				</div>
			</div>
		</div>
	</header>
	<section id="content">
		<div class="container">
			<div class="my-5">
				<div id="boxnumber" class="d-flex">
					<div class="box">
						<div id="randomnumber1">170</div>
					</div>
					<div class="box">
						<div id="randomnumber2">170</div>
					</div>
					<div class="box">
						<div id="randomnumber3">170</div>
					</div>
				</div>
				<div class="d-flex justify-content-center form-inline">
					<audio style="display: none;" controls src="/nhacchuong.mp3" id="audio"></audio>
					<button type="button" id="getit" class="btn btn-primary mb-2">Quay số</button>
				</div>
	            
			</div>
		</div>
	</section>


	

	<script
  src="https://code.jquery.com/jquery-3.4.1.min.js"
  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
  crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script type="text/javascript">
    	function IsNumeric(n){
		    return !isNaN(n);
		}
		  
		$(function(){
		     
		    $("#getit").click(function() {
		    	play();
		    	$("#randomnumber1").text('170');
		    	$("#randomnumber2").text('');
		    	$("#randomnumber3").text('');

	           
		        var numLow = 1;
		        var numHigh = 9;
		         
		        var adjustedHigh = (parseFloat(numHigh) - parseFloat(numLow)) + 1;

		        var numLow2 = 1;
		        var numHigh2 = 7;
		         
		        var adjustedHigh2 = (parseFloat(numHigh2) - parseFloat(numLow2)) + 1;
		         
		        var numRand = Math.floor(Math.random()*(2-0)) + 0;
		        var numRand1 = Math.floor(Math.random()*adjustedHigh2) + parseFloat(numLow2);
		        if (numRand1 == 7 && numRand == 1) {
		        	var numRand2 = 0;
		        } else {
		        	var numRand2 = Math.floor(Math.random()*adjustedHigh) + parseFloat(numLow);
		        }
		         
		        if ((IsNumeric(numLow)) && (IsNumeric(numHigh)) && (parseFloat(numLow) <= parseFloat(numHigh)) && (numLow != '') && (numHigh != '')) {
		        	
				    
				    
					$("#randomnumber1").prop('Counter',0).animate({
				        Counter: $("#randomnumber1").text()
				    }, {
				        duration: 4000,
				        easing: 'swing',
				        step: function (now) {
				        	$(this).css('opacity',1);
				            $("#randomnumber1").text(Math.ceil(now));
				            setTimeout(function() {
				            	$("#randomnumber1").text(numRand);
					        }, 20);
				        }
				    });
				    setTimeout(function() {
		    			$("#randomnumber2").text('170');
		            	$("#randomnumber2").prop('Counter',0).animate({
					        Counter: $("#randomnumber2").text()
					    }, {
					        duration: 4000,
					        easing: 'swing',
					        step: function (now) {
					        	$(this).css('opacity',1);
					            $("#randomnumber2").text(Math.ceil(now));
					            setTimeout(function() {
					            	$("#randomnumber2").text(numRand1);
						        }, 20);
					        }
					    });
				    }, 4000);
				    setTimeout(function() {
		    			$("#randomnumber3").text('170');
			            $("#randomnumber3").prop('Counter',0).animate({
					        Counter: $("#randomnumber3").text()
					    }, {
					        duration: 4000,
					        easing: 'swing',
					        step: function (now) {
					        	$(this).css('opacity',1);
					            $("#randomnumber3").text(Math.ceil(now));
					            setTimeout(function() {
						            $("#randomnumber3").text(Math.ceil(numRand2));
						        }, 20);
					        }
					    });
				    }, 8000);
			        setTimeout(function() {
						volume();
					}, 12000);
		        } else {
		            $("#randomnumber").text("Careful now...");
		        }
		        return false;
		    });
		     
		});

	    function play(){
	       var audio = document.getElementById("audio");
	       audio.currentTime=0;
	       audio.volume = 1;
	       audio.play();
	    }

	    function volume() {
	       var audio = document.getElementById("audio");
	       audio.volume = 0;
	    }
    </script>
</body>
</html>