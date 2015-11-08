$(function() {
    $('.presetButton').click(function() {
          $.ajax({
            url: '/api/presets/setactivepreset',
            data: {presetName:this.id},
            type: 'POST',
            success: function(response) {
                console.log(response);
            },
            error: function(error) {
                console.log(error);
            }
        });
        this.blur();
    });
    
    $('.controlButton').click(function() {
        if($(this).data('toggleid')){
         toggleid= $(this).data('toggleid')
         val=$("#"+toggleid).prop('checked');
         postdata={controlObject:$(this).data('controlobject'),controlProperties:$(this).data('controlproperties')+val};
         alert (toggleid  +": "+ val);     
         alert (postdata)
        }
        else{
           postdata={controlObject:$(this).data('controlobject'),controlProperties:$(this).data('controlproperties')};
        }
          $.ajax({
            url: '/api/setcontrol',
            data: postdata,
            type: 'POST',
            success: function(response) {
                console.log(response);
            },
            error: function(error) {
                console.log(error);
            }
        });
        $(this).blur();
    });
    
    $('.finishSetup').click(function() {
          $.ajax({
            url: '/api/finishSetup',
            data: {username:$("#username").val(),password:$("#password").val()},
            type: 'POST',
            success: function(response) {
                console.log(response);
                window.location.href = response;
            },
            error: function(error) {
                console.log(error);
            }
        });
        this.blur();
    });
    
    $('.inputBox').change(function() {
        var timer;
        var _this=this;
        var targetID='#'+$(_this).data('controlid')+'Status';
        window.clearTimeout(window.timer);
        window.timer=window.setTimeout(function(){
            $.ajax({
            url: '/api/setComponentConfig',
            data: {"test":"good"},
            type: 'POST',
            success: function(response) {
                console.log(response);
                $(targetID).attr("class","glyphicon glyphicon-ok");
                $(targetID).css("color","green");
            },
            error: function(error) {
                console.log(error);
                $(targetID).attr("class","glyphicon glyphicon-remove");
                $(targetID).css("color","red");
            }
        });

        },1000);
    
    });
    
    
});