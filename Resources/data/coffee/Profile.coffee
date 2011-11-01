class Profile

    constructor: (@token, @args) ->
        @request    = @args.request     ? null
        @response   = @args.response    ? null
        @memory     = @args.memory      ? null
        @exception  = @args.exception   ? null
        @timer      = @args.timer       ? null
        @database   = @args.database    ? null
        @mailer     = @args.mailer      ? null
        @children   = @args.children    ? []


    getRequest: ->
        @request


    getResponse: ->
        @response


    getMemory: ->
        @memory


    getException: ->
        @exception


    getTimer: ->
        @timer


    getDatabase: ->
        @database


    getMailer: ->
        @mailer


    getToken: ->
        @token


    getChildren: ->
        @children


window.Profile = Profile
