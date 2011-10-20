(function() {
  var Database;
  Database = (function() {
    function Database(data) {
      this.data = data;
    }
    Database.prototype.getQueryCount = function() {
      return this.data.query_count;
    };
    Database.prototype.getTime = function() {
      return this.data.time;
    };
    return Database;
  })();
  window.Database = Database;
}).call(this);
