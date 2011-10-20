(function() {
  var Request;
  Request = (function() {
    function Request(data) {
      this.data = data;
    }
    Request.prototype.getData = function() {
      return this.data;
    };
    Request.prototype.getMethod = function() {
      return this.data.request_method;
    };
    Request.prototype.getRequestUri = function() {
      return this.data.request_uri;
    };
    return Request;
  })();
  window.Request = Request;
}).call(this);
