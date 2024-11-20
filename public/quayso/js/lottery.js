var awardstype = localStorage.getItem('awardstype');
var awardnummax = localStorage.getItem('nummax');
if (awardnummax) {
	var allnummax = awardnummax.split(',');
}
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
		        		$('#shownum').prepend('<table id="type'+allItems[i].type+'" class="table table-bordered table-sm bg'+allItems[i].type+'"><thead><tr><th><span class="text">'+namtype+'</span></th></tr></thead><tbody></tbody></table>');
					}
		            $('#type'+allItems[i].type).find('tbody').prepend(`
		                  <tr><td class="py-1 text-center">${allItems[i].number}</td></tr>
		            `);
		        }
		    }
		    if (awardstype) {
		    	$('#awards').val(awardstype);
		    }
		    if (awardnummax) {
				$('#nummax1').val(allnummax[0]);
				$('#nummax2').val(allnummax[1]);
				$('#nummax3').val(allnummax[2]);
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
			    	localStorage.removeItem("awardstype");
			    	localStorage.removeItem("nummax");
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
		        for (var i = 0; i <= max; i++) {
		            uniqueRandoms.push(i);
		        }
		    }
		    var index = Math.floor(Math.random() * uniqueRandoms.length);
		    var val = uniqueRandoms[index];
		    uniqueRandoms.splice(index, 1);
		    console.log(max)

		    return val;

		}
		function getnumarray(){
			var nummax1 = $('#nummax1').val();
			var nummax2 = $('#nummax2').val();
			var nummax3 = $('#nummax3').val();
	        localStorage.setItem('nummax', nummax1+','+nummax2+','+nummax3);
	        // console.log(localStorage.getItem('nummax'));

	        // var numRand = Math.floor(Math.random()*((parseInt(nummax1)+1)-0)) + 0;
	        // var numRand1 = makeUniqueRandom(9);
	        // var numRand2 = makeUniqueRandom(9);

	        var numRand = Math.floor(Math.random()*(4-0)) + 0;
	        var numRand1 = makeUniqueRandom(9);
	        var numRand2 = makeUniqueRandom(9);

	        console.log(numRand+','+numRand1+','+numRand2);

	        if (numRand == nummax1 && numRand1 > nummax2) {
	        	var fnnumRand1 = nummax2;
	        } else {
	        	var fnnumRand1 = numRand1;
	        }
	        if (numRand == nummax1 && fnnumRand1 == nummax2 && numRand2 >= nummax3) {
	        	var fnnumRand2 = nummax3;
	        } else {
	        	var fnnumRand2 = numRand2;
	        }

	        return (numRand+','+fnnumRand1+','+fnnumRand2);
	        // return('0,0,0')
		}

		function quayso(){
			let getnum = JSON.parse(localStorage.getItem('numrun'))?JSON.parse(localStorage.getItem('numrun')):[];
			// if (getnum.length < 1) {
				var number = getnumarray();
				var arraynumber = number.split(',');
				if (($.inArray(arraynumber[0]+''+arraynumber[1]+''+arraynumber[2], JSON.parse(localStorage.getItem('checknum')))!== -1) || arraynumber[0]+''+arraynumber[1]+''+arraynumber[2] === '000' ){
					quayso();
			    } else {
					play();
			        var numLow = 1;
			        var numHigh = 9;
			        // let getnum = JSON.parse(localStorage.getItem('numrun'))?JSON.parse(localStorage.getItem('numrun')):[];
			        getnum.push({
			        	type:$('#awards').val(),
			        	number:arraynumber[0]+''+arraynumber[1]+''+arraynumber[2]
			        });
			        localStorage.setItem('numrun', JSON.stringify(getnum));
			        localStorage.setItem('awardstype', $('#awards').val());
			        
			        let checknum = JSON.parse(localStorage.getItem('checknum'))?JSON.parse(localStorage.getItem('checknum')):[];
			        checknum.push(arraynumber[0]+''+arraynumber[1]+''+arraynumber[2]);
			        localStorage.setItem('checknum', JSON.stringify(checknum));
			        if ((IsNumeric(numLow)) && (IsNumeric(numHigh)) && (parseFloat(numLow) <= parseFloat(numHigh)) && (numLow != '') && (numHigh != '')) {
			        	
						$("#randomnumber1").text(arraynumber[0]).css('opacity',1).scramble(3000, 20, "numbers", true);
			     		$("#randomnumber2").text(arraynumber[1]).css('opacity',1).scramble(5000, 20, "numbers", true);
			     		$("#randomnumber3").text(arraynumber[2]).css('opacity',1).scramble(7000, 20, "numbers", true);
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
						        		$('#shownum').prepend('<table id="type'+allItemsAfter[i].type+'" class="table table-bordered table-sm bg'+allItemsAfter[i].type+'"><thead><tr><th><span class="text">'+namtype+'</span></th></tr></thead><tbody></tbody></table>');
									}
						            $('#type'+allItemsAfter[i].type).find('tbody').prepend(`
						                  <tr><td class="py-1 text-center">${allItemsAfter[i].number}</td></tr>
						            `);
				                }
				            }
						}, 7000);
			        } else {
			            $("#randomnumber").text("Careful now...");
			        }
			    }
		    // } else {
		    // 	alert('Bản demo chỉ cho phép lưu một kết quả');
		    // 	$("#getit").attr("disabled", false).removeClass('active');
		    // }
		}
		function exportData() {
			 TableToExcel.convert(document.getElementById("shownum"), {
            name: "Kết quả quay số.xlsx",
            sheet: {
            name: "Sheet1"
            }
          });
		}