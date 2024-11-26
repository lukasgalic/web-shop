
/* this is for completeness, how you'd get the body and headers of a request

const url = new URL(req.url);
console.log("Path:", url.pathname);
console.log("Query parameters:", url.searchParams);

console.log("Headers:", req.headers);

if (req.body) {
    const body = await req.text();
    console.log("Body:", body);
}

return new Response("Hello, World!");
*/


function handleGetRequest(req: Request) {
    console.log("Evil got new GET request: ", req)
    const url = new URL(req.url);

    return new Response("GET Request. URL: " + req.url + " body: " + req.body + " params: " + url.searchParams);
}

function handlePostRequest(req: Request) {
    console.log("Evil got new POST request: ", req)
    const url = new URL(req.url);

    return new Response("POST Request. URL: " + req.url + " body: " + req.body + " params: " + url.searchParams);
}

Deno.serve({ port: 80 }, async (req) => {
    console.log("Evil got new request: ", req)

    console.log("Method:", req.method);

    if (req.method === "GET") {
        return handleGetRequest(req)
    }
    else if (req.method === "POST") {
      return handlePostRequest(req)
    }


    });