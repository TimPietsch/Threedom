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
            dataType: "json",
//            contentType: 'application/json; charset=utf-8',
            type: "POST",
            success: (result) => {
                console.log(result);
                console.log(data);

                vpLog.append(new vpConsoleMessage(result).toString());
            },
            error: () => {
                console.error("fail");
            }
        });
    });
});
