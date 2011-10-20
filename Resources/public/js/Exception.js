(function() {
  var Exception;
  Exception = (function() {
    function Exception(data) {
      this.data = data;
    }
    Exception.prototype.getClass = function() {
      return this.data['class'];
    };
    Exception.prototype.getMessage = function() {
      return this.data.message;
    };
    Exception.prototype.getStatusCode = function() {
      return this.data.status_code;
    };
    return Exception;
  })();
  window.Exception = Exception;
}).call(this);
