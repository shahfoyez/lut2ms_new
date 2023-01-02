$(document).on("click", ".cd_modal", function () {
    var deleteSlug = $(this).attr('data-item');
    $("#foy_cd_modal").attr("action", deleteSlug)
});
$(document).on("click", ".reach_modal", function () {
    var reachSlug = $(this).attr('data-item');
    $("#foy_reach_modal").attr("action", reachSlug)
});
$(document).on("click", ".cancel_modal", function () {
    var cancelSlug = $(this).attr('data-item');
    $("#foy_cancel_modal").attr("action", cancelSlug)
});
