$(function(){
	var pendingResponse=false;
	var id=0;
	
	function poll(){
		
		$.ajax({ url: "http://192.168.2.56/api/polldata.php?id="+id, success: function(data){
			//Update your dashboard gauge
			//alert(data);
			if(!data.length)
			{
				//alert(data);
			}
			else
			{
				var obj=JSON.parse(data);
				//alert(data);
				pendingResponse=false;
				$("#Status").html(obj.TEXT);
				$("#Status").css("display","block");
				id=parseInt(obj.ID)+1;
				t=setTimeout(hideAlert,2000);
			}
		}, dataType: "text", complete: poll, timeout: 30000, cache:false });
	
	};
	
	function hideAlert()
	{
		$("#Status").html("");
		$("#Status").css("display","none");
	}
	
	function tooLong()
	{
		if(pendingResponse)
		{
			$("#Status").html("this is taking a while. Something may be wrong");
			t=setTimeout(hideAlert,2000);
		}
	}

	
	
	
	
	$(".property").click(function() {
		$.ajax({type: "POST",
			url: "http://192.168.2.56/api/pushdata.php",
			data: {value:$(this).html()}
			});
		pendingResponse=true;
		$("#Status").html("attempting action: "+$(this).html());
		$("#Status").css("display","block");
		t=setTimeout(tooLong,1000);
	});
	
	$("#AdvancedPropertiesTitle").click(function(){
		
		if( $("#AdvancedProperties").css("height")=="24px")
		{
			$("#AdvancedProperties").css("height","auto");
		}
		else
		{
			$("#AdvancedProperties").css("height","1.5em");
		}
		});
	
	//t=setTimeout(poll,100);
	poll();
	

});