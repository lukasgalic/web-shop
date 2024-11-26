The evil server.

The server running internally is "deno" (why? because its a new alternative to node and i wanted to try it out, works great as far as i can tell). 
It has a lot of standard features that we usually would need to import from untrusted packages. It also more strictly controls device permissions. We only give it network allowance.

The server that is running is very simplistic, internally it listens on :80 (Which we redirect to :9000) and just handles the requests straight up.

Depending on what url, path or parameter; you can just expand the handler and add your response that you want for any specific path. 
This means it's quite easy to add a new request or response to what specifically you need.

# Debugging:

To debug your requests (finding you if your evil does what its supposed to do). You can use a tool like postman or talendAPI tester (a chrome extension) (Dominik recommends this, easy to use for beginners) to manually craft requests and send them, there you can check that your evil does what you expect it to do.