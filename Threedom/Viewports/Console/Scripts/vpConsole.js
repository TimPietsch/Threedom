function vpConsole(object) {

    if (typeof vpConsole.counter === 'undefined') {
        vpConsole.counter = 0;
    } else {
        vpConsole.counter += 1;
    }

    this.id = object.id || 'vpConsole' + vpConsole.counter;
    this.title = object.title || '';
    this.disabled = object.disabled;
}

vpConsole.prototype.toString = function() {
    var html = '<form class="vp-console" id="' + this.id + '">';

    if (this.title) {
        html += '<div class="vp-console-title">' + this.title + '</div>';
    }
    html += '<div class="vp-console-log"></div>';
    html += '<input type="text">';
    html += '<input type="submit">';

    html += '</form>';

    return html;
};
