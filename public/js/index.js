function findParent(element) {
    var parentElement = $(element).parent();
    if ($(parentElement).hasClass("parent"))
        return parentElement;
    else {
        for (var i = 0; i < 12; i++) {
            parentElement = $(parentElement).parent();
            if ($(parentElement).hasClass("parent"))
                return parentElement;
        }
    }
}
function showLoader() {
    $("#pageloader-overlay").addClass("half");
    $('#pageloader-overlay').fadeIn(0);
}
function hideLoader() {
    $("#pageloader-overlay").removeClass("half");
    $('#pageloader-overlay').fadeOut(1000);
    //$("#pageloader-overlay").css("dispaly","none!important");
}
function validateInputs(element)
{
    isValidate = true;
    var form = findParent(element);
    $(form).find(':input').each(function () {
        if ($(this).hasClass("required"))
        {
            if ($(this).val() === "")
            {
                $(this).css("border-color", "red");
                isValidate = false;
            } else
            {
                $(this).css("border-color", "");
            }
        }
    });
    $(form).find('.optional').each(function () {
        if ($(this).hasClass("required"))
        {
            if ($(this).val() === "-1")
            {
                $(this).css("border-color", "red");
                isValidate = false;
            }
//            else
//            {
//                $(this).css("border-color", "");
//                 isValidate = true;
//            }
        }
    });

    if (isValidate === false)
    {
        alert("Fill the required fields");
    }
    return isValidate;
}




