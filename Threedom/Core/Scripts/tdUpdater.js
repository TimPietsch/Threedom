function tdUpdater(cfg) {
    this.count = cfg.count || 0;
    this.interval = cfg.interval || 5;
    this.queries = {};
}

tdUpdater.prototype.register = function (query) {
    if (query.hasOwnProperty('action')) {
        // Add new query
        this.queries[query.action] = query;
    }
};

tdUpdater.prototype.run = function () {
    // Build GET string from queries
    var queries = [];
    // Iterate over queries
    for (var queryId in this.queries) {
        // Iterate over params of query
        var paramsLength = this.queries[queryId].params.length;
        for (var i = 0; i < paramsLength; i++) {
            queries.push(this.queries[queryId].action + '[]=' + this.queries[queryId].params[i]);
        }
    }
    var url = '?' + queries.join('&');

    // Run the registered queries
    var count = this.count;
    this.repeat = setInterval(() => {
        // Request queries
        $.ajax({
            url: url,
            dataType: 'json',
            success: (result) => {
                for (var queryId in this.queries) {
                    this.queries[queryId].success(result[queryId]);
                }
            },
            error: function () {
                console.log('Tschüss Welt');
            }
        });

        // Count down
        if (count > 0) {
            count -= 1;
        }
        if (count === 0) {
            // Stop repetition
            clearInterval(this.repeat);
        }
    }, this.interval * 1000);
};
