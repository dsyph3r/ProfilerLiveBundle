class Database

    constructor: (data) ->
        @data = data


    getQueryCount: ->
        @data.query_count


    getTime: ->
        @data.time


window.Database = Database
