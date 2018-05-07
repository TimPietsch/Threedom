var id = 'console2';

var updater = new tdUpdater({
    count: 1
});

updater.register({
    action: 'VpConsole',
    params: ['console', 'console2'],
    success: function (result) {
        console.log(result);
    }
});

updater.run();
