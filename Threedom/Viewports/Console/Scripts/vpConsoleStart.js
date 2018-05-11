var updater = new tdUpdater({
    count: 1,
    interval: 5
});

updater.register({
    action: 'VpStart',
    success: function (result) {
        console.log(result);
    }
});

updater.run();
