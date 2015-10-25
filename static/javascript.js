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
    });
    
    $('.controlButton').click(function() {
          $.ajax({
            url: '/api/setcontrol',
            data: {controlGroup:$(this).data('controlGroup'),controlName:this.id},
            type: 'POST',
            success: function(response) {
                console.log(response);
            },
            error: function(error) {
                console.log(error);
            }
        });
    });
    
});