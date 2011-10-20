(function() {
  var Timer;
  Timer = (function() {
    function Timer(data) {
      this.data = data;
    }
    Timer.prototype.getTime = function() {
      return this.data.time;
    };
    return Timer;
  })();
  window.Timer = Timer;
}).call(this);
