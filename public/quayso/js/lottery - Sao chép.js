function IsNumeric(n){
		    return !isNaN(n);
		}
		  
		$(function(){
			let allItems = JSON.parse(localStorage.getItem('numrun')) ? JSON.parse(localStorage.getItem('numrun')) : [];
			if (allItems.length > 0) {
		        for (let i in allItems) {

                	if (!$('#shownum').find('#type'+allItems[i].type).length) {
                		if (allItems[i].type == 1) {
                			namtype = 'Giải đặc biệt';
                		} else if (allItems[i].type == 2) {
                			namtype = 'Giải nhất';
                		} else if (allItems[i].type == 3) {
                			namtype = 'Giải nhì';
                		} else if (allItems[i].type == 4) {
                			namtype = 'Giải ba';
                		} else if (allItems[i].type == 5) {
                			namtype = 'Giải khuyến khích';
                		}
		        		$('#shownum').prepend('<div id="type'+allItems[i].type+'" class="bg'+allItems[i].type+'"><span class="text">'+namtype+'</span><ul class="list-group list-group-flush"></ul></div>');
					}
		            $($('#type'+allItems[i].type).find('ul.list-group')).prepend(`
		                  <li class="list-group-item py-1 text-center">${allItems[i].number}</li>
		            `);
		        }
		    }
		    $("#getit").click(function() {
		    	$("#getit").attr("disabled", true).addClass('active');
		    	$("#randomnumber1").css('opacity',0);
		    	$("#randomnumber2").css('opacity',0);
		    	$("#randomnumber3").css('opacity',0);
				quayso();
		        return false;
		    });
			$("#delallnum").click(function() {
				if (confirm('Bạn xác nhận muốn xoá dữ liệu quay số?')) {
					$('#shownum').html('');
			    	localStorage.removeItem("numrun");
			    	localStorage.removeItem("checknum");
			    }
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
	    function play2(){
	       var audio = document.getElementById("audio2");
	       audio.currentTime=0;
	       audio.volume = 1;
	       audio.play();
	    }

	    function volume2() {
	       var audio = document.getElementById("audio2");
	       audio.volume = 0;
	    }
	    var uniqueRandoms = [];
		function makeUniqueRandom(max) {
		    if (!uniqueRandoms.length) {
		        for (var i = 0; i < max; i++) {
		            uniqueRandoms.push(i);
		        }
		    }
		    var index = Math.floor(Math.random() * uniqueRandoms.length);
		    var val = uniqueRandoms[index];
		    uniqueRandoms.splice(index, 1);

		    return val;

		}
		function getnumarray(){
	        var numRand = Math.floor(Math.random()*(4-0)) + 0;
	        var numRand1 = makeUniqueRandom(9);
	        var numRand2 = makeUniqueRandom(9);
	        if (numRand == 3 && numRand1 >= 2) {
	        	var fnnumRand1 = 2;
	        } else {
	        	var fnnumRand1 = numRand1;
	        }
	        if (numRand == 3 && fnnumRand1 == 2 && numRand2 >= 9) {
	        	var fnnumRand2 = 9;
	        } else {
	        	var fnnumRand2 = numRand2;
	        }

	        return (numRand+','+fnnumRand1+','+fnnumRand2);
		}

		function quayso(){
			let getnum = JSON.parse(localStorage.getItem('numrun'))?JSON.parse(localStorage.getItem('numrun')):[];
			if (getnum.length < 1) {
				var number = getnumarray();
				var arraynumber = number.split(',');
				if ($.inArray(arraynumber[0]+''+arraynumber[1]+''+arraynumber[2], JSON.parse(localStorage.getItem('checknum')))!== -1) {
					quayso();
			    } else {
					play();
			        var numLow = 1;
			        var numHigh = 9;
			        // let getnum = JSON.parse(localStorage.getItem('numrun'))?JSON.parse(localStorage.getItem('numrun')):[];
			        getnum.push({
			        	type:$('input[name=awards]:checked').val(),
			        	number:arraynumber[0]+''+arraynumber[1]+''+arraynumber[2]
			        });
			        localStorage.setItem('numrun', JSON.stringify(getnum));
			        
			        let checknum = JSON.parse(localStorage.getItem('checknum'))?JSON.parse(localStorage.getItem('checknum')):[];
			        checknum.push(arraynumber[0]+''+arraynumber[1]+''+arraynumber[2]);
			        localStorage.setItem('checknum', JSON.stringify(checknum));
			        if ((IsNumeric(numLow)) && (IsNumeric(numHigh)) && (parseFloat(numLow) <= parseFloat(numHigh)) && (numLow != '') && (numHigh != '')) {
			        	
						$("#randomnumber1").text(arraynumber[0]).css('opacity',1);
			     		$("#randomnumber1").scramble(3000, 20, "numbers", true);
			     		$("#randomnumber2").text(arraynumber[1]).css('opacity',1);
			     		$("#randomnumber2").scramble(5000, 20, "numbers", true);
			     		$("#randomnumber3").text(arraynumber[2]).css('opacity',1);
			     		$("#randomnumber3").scramble(7000, 20, "numbers", true);
				        setTimeout(function() {
							volume();
							play2();
							$('#firework').fireworks();
							setTimeout(function() {
								$('#firework').fireworks('destroy');
								volume2();
							}, 5000);
			    			$("#getit").attr("disabled", false).removeClass('active');

					        let allItemsAfter = JSON.parse(localStorage.getItem('numrun')) ? JSON.parse(localStorage.getItem('numrun')) : [];
				            if (allItemsAfter.length > 0) {
				                $('#shownum').html('');
				                for (let i in allItemsAfter) {
				                	if (!$('#shownum').find('#type'+allItemsAfter[i].type).length) {
				                		if (allItemsAfter[i].type == 1) {
				                			namtype = 'Giải đặc biệt';
				                		} else if (allItemsAfter[i].type == 2) {
				                			namtype = 'Giải nhất';
				                		} else if (allItemsAfter[i].type == 3) {
				                			namtype = 'Giải nhì';
				                		} else if (allItemsAfter[i].type == 4) {
				                			namtype = 'Giải ba';
				                		} else if (allItemsAfter[i].type == 5) {
				                			namtype = 'Giải khuyến khích';
				                		}
						        		$('#shownum').prepend('<div id="type'+allItemsAfter[i].type+'" class="bg'+allItemsAfter[i].type+'"><span class="text">'+namtype+'</span><ul class="list-group list-group-flush"></ul></div>');
									}
						            $($('#type'+allItemsAfter[i].type).find('ul.list-group')).prepend(`
						                  <li class="list-group-item py-1 text-center">${allItemsAfter[i].number}</li>
						            `);
				                }
				            }
						}, 7000);
			        } else {
			            $("#randomnumber").text("Careful now...");
			        }
			    }
		    } else {
		    	alert('Bản demo chỉ cho phép lưu một kết quả');
		    	$("#getit").attr("disabled", false).removeClass('active');
		    }
		}