$(function () {
    $("#all_search").on('keyup', function () {
        $('.ticket_listing').DataTable().ajax.reload()
    });
});