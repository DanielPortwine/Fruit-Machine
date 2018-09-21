$(document).ready(function(){
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
	var items = [];
	$.get("findItems.php",function(data){
		items = data.split(',');
		var allItems = "";
		for (i=0;i<items.length;i++){
			allItems += '<img src="images/items/' + items[i] + '.png">';
		}
		$("#allItems").html(allItems);
	});
	var canSpin = true;
	var itemsSpun = []
	function changeItem(itemNo,item){
		itemNo = "#item" + itemNo;
		$(itemNo).attr("src","images/items/"+item+".png");
	}
	function resetSpin(){
		$.post("saveResults.php", {
			result: itemsSpun
		});
		canSpin = true;
		$("#spinButton").attr("disabled",false);
		itemsSpun = [];
	}
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
	$("#spinButton").click(function(){
		// fetch the results
		$.get("spin.php",function(data){
			var strArr = data.split(',');
			for(i=0;i<strArr.length;i++){
				itemsSpun.push(parseInt(strArr[i]));
			}
			spin();
		});
	});
});