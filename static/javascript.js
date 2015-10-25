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
    
});