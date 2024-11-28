async function handleGetRequest(req) {
    const url = new URL(req.url);
    const path = url.pathname;

    if (path === "/evil_address_change") {
        const evilFile = await Deno.readTextFile("./evil_address_change.php"); // Async read

        return new Response(evilFile, {
            headers: {
                "Content-Type": "text/html",
            },
        });
    } else if (path === "/evil_rfi") {
        const evilFile = await Deno.readTextFile("./evil_rfi.php"); // Async read

        return new Response(evilFile, {
            headers: {
                "Content-Type": "text/html",
            },
        });
    }

    console.log(`GET Request: URL=${req.url}, Path=${path}`);
    return new Response("No one here but us chickens", {
        headers: {
            "Content-Type": "text/html",
            "Access-Control-Allow-Origin": "*", // For CORS policy
        },
    });
}

async function handlePostRequest(req) {
    console.log("Evil got a new POST request");
    const url = new URL(req.url);

    console.log(`POST Request: URL=${req.url}, Path=${url.pathname}`);

    return new Response("No one here but us chickens", {
        headers: {
            "Content-Type": "text/html",
            "Access-Control-Allow-Origin": "*", // For CORS policy
        },
    });
}

// Main server logic
Deno.serve({ port: 80 }, async (req) => {
    try {
        if (req.method === "GET") {
            return await handleGetRequest(req);
        } else if (req.method === "POST") {
            return await handlePostRequest(req);
        }
    } catch (e) {
        console.error("Error processing request:", e);

        const errorHtml = `
        <!DOCTYPE html>
        <html>
        <head>
            <title>Error</title>
        </head>
        <body>
            <h1>Error</h1>
            <p>There was an error processing your request. Please try again later.</p>
            <p>${e.message}</p>
        </body>
        </html>`;

        return new Response(errorHtml, {
            status: 500,
            headers: {
                "Content-Type": "text/html",
            },
        });
    }
});
