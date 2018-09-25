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
	// logout
	$("#logoutButton").click(function(){
		window.location = 'logout.php';
	});
	// get item names
	var items = [];
	$.get("findItems.php",function(data){
		items = data.split(',');
		items[items.length-1] = items[items.length-1].substring(0,items[items.length-1].length-1);
		for (i=0;i<items.length;i++){
			console.log(items[i]+',');
		}
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
				setTimeout(changeItem,i*2000,i,item);
			}
			setTimeout(resetSpin,10000);
		}
	}
	// get result of spin, if out of spins refresh page to show alert, update spins left, call spin to display result
	$("#spinButton").click(function(){
		$.get("spin.php",function(data){
			if (data[0] == '<'){
				$('head').html(data);
			} else {
				$.get("spinsLeft.php",function(data){
					$("#spinsLeft").text(data);
				});
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
				if (seconds > 0 && minutes == 0){
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
			$('head').html(data);
		});
	});
	// get no. spins left
	$.get("spinsLeft.php",function(data){
		$("#spinsLeft").text(parseInt(data)+1);
	});
});