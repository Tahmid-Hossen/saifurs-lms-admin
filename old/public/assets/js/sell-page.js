$(document).ready(function () {
    $(".add-button").click(function () {
        var table = $("#invoice-table tbody");
        table.append(getRowTemplate(1))

    });
});
