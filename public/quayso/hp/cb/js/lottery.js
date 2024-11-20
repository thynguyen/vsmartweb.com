function IsNumeric(n){
		    return !isNaN(n);
		}
		  
		$(function(){
			let allItems = JSON.parse(localStorage.getItem('numruncb')) ? JSON.parse(localStorage.getItem('numruncb')) : [];
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
	        // var numRand = Math.floor(Math.random()*(4-0)) + 0;
	        var numRand = 0;
	        var numRand1 = makeUniqueRandom(5);
	        var numRand2 = makeUniqueRandom(5);
	        if (numRand == 0 && numRand1 >= 5) {
	        	var fnnumRand1 = 5;
	        } else {
	        	var fnnumRand1 = numRand1;
	        }
	        if (numRand == 0 && fnnumRand1 == 5 && numRand2 >= 5) {
	        	var fnnumRand2 = 5;
	        } else {
	        	var fnnumRand2 = numRand2;
	        }

	        return (numRand+','+fnnumRand1+','+fnnumRand2);
		}

		function quayso(){
			var number = getnumarray();
			var arraynumber = number.split(',');
			if ($.inArray(arraynumber[0]+''+arraynumber[1]+''+arraynumber[2], JSON.parse(localStorage.getItem('checknumcb')))!== -1 || number=='000' ) {
				quayso();
		    } else {
				play();
		        var numLow = 1;
		        var numHigh = 9;
		        let getnum = JSON.parse(localStorage.getItem('numruncb'))?JSON.parse(localStorage.getItem('numruncb')):[];
		        getnum.push({
		        	type:$('input[name=awards]:checked').val(),
		        	number:arraynumber[0]+''+arraynumber[1]+''+arraynumber[2]
		        });
		        localStorage.setItem('numruncb', JSON.stringify(getnum));
		        
		        let checknum = JSON.parse(localStorage.getItem('checknumcb'))?JSON.parse(localStorage.getItem('checknumcb')):[];
		        checknum.push(arraynumber[0]+''+arraynumber[1]+''+arraynumber[2]);
		        localStorage.setItem('checknumcb', JSON.stringify(checknum));
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

				        let allItemsAfter = JSON.parse(localStorage.getItem('numruncb')) ? JSON.parse(localStorage.getItem('numruncb')) : [];
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
		}