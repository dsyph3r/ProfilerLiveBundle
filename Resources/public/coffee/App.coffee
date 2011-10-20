class App

    constructor: (@url, args) ->
        @init()

        args = args ? {}
        @interval = args.interval ? 1000


    init: ->
        @profiles = []
        @token    = ''

        @profileTemplate = _.template($('#profile-template').html())

        # All filters on by default
        @filters =
            'methods'       : ['GET', 'POST', 'PUT', 'DELETE'],
            'status-codes'  : ['200', '300', '400', '500'],
            'content-types' : ['text/html', 'application/json', 'text/xml']
            'url'           : ''

        @resetUI()


    resetUI: =>
        $('#request-url').val('')
        $('input:checkbox').attr('checked', true)


    # Start the profiling
    start: ->
        @getData()


    # Request update
    getData: =>
        if (@token.length)
            $.getJSON(@url + '/' + @token, { }, @handleData)
        else
            $.getJSON(@url, { }, @handleData)


    reset: ->
        @init()


    clearUI: ->
        $('.profiles').html('')


    # Add filter by type
    addFilter: (type, filter) ->
        if (_.isArray(@filters[type]))
            if @isFilterSet(type, filter) isnt true
                @filters[type].push(filter)
        else
            @filters[type] = filter


    # Remove filter by type
    removeFilter: (type, filter) ->
        if (_.isArray(@filters[type]))
            idx = @filters[type].indexOf(filter)
            if idx != -1
                @filters[type].splice(idx, 1)
        else
            @filters[type] = filter


    # Check if filter is set
    isFilterSet: (type, filter) ->
        idx = @filters[type].indexOf(filter)
        if idx != -1 then true else false


    getFilters: ->
        @filters


    # Process server update
    handleData: (data) =>
        # Save the last token identifier from this update
        @token = data.last_token

        # Process the profiles and their children
        for index, profile of data.profiles

            children = []
            if profile.children?
                for child in profile.children
                    children.push(@createProfileFromRaw(child))

            @profiles.push(@createProfileFromRaw(profile, children))

        @render()

        # Setup another update request
        window.setTimeout(@getData, @interval)


    # Process the Raw response to create a Profile
    createProfileFromRaw: (profile, children) ->
        profileArgs = {}

        if profile.request?
            profileArgs.request = new Request(profile.request)

        if profile.response?
            profileArgs.response = new Response(profile.response)

        if profile.memory?
            profileArgs.memory = new Memory(profile.memory)

        if profile.timer?
            profileArgs.timer = new Timer(profile.timer)

        if profile.exception?
            profileArgs.exception = new Exception(profile.exception)

        if profile.mailer?
            profileArgs.mailer = new Mailer(profile.mailer)

        if profile.database?
            profileArgs.database = new Database(profile.database)

        profileArgs.children = children

        profile = new Profile(profile.token, profileArgs)


    generateProfilerUrl: (token, panel) ->
        '/app_dev.php/_profiler/' + token + '?panel=' + panel


    # Render the profiles - Profiles are filtered before rendering
    render: () ->

        @clearUI()

        # Get a filtered collection
        filtered = _(@profiles).select((profile) =>
            # Do the filter
            if (profile.getRequest().getMethod() in @filters['methods'] &&
               (profile.getResponse().getStatusCodeClass() + '00') in @filters['status-codes'] &&
               profile.getResponse().getContentType() in @filters['content-types'] &&
               profile.getRequest().getRequestUri().indexOf(@filters['url']) isnt -1)
                return true
            else
                return false
        )

        # Render the filtered collection
        for index, profile of filtered
            @renderProfile profile


    # Render a profile and its children
    renderProfile: (profile) ->

        # Render the master profile
        profileHtml = @profileTemplate
            profile: profile
            app: this
            child: false

        # Render any child profiles
        for index, profile of profile.getChildren()
            profileHtml += @profileTemplate
                profile: profile
                app: this
                child: true

        $('.profiles').prepend(profileHtml);


window.App = App
