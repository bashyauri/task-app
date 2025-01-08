const HttpVerbType = {
    GET: "GET",
    POST: "POST",
    PUT: "PUT",
    DELETE: "DELETE",
};

export async function makeHttpReq(endpoint, httpVerbType, data = null) {
    if (!Object.values(HttpVerbType).includes(httpVerbType)) {
        throw new Error(`Invalid HTTP verb: ${httpVerbType}`);
    }

    const options = {
        method: httpVerbType,
        headers: {
            "Content-Type": "application/json",
        },
    };

    if (
        data &&
        (httpVerbType === HttpVerbType.POST ||
            httpVerbType === HttpVerbType.PUT)
    ) {
        options.body = JSON.stringify(data);
    }

    try {
        const response = await fetch(endpoint, options);
        if (!response.ok) {
            throw new Error("Network response was not ok");
        }
        const responseData = await response.json();
        return responseData;
    } catch (error) {
        console.error("There was a problem with the fetch operation:", error);
        throw error;
    }
}
