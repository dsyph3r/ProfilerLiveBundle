(function() {
  var Mailer;
  Mailer = (function() {
    function Mailer(data) {
      this.data = data;
    }
    Mailer.prototype.getMessageCount = function() {
      return this.data.message_count;
    };
    Mailer.prototype.isSpool = function() {
      return this.data.is_spool;
    };
    return Mailer;
  })();
  window.Mailer = Mailer;
}).call(this);
