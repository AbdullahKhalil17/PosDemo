$(document).ready(function () {
    $(document).on("click", "#update_image", function (e) {
        e.preventDefault();
        if ($("#photo").length == 0) {
            $("#update_image").hide();
            $("#cancel_update_image").show();
            $("#old_image").append(
                '<input type="file" class="form-control" name="photo" id="photo">'
            );
        }
    });

    $(document).on("click", "#cancel_update_image", function (e) {
        e.preventDefault();
        $("#update_image").show();
        $("#cancel_update_image").hide();
        $("#photo").remove();
    });
});





$(document).ready(function(){
  $('#toggleInputsBtn').click(function() {
    $('#hiddenInputs').toggle();
    var buttonText = $('#hiddenInputs').is(':visible') ? 'رجوع' : 'المزيد';
    $(this).text(buttonText);
})

});
