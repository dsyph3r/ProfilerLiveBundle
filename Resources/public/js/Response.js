(function() {
  var Response;
  Response = (function() {
    function Response(data) {
      this.data = data;
    }
    Response.prototype.getData = function() {
      return this.data;
    };
    Response.prototype.getStatusCode = function() {
      return this.data.status_code;
    };
    Response.prototype.getStatusCodeClass = function() {
      return this.getStatusCode().toString().substr(0, 1);
    };
    Response.prototype.getContentType = function() {
      return this.data.content_type;
    };
    Response.prototype.getController = function() {
      return this.data.controller;
    };
    Response.prototype.getRoute = function() {
      return this.data.route;
    };
    return Response;
  })();
  window.Response = Response;
}).call(this);
