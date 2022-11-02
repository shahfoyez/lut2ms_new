$(document).on("click", ".cd_modal", function () {
    var deleteSlug= $(this).attr('data-item');
    $("#foy_cd_modal").attr("action", deleteSlug)
});
