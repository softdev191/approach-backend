<!DOCTYPE html>
<html
<head>
    <title>Pusher Test</title>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>

        // Enable pusher logging - don't include this in production
        Pusher.logToConsole = true;

        var pusher = new Pusher('c2f30aa9d986edab0381', {
                auth: {
                    headers: {
                        'Authorization': "Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC8xMjcuMC4wLjE6ODAzMFwvYXBpXC9sb2dpbiIsImlhdCI6MTYxNTM3OTk5NCwiZXhwIjoxNjE1MzgzNTk0LCJuYmYiOjE2MTUzNzk5OTQsImp0aSI6IjJHdm5rakxKcDRIdzk3SWoiLCJzdWIiOjEsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.pK0n4g4qu6snLbk5vhnbgzKPybhn2G7f8pw-4s0zBoI"
                    }
                },
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('private-message-1');
        channel.bind('message-sent', function(data) {
            alert(JSON.stringify(data));
        });
    </script>
</head>
<body>
<h1>Pusher Test</h1>
<p>
    Try publishing an event to channel <code>my-channel</code>
    with event name <code>my-event</code>.
</p>
</body>
</html>
