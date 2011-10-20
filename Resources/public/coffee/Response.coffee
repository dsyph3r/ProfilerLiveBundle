class Response

    constructor: (data) ->
        @data = data


    getData: ->
        @data


    getStatusCode: ->
        @data.status_code


    getStatusCodeClass: ->
        @getStatusCode().toString().substr(0, 1)


    getContentType: ->
        @data.content_type


    getController: ->
        @data.controller


    getRoute: ->
        @data.route


window.Response = Response
