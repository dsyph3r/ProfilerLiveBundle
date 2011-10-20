(function() {
  var Memory;
  Memory = (function() {
    function Memory(data) {
      this.data = data;
    }
    Memory.prototype.getMemory = function() {
      return this.data.memory;
    };
    return Memory;
  })();
  window.Memory = Memory;
}).call(this);
