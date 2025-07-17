$(document).ready(() => {
    const token = localStorage.getItem("token");
    if (token) {
        $.ajax({
            url: "/api/check-auth",
            method: "GET",
            headers: {
                Authorization: "Bearer " + token,
            },
            success: function () {
                // return;
            },
            error: function (xhr) {
                if (xhr.status === 401) {
                    localStorage.removeItem("token");
                    window.location.href = "/login";
                }
            },
        });
    } else {
        window.location.href = "/login";
    }
});
