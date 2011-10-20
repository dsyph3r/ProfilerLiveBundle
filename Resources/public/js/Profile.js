(function() {
  var Profile;
  Profile = (function() {
    function Profile(token, args) {
      var _ref, _ref2, _ref3, _ref4, _ref5, _ref6, _ref7, _ref8;
      this.token = token;
      this.args = args;
      console.log(this.args);
      this.request = (_ref = this.args.request) != null ? _ref : null;
      this.response = (_ref2 = this.args.response) != null ? _ref2 : null;
      this.memory = (_ref3 = this.args.memory) != null ? _ref3 : null;
      this.exception = (_ref4 = this.args.exception) != null ? _ref4 : null;
      this.timer = (_ref5 = this.args.timer) != null ? _ref5 : null;
      this.database = (_ref6 = this.args.database) != null ? _ref6 : null;
      this.mailer = (_ref7 = this.args.mailer) != null ? _ref7 : null;
      this.children = (_ref8 = this.args.children) != null ? _ref8 : [];
    }
    Profile.prototype.getRequest = function() {
      return this.request;
    };
    Profile.prototype.getResponse = function() {
      return this.response;
    };
    Profile.prototype.getMemory = function() {
      return this.memory;
    };
    Profile.prototype.getException = function() {
      return this.exception;
    };
    Profile.prototype.getTimer = function() {
      return this.timer;
    };
    Profile.prototype.getDatabase = function() {
      return this.database;
    };
    Profile.prototype.getMailer = function() {
      return this.mailer;
    };
    Profile.prototype.getToken = function() {
      return this.token;
    };
    Profile.prototype.getChildren = function() {
      return this.children;
    };
    return Profile;
  })();
  window.Profile = Profile;
}).call(this);
