class Mailer

    constructor: (data) ->
        @data = data


    getMessageCount: ->
        @data.message_count


    isSpool: ->
        @data.is_spool


window.Mailer = Mailer
