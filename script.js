$(document).ready(function(){
	// fade alerts after 5 seconds
	function fadeAlert(){
		$("#alertBox").fadeOut();
	}
	setTimeout(fadeAlert,5000);
	// login and sign up form swapping
	var loginState = 'Login';
	$("#loginStateButton").click(function(){
		$("#loginStateButton").text(loginState);
		if (loginState == 'Login'){
			$("#loginForm").hide();
			$("#signUpForm").show();
			loginState = 'Sign Up';
		} else if (loginState == 'Sign Up'){
			$("#loginForm").show();
			$("#signUpForm").hide();
			loginState = 'Login';
		}
		$("#loginStateTitle").text(loginState);
	});
	// displays alerts
	$('.alert').alert();
	// initialise tooltips
	$(function () {
		$('[data-toggle="tooltip"]').tooltip()
	})
	$('[data-toggle="tooltip"]').tooltip({'delay': { show: 1000, hide: 0 }});
	// display alert without refresh
	function showAlert(message,type){
		var alert = '<div class="alert alert-' + type + ' alert-dismissable fade show" id="alertBox">' + message + '<button type="button" class="close ml-2" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
		$("body").append(alert);
		setTimeout(fadeAlert,5000);
	}
	// logout
	$("#logoutButton").click(function(){
		window.location = 'logout.php';
	});
	// making the user active when they perform actions
	setActive();
	var mouseMoved = false;
	$(document).click(setActive);
	$(document).mousemove(function(){
		if (mouseMoved == false){
			mouseMoved = true;
			setActive();
			setTimeout(resetMouseMove,10000);
		}
	});
	function resetMouseMove(){
		mouseMoved = false;
	}
	function setActive(){
		$.get("setActive.php");
	}
	// get item names
	var items = [];
	$.get("findItems.php",function(data){
		items = data.split(',');
		items[items.length-1] = items[items.length-1].substring(0,items[items.length-1].length-1);
	});
	var canSpin = true;
	var itemsSpun = []
	// set the item from spinning.gif to the generated item
	function changeItem(itemNo,item){
		itemNo = "#item" + itemNo;
		$(itemNo).attr("src","images/items/"+item+".png");
	}
	// save result of spin, display xp gained from spin, refresh user level re-enable spin button
	function resetSpin(){
		$.post("saveResults.php", {
			result: itemsSpun
		},function(data){
			$("#xpGained").text('+' + data + 'xp');
			$("#xpGainedContainer").show();
			setTimeout(function(){$("#xpGainedContainer").fadeOut();},3000);
		});
		$.get("getLevel.php",function(data){
			$("#userLevel").text(data);
		});
		canSpin = true;
		$("#spinButton").attr("disabled",false);
		itemsSpun = [];
		setTimeout(showSpins,10);
	}
	// disable spin button set each item to spinning.gif, call to display item every 2 seconds
	function spin(){
		if (canSpin == true){
			canSpin = false;
			$("#spinButton").attr("disabled",true);
			for (i=1;i<=5;i++){
				var itemNo = "#item" + i;
				$(itemNo).attr("src","images/spinning.gif");
				var item = items[itemsSpun[i-1]];
				//changeItem(i,item);
				setTimeout(changeItem,(i*1000)+(100*((i-1)*(i-1))),i,item);
				//console.log((i*1000)+(100*((i-1)*(i-1))));
			}
			//resetSpin();
			setTimeout(resetSpin,6600);
		}
	}
	// get result of spin, if out of spins refresh page to show alert, update spins left, call spin to display result
	$("#spinButton").click(function(){
		$.get("spin.php",function(data){
			// display result before finished
			//console.log(data);
			if (data[0] == '!'){
				showAlert('No spins left!','danger');
			} else {
				setTimeout(showSpins,10);
				var strArr = data.split(',');
				for(i=0;i<strArr.length;i++){
					itemsSpun.push(parseInt(strArr[i]));
				}
				spin();
			}
		});
	});
	// daily spin button countdown
	$.get("dailySpinTime.php",function(data){
		data = new Date(parseInt(data));
		setInterval(function(){
			var curTime = new Date();
			var difference = new Date(data - curTime);
			if (difference > 0){
				$("#dailySpinButton").attr("disabled",true);
				var days = difference.getDate();
				var hours = difference.getHours();
				var minutes = difference.getMinutes();
				var seconds = difference.getSeconds();
				var time = '';
				// displays the most relevant time scale
				if (days > 1){
					hours += days * 24;
				}
				if (hours > 0){
					time += hours + 'h';
				}
				if (minutes > 0 && hours == 0){
					time += minutes + 'm';
				}
				if (seconds > 0 && minutes == 0 && hours == 0){
					time += seconds + 's';
				}
				$("#dailySpinTimeRemaining").text(' (' + time + ')');
			} else {
				$("#dailySpinButton").attr("disabled",false);
				$("#dailySpinTimeRemaining").text('');
			}
		},1000);
	});
	// collect bonus spins
	$("#dailySpinButton").click(function(){
		$.post("getDailySpins.php",function(data){
			if (data[0] == 'S'){
				showAlert(data,'success');
			} else if (data[0] == 'B'){
				showAlert(data,'danger');
			}
		});
	});
	// get no. spins left
	function showSpins(){
		var spinData = [];
		$.get("spinsLeft.php",function(data){
			var strArr = data.split(',');
			for(i=0;i<strArr.length;i++){
				spinData.push(parseInt(strArr[i]));
			}
			$("#spinsLeft").text(spinData[0]);
			$("#beersLeft").text(spinData[1]);
			$("#beerSpinsLeft").text(spinData[2]);
		});
	}
	showSpins();
	// use a Beer
	$("#beerButton").click(function(){
		$.get("useBeer.php",function(data){
			// alert
		});
		setTimeout(showSpins,10);
	});
	
	// ---   admin controls   ---
	
	// admin rigged spin
	$("#spinButtonRigged").click(function(){
		for (i=1;i<=5;i++){
			itemsSpun.push($("#rItem"+i).val());
		}
		spin();
	});
	// admin give 20 spins
	$("#adminSpins").click(function(){
		$.get("adminSpins.php");
		setTimeout(showSpins,10);
	});
	// admin give 10 beersLeft
	$("#adminBeers").click(function(){
		$.get("adminBeers.php");
		setTimeout(showSpins,10);
	});
});