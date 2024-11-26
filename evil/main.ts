
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


async function handleGetRequest(req: Request) {
    console.log("Evil got new GET request")
    const url = new URL(req.url);
    const path = url.pathname;
    if (path === "/evil_address_change") {
        const evilFile = await Deno.readTextFileSync("./evil_address_change.php")

        return new Response("evilawdawdFile" + evilFile, {
            headers: {
                "Content-Type": "text/html",
            },
        });
    }

    return new Response("GET Request. URL: " + req.url + " body: " + req.body + " params: " + url.searchParams + " pathname: " + path);
}

async function handlePostRequest(req: Request) {
    console.log("Evil got new POST request")
    const url = new URL(req.url);

    return new Response("POST Request. URL: " + req.url + " body: " + req.body + " params: " + url.searchParams);
}

Deno.serve({ port: 80 }, async (req) => {

    try {
    
        if (req.method === "GET") {
            return await handleGetRequest(req)
        }
        else if (req.method === "POST") {
            return await handlePostRequest(req)
        }
    } catch (e) {
        
        const errorHtml =
        `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Error</title>
        </head>
        <body>
            <h1>Error</h1>
            <p>There was an error processing your request. Please try again later.</p>
            <p>${e}</p>
        </body>
        </html>
        `


        return new Response(errorHtml, {
            status: 500,
            headers: {
                "Content-Type": "text/html",
            },
        })
    }


    });