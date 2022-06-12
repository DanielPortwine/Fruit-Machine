$(document).ready(function(){
	// fade alerts after 5 seconds
	function fadeAlert(id){
		$(id).fadeOut('slow', function() {
			$(id).remove();
		});
	}
	setTimeout(function(){fadeAlert('#alertBox')},5000);

	// login and sign up form swapping
	var loginState = 'Sign Up';
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
	function showAlert(message,type = 'success'){
		var id = Math.floor((Math.random() * 100) + 1);
		var alert = '<div class="alert alert-' + type + ' alert-dismissable fade show" id="alertBox-' + id + '">' + message + '<button type="button" class="close ml-2" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
		$("body").append(alert);
		setTimeout(fadeAlert,5000, '#alertBox-' + id);
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
	$.ajax({
		type: 'GET',
		url: 'findItems.php',
		success: function(data) {
			items = data.split(',');
			//items[items.length-1] = items[items.length-1].substring(0,items[items.length-1].length-1);
		}
	});

	var canSpin = true;
	var itemsSpun = [];
	// set the item from spinning.gif to the generated item
	function changeItem(itemNo,item){
		clearInterval(itemIntervals[itemNo]);
		itemNo = "#item" + itemNo;
		$(itemNo).attr("src","images/items/"+item+".png");
	}

	// display xp gained from spin, refresh user level and re-enable spin button
	function resetSpin(){
		$("#xpGainedContainer").show();
		setTimeout(function(){$("#xpGainedContainer").fadeOut();},3000);
		canSpin = true;
		$("#spinButton").attr("disabled",false);
		itemsSpun = [];
		updateBeer();
	}

	// disable spin button set each item to spinning.gif, call to display item every 2, save results and update user's level
	var itemIntervals = [];
	function spin(){
		if (canSpin == true){
			canSpin = false;
			$("#spinButton").attr("disabled",true);
			for (i=1;i<=5;i++){
				var item = items[itemsSpun[i-1]];
				var time = 1000 + (i*1000);
				createInterval(i);
				setTimeout(changeItem,time,i,item);
			}
			setTimeout(resetSpin,time);
			$.ajax({
				type:'POST',
				url: 'saveResults.php',
				data: {result: itemsSpun},
				success: function(data) {
					setTimeout(function() {$("#xpGained").text('+' + data + 'xp');}, 4000 );
				},
				complete: function() {
					showSpins();
				}
			});
			$.ajax({
				type: 'GET',
				url:'getLevel.php',
				success: function(data) {
					$("#userLevel").text(data);
				}
			});
		}
	}

	// make each item spin randomly until displayed
	function createInterval(item) {
		itemIntervals[item] = setInterval(function() {
			$("#item" + item).attr('src', 'images/items/' + items[Math.floor(Math.random() * 18)] + '.png');
		}, 100);
	}

	// get result of spin, if out of spins refresh page to show alert, update spins left, call spin to display result
	$("#spinButton").click(function() {
		$.ajax({
			type: 'GET',
			url: 'spin.php',
			success: function(data) {
				if (data[0] == '!'){
					canSpin = false;
					showAlert('No spins left!','danger');
				} else {
					var strArr = data.split(',');
					for(i=0;i<strArr.length;i++){
						itemsSpun.push(parseInt(strArr[i]));
					}
				}
			},
			complete: function() {
				if (canSpin == true) {
					spin();
				}
			}
		});
	});

	// daily spin button countdown
	var countdownInterval;
	function dailySpinCountdown() {
		$.ajax({
			type: 'GET',
			url: 'dailySpinTime.php',
			success: function(data) {
				data = new Date(parseInt(data));
				countdownInterval = setInterval(function () {
					var curTime = new Date();
					var difference = new Date(data - curTime);
					if (difference > 0) {
						$("#dailySpinButton").attr("disabled", true);
						var days = difference.getDate() - 1;
						var hours = difference.getHours() - 1;
						var minutes = difference.getMinutes();
						var seconds = difference.getSeconds();
						var time = '';
						// displays the most relevant time scale
						if (days > 0) {
							hours += days * 24;
						}
						if (hours > 0) {
							time += hours + 'h';
						}
						if (minutes > 0 && hours == 0) {
							time += minutes + 'm';
						}
						if (seconds > 0 && minutes == 0 && hours == 0) {
							time += seconds + 's';
						}
						$("#dailySpinTimeRemaining").text(' (' + time + ')');
					} else {
						$("#dailySpinButton").attr("disabled", false);
						$("#dailySpinTimeRemaining").text('');
					}
				}, 1000);
			}
		});
	}
	dailySpinCountdown();

	// collect bonus spins
	$("#dailySpinButton").click(function(){
		$.ajax({
			type: 'POST',
			url: 'getDailySpins.php',
			success: function(data) {
				if (data[0] == 'S'){
					showAlert(data,'success');
				} else if (data[0] == 'B'){
					showAlert(data,'danger');
				}
			},
			complete: function() {
				clearInterval(countdownInterval);
				dailySpinCountdown();
				showSpins();
			}
		});
	});

	// get no. spins left
	function showSpins(){
		var spinData = [];
		$.ajax({
			type: 'POST',
			url: 'spinsLeft.php',
			data: {type: 'spin'},
			success: function(data) {
				var strArr = data.split(',');
				for(i=0;i<strArr.length;i++){
					spinData.push(parseInt(strArr[i]));
				}
				$("#spinsLeft").text(spinData[0]);
				$("#beerSpinsLeft").text(spinData[1]);
			}
		});
	}
	showSpins();

	// update the number of beers left
	function updateBeer() {
		$.ajax({
			type: 'POST',
			url: 'spinsLeft.php',
			data: {type: 'beer'},
			success: function(data) {
				$('#beersLeft').text(data);
			}
		});
	}
	updateBeer();

	// use a Beer
	$("#beerButton").click(function(){
		$.ajax({
			type: 'GET',
			url: 'useBeer.php',
			success: function(data) {
				if (data[0] == '2') {
					showAlert(data, 'success');
				} else {
					showAlert(data, 'danger');
				}
			},
			complete: function() {
				showSpins();
				updateBeer();
			}
		});
	});

	// ---   admin controls   ---

	// rigged spin
	$("#spinButtonRigged").click(function(){
		for (i=1;i<=5;i++){
			itemsSpun.push($("#rItem"+i).val());
		}
		spin();
	});

	// admin give 20 spins
	$("#adminSpins").click(function(){
		$.ajax({
			type: 'GET',
			url: 'adminSpins.php',
			complete: function() {
				showSpins();
			}
		});
	});

	// admin give 10 beers
	$("#adminBeers").click(function(){
		$.ajax({
			type: 'GET',
			url: 'adminBeers.php',
			complete: function() {
				updateBeer();
			}
		});
	});
});