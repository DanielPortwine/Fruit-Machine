$(document).ready(function(){
	// fade alerts after 5 seconds
	function fadeAlert(id){
		$(id).fadeOut('slow', function() {
			$(id).remove();
		});
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
	function showAlert(message,type = 'success'){
		var id = Math.floor((Math.random() * 100) + 1);
		var alert = '<div class="alert alert-' + type + ' alert-dismissable fade show" id="alertBox-' + id + '">' + message + '<button type="button" class="close ml-2" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
		$("body").append(alert);
		setTimeout(fadeAlert,5000, '#alertBox-' + id);
	}

	// logout
	$("#logoutButton").click(function(){
		window.location = 'logout';
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
		$.get("setActive");
	}

	// get item names
	var items = [];
	$.ajax({
		type: 'GET',
		url: 'findItems',
		success: function(data) {
			items = data.split(',');
			//items[items.length-1] = items[items.length-1].substring(0,items[items.length-1].length-1);
		}
	});

	var canSpin = true;
	var itemsSpun = []
	// set the item from spinning.gif to the generated item
	function changeItem(itemNo,item){
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
	function spin(){
		if (canSpin == true){
			canSpin = false;
			$("#spinButton").attr("disabled",true);
			for (i=1;i<=5;i++){
				var itemNo = "#item" + i;
				$(itemNo).attr("src","images/spinning.gif");
				var item = items[itemsSpun[i-1]];
				var time = (i*1000)+(100*((i-1)*(i-1)));
				setTimeout(changeItem,time,i,item);
			}
			setTimeout(resetSpin,time);
			$.ajax({
				type:'POST',
				url: 'saveResults',
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
				url:'getLevel',
				success: function(data) {
					$("#userLevel").text(data);
				}
			});
		}
	}

	// get result of spin, if out of spins refresh page to show alert, update spins left, call spin to display result
	$("#spinButton").click(function() {
		$.ajax({
			type: 'GET',
			url: 'spin',
			success: function(data) {
				if (data[0] == '!'){
					showAlert('No spins left!','danger');
				} else {
					//setTimeout(showSpins,1000);
					var strArr = data.split(',');
					for(i=0;i<strArr.length;i++){
						itemsSpun.push(parseInt(strArr[i]));
					}
				}
			},
			complete: function() {
				spin();
			}
		});
	});

	// daily spin button countdown
	var countdownInterval;
	function dailySpinCountdown() {
		$.ajax({
			type: 'GET',
			url: 'dailySpinTime',
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
			url: 'getDailySpins',
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
			}
		});
	});

	// get no. spins left
	function showSpins(){
		var spinData = [];
		$.ajax({
			type: 'POST',
			url: 'spinsLeft',
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
			url: 'spinsLeft',
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
			url: 'useBeer',
			success: function(data) {
				showAlert(data,'success');
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
			url: 'adminSpins',
			complete: function() {
				showSpins();
			}
		});
	});

	// admin give 10 beers
	$("#adminBeers").click(function(){
		$.ajax({
			type: 'GET',
			url: 'adminBeers',
			complete: function() {
				updateBeer();
			}
		});
	});
});