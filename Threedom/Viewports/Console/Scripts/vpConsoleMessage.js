function vpConsoleMessage(data) {
    this.timestamp = new Date(data.timestamp);
    this.message = data.message;
}

vpConsoleMessage.prototype.toString = function() {
    return "<div><div>" + this.timestamp + "</div><div>" + this.message + "</div></div>";
};
