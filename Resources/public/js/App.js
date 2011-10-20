(function() {
  var App;
  var __bind = function(fn, me){ return function(){ return fn.apply(me, arguments); }; }, __indexOf = Array.prototype.indexOf || function(item) {
    for (var i = 0, l = this.length; i < l; i++) {
      if (this[i] === item) return i;
    }
    return -1;
  };
  App = (function() {
    function App(url, args) {
      var _ref;
      this.url = url;
      this.handleData = __bind(this.handleData, this);
      this.getData = __bind(this.getData, this);
      this.resetUI = __bind(this.resetUI, this);
      this.init();
      args = args != null ? args : {};
      this.interval = (_ref = args.interval) != null ? _ref : 1000;
    }
    App.prototype.init = function() {
      this.profiles = [];
      this.token = '';
      this.profileTemplate = _.template($('#profile-template').html());
      this.filters = {
        'methods': ['GET', 'POST', 'PUT', 'DELETE'],
        'status-codes': ['200', '300', '400', '500'],
        'content-types': ['text/html', 'application/json', 'text/xml'],
        'url': ''
      };
      return this.resetUI();
    };
    App.prototype.resetUI = function() {
      $('#request-url').val('');
      return $('input:checkbox').attr('checked', true);
    };
    App.prototype.start = function() {
      return this.getData();
    };
    App.prototype.getData = function() {
      if (this.token.length) {
        return $.getJSON(this.url + '/' + this.token, {}, this.handleData);
      } else {
        return $.getJSON(this.url, {}, this.handleData);
      }
    };
    App.prototype.reset = function() {
      return this.init();
    };
    App.prototype.clearUI = function() {
      return $('.profiles').html('');
    };
    App.prototype.addFilter = function(type, filter) {
      if (_.isArray(this.filters[type])) {
        if (this.isFilterSet(type, filter) !== true) {
          return this.filters[type].push(filter);
        }
      } else {
        return this.filters[type] = filter;
      }
    };
    App.prototype.removeFilter = function(type, filter) {
      var idx;
      if (_.isArray(this.filters[type])) {
        idx = this.filters[type].indexOf(filter);
        if (idx !== -1) {
          return this.filters[type].splice(idx, 1);
        }
      } else {
        return this.filters[type] = filter;
      }
    };
    App.prototype.isFilterSet = function(type, filter) {
      var idx;
      idx = this.filters[type].indexOf(filter);
      if (idx !== -1) {
        return true;
      } else {
        return false;
      }
    };
    App.prototype.getFilters = function() {
      return this.filters;
    };
    App.prototype.handleData = function(data) {
      var child, children, index, profile, _i, _len, _ref, _ref2;
      this.token = data.last_token;
      _ref = data.profiles;
      for (index in _ref) {
        profile = _ref[index];
        children = [];
        if (profile.children != null) {
          _ref2 = profile.children;
          for (_i = 0, _len = _ref2.length; _i < _len; _i++) {
            child = _ref2[_i];
            children.push(this.createProfileFromRaw(child));
          }
        }
        this.profiles.push(this.createProfileFromRaw(profile, children));
      }
      this.render();
      return window.setTimeout(this.getData, this.interval);
    };
    App.prototype.createProfileFromRaw = function(profile, children) {
      var profileArgs;
      profileArgs = {};
      if (profile.request != null) {
        profileArgs.request = new Request(profile.request);
      }
      if (profile.response != null) {
        profileArgs.response = new Response(profile.response);
      }
      if (profile.memory != null) {
        profileArgs.memory = new Memory(profile.memory);
      }
      if (profile.timer != null) {
        profileArgs.timer = new Timer(profile.timer);
      }
      if (profile.exception != null) {
        profileArgs.exception = new Exception(profile.exception);
      }
      if (profile.mailer != null) {
        profileArgs.mailer = new Mailer(profile.mailer);
      }
      if (profile.database != null) {
        profileArgs.database = new Database(profile.database);
      }
      profileArgs.children = children;
      return profile = new Profile(profile.token, profileArgs);
    };
    App.prototype.generateProfilerUrl = function(token, panel) {
      return '/app_dev.php/_profiler/' + token + '?panel=' + panel;
    };
    App.prototype.render = function() {
      var filtered, index, profile, _results;
      this.clearUI();
      filtered = _(this.profiles).select(__bind(function(profile) {
        var _ref, _ref2, _ref3;
        if ((_ref = profile.getRequest().getMethod(), __indexOf.call(this.filters['methods'], _ref) >= 0) && (_ref2 = profile.getResponse().getStatusCodeClass() + '00', __indexOf.call(this.filters['status-codes'], _ref2) >= 0) && (_ref3 = profile.getResponse().getContentType(), __indexOf.call(this.filters['content-types'], _ref3) >= 0) && profile.getRequest().getRequestUri().indexOf(this.filters['url']) !== -1) {
          return true;
        } else {
          return false;
        }
      }, this));
      _results = [];
      for (index in filtered) {
        profile = filtered[index];
        _results.push(this.renderProfile(profile));
      }
      return _results;
    };
    App.prototype.renderProfile = function(profile) {
      var index, profileHtml, _ref;
      profileHtml = this.profileTemplate({
        profile: profile,
        app: this,
        child: false
      });
      _ref = profile.getChildren();
      for (index in _ref) {
        profile = _ref[index];
        profileHtml += this.profileTemplate({
          profile: profile,
          app: this,
          child: true
        });
      }
      return $('.profiles').prepend(profileHtml);
    };
    return App;
  })();
  window.App = App;
}).call(this);
