class Request

    constructor: (data) ->
        @data = data


    getData: ->
        @data


    getMethod: ->
        @data.request_method


    getRequestUri: ->
        @data.request_uri


window.Request = Request
