class Exception

    constructor: (data) ->
        @data = data


    getClass: ->
        @data['class']


    getMessage: ->
        @data.message


    getStatusCode: ->
        @data.status_code


window.Exception = Exception
