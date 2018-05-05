$(document).ready(function() {
    var id = 'console2';

    // update manager in ?tdX.js?

    $.ajax({// move to update manager
        url: '?GetConsole=' + id, // url in update manager generated with array.join()
        success: function(result) {
            console.log(result);
        },
        error: function() {
            console.error('vpConsoleInit failed');
        }
    });
});