$(document).ready(function() {
    $(".vp-console").submit(function(event) {
        event.preventDefault();

        var vpConsole = $(this);
        var vpLog = vpConsole.find('.vp-log');

        var input = vpConsole.find("input[type='text']");
        var message = input.val();
        var data = {
            message: message
        };

        input.val('');
        vpLog.append('<div>' + data.message + '</div>');

        var id = vpConsole.attr('id');

        $.ajax({
            url: "?Update[]=" + id,
            data: data,
            processData: false,
            success: (result) => {
                console.log(result);
                console.log(data);

            },
            error: () => {
                console.error("fail");
            }
        });
    });
});
