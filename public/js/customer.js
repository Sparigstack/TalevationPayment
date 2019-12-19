$(document).ready(function () {
    var email = document.getElementById('a2Email');
    var arr = new Array();
    populateA2Customers(email, arr);
//    CustomerList();

});

function OnEmailSearch(element) {
    $("#CustomerDetails").addClass('hidden');
    $("#saveCustomerBtn").addClass('hidden');
    $(".saveCreateInvoice").addClass('hidden');


    var val = element.value;
    /*close any already open lists of autocompleted values*/
    closeAllLists(null, element);
    if (!val) {
        return false;
    }
    var CSRF_TOKEN = $('input[name="_token"]').val();
    var input = element;
    $.ajax({
        url: 'getEmail',
        type: 'post',
        //async: false,
        data: {_token: CSRF_TOKEN, email: val},
        success: function (response) {

            $("#a2Emailautocomplete-list").remove();
            var a, b, i,
                    //alert(response);
                    arr = response;
            //populateA2Customers(element, response);

            currentFocus = -1;
            /*create a DIV element that will contain the items (values):*/
            a = document.createElement("DIV");
            a.setAttribute("id", input.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items customerAutoComplete");
            /*append the DIV element as a child of the autocomplete container:*/
            input.parentNode.appendChild(a);
            /*for each item in the array...*/
            for (i = 0; i < arr.length; i++) {
                /*check if the item starts with the same letters as the text field value:*/
                //        if (arr[i]['label'].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                var stringtoUpperCase = val.toUpperCase();
                var Fromarray = arr[i]['Email'].toUpperCase();
                if (Fromarray.includes(stringtoUpperCase)) {
                    /*create a DIV element for each matching element:*/
                    b = document.createElement("DIV");

                    /*make the matching letters bold:*/
                    var stringindex = arr[i]['Email'].toLowerCase().indexOf(val.toLowerCase());
                    b.innerHTML = arr[i]['Email'].substr(0, stringindex);
                    b.innerHTML += "<strong>" + arr[i]['Email'].substr(stringindex, val.length) + "</strong>";
                    b.innerHTML += arr[i]['Email'].substr(parseInt(stringindex + val.length));
                    /*insert a input field that will hold the current array item's value:*/
//                        b.innerHTML += "<input  type='hidden' class='searchContent' value='" + arr[i]['Email'] + "'id='" + arr[i]['id'] + "'>";
                    b.innerHTML += "<input  type='hidden' class='searchContent' SiteNumber ='" + arr[i]["SiteNumber"] + "'Anniversary_Date='" + arr[i]["Anniversary_Date"] + "'QBID='" + arr[i]["QBID"] + "'AccountID  ='" + arr[i]["AccountID"] + "'ContactID ='" + arr[i]["ContactID"] + "'companyName='" + arr[i]["CompanyName"] + "'lastName='" + arr[i]["Last_Name"] + "'firstName='" + arr[i]["First_Name"] + "'add1='" + arr[i]["Street1"] + "'add2='" + arr[i]["Street2"] + "'city='" + arr[i]["City"] + "'state='" + arr[i]["State"] + "'zipcode='" + arr[i]["Zip"] + "'value='" + arr[i]['Email'] + "'id='" + arr[i]['id'] + "'>";
                    /*execute a function when someone clicks on the item value (DIV element):*/
                    b.addEventListener("click", function (e) {
                        /*insert the value for the autocomplete text field:*/

                        var div = $(this);
                        $("#email").addClass("fromA2");
                        input.value = this.getElementsByTagName("input")[0].value;

                        /*close the list of autocompleted values,
                         (or any other open lists of autocompleted values:*/
                        closeAllLists();
                        $("#searchDivSection").empty();
                        $("#searchDivSection").append(this);
                        $("#customerDb_id").val($(".searchContent").attr("id"));
                        $("#companyName").val($(".searchContent").attr("companyName"));
                        $("#first_name").val($(".searchContent").attr("firstname"));
                        $("#last_name").val($(".searchContent").attr("lastname"));
                        $("#email").val(this.getElementsByTagName("input")[0].value);
                        $("#emailAddress").val(this.getElementsByTagName("input")[0].value);


                        if ($(".searchContent").attr("add1") != 'null')
                            $("#add1").val($(".searchContent").attr("add1"));

                        if ($(".searchContent").attr("add2") != 'null')
                            $("#add2").val($(".searchContent").attr("add2"));

                        if ($(".searchContent").attr("state") != 'null')
                            $("#state").val($(".searchContent").attr("state"));

                        if ($(".searchContent").attr("city") != 'null')
                            $("#city").val($(".searchContent").attr("city"));

                        if ($(".searchContent").attr("zipcode") != 'null')
                            $("#zipcode").val($(".searchContent").attr("zipcode"));

                        if ($(".searchContent").attr("accountid") != '')
                            $("#a2_accountId").val($(".searchContent").attr("accountid"));

                        if ($(".searchContent").attr("contactid") != '')
                            $("#a2_contactId").val($(".searchContent").attr("contactid"));

                        if ($(".searchContent").attr("qbid") != '')
                            $("#qb_customerId").val($(".searchContent").attr("qbid"));

                        if ($(".searchContent").attr("anniversary_date") != '')
                            $("#anniversary_Date").val($(".searchContent").attr("anniversary_date"));

                        if ($(".searchContent").attr("sitenumber") != '')
                            $("#siteNumber").val($(".searchContent").attr("sitenumber"));

                        if ($(".searchContent").attr("phone") != '')
                            $("#phone").val($(".searchContent").attr("phone"));

                        var inv_siteNumber = $(".searchContent").attr("sitenumber");
                        var inv_anniversary_Date = $(".searchContent").attr("anniversary_date");

                        var dt = new Date(inv_anniversary_Date);

                        var dateMonth = dt.getMonth() + 1;
                        var DateValue = dt.getDate();
                        var memoString = "";

                        if (isNaN(dateMonth)) {
                            dateMonth = "";
                            DateValue = "";
                        }


                        if (inv_siteNumber != "" && inv_anniversary_Date != "") {
                            memoString = "Site #" + inv_siteNumber + '\n' + "Renewal Date: " + dateMonth + "/" + DateValue;
                        } else if (inv_anniversary_Date != "" && inv_siteNumber == "") {
                            memoString = "Renewal Date: " + dateMonth + "/" + DateValue;
                        } else if (inv_anniversary_Date == "" && inv_siteNumber != "") {
                            memoString = "Site #" + inv_siteNumber;
                        }

                        var memo = $("#memo").val(memoString);




                        $("#CustomerDetails").removeClass('hidden');
                        $("#saveCustomerBtn").removeClass('hidden');
                        $(".saveCreateInvoice").removeClass('hidden');

//                    redirectToSpace(this);
                    });
                    a.appendChild(b);
                }
            }
        }
    });
}

function closeAllLists(elmnt, curInp) {
    /*close all autocomplete lists in the document,
     except the one passed as an argument:*/
    var x = document.getElementsByClassName("autocomplete-items");
    for (var i = 0; i < x.length; i++) {
        if (elmnt != x[i] && elmnt != curInp) {
            x[i].parentNode.removeChild(x[i]);
        }
    }
}
var currentFocus;

var typewatch = (function () {
    var timer = 0;
    return function (callback, ms) {
        clearTimeout(timer);
        timer = setTimeout(callback, ms);
    };
})();

function populateA2Customers(inp, arr) {
//    var searchBtn = document.getElementById('searchBtn');
    /*the autocomplete function takes two arguments,
     the text field element and an array of possible autocompleted values:*/

    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function (e) {
        var currentInput = this;
        typewatch(function () {
            OnEmailSearch(currentInput)// executed only 500 ms after the last keyup event.
        }, 500);
        //OnEmailSearch(this);



    });
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function (e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x)
            x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
            /*If the arrow DOWN key is pressed,
             increase the currentFocus variable:*/
            currentFocus++;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 38) { //up
            /*If the arrow UP key is pressed,
             decrease the currentFocus variable:*/
            currentFocus--;
            /*and and make the current item more visible:*/
            addActive(x);
        } else if (e.keyCode == 13) {
            /*If the ENTER key is pressed, prevent the form from being submitted,*/
            e.preventDefault();
            if (currentFocus > -1) {
                /*and simulate a click on the "active" item:*/
                if (x)
                    x[currentFocus].click();
            }
        }
    });
    function addActive(x) {
        /*a function to classify an item as "active":*/
        if (!x)
            return false;
        /*start by removing the "active" class on all items:*/
        removeActive(x);
        if (currentFocus >= x.length)
            currentFocus = 0;
        if (currentFocus < 0)
            currentFocus = (x.length - 1);
        /*add class "autocomplete-active":*/
        x[currentFocus].classList.add("autocomplete-active");
    }
    function removeActive(x) {
        /*a function to remove the "active" class from all autocomplete items:*/
        for (var i = 0; i < x.length; i++) {
            x[i].classList.remove("autocomplete-active");
        }
    }


    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
}


function showHideCustomerDetails(showHide) {
    var btna2Customer = $("#btna2Customer").val();
    if (btna2Customer == "Go back to A2 lookup") {
        $("#a2Email").removeAttr("disabled");
        $("#btna2Customer").val("Add New Customer");
        $("#CustomerDetails").addClass('hidden');
        $("#saveCustomerBtn").addClass('hidden');
        $(".saveCreateInvoice").addClass('hidden');
    } else if (btna2Customer == "Add New Customer") {
        $("#btna2Customer").val("Go back to A2 lookup")
        $("#a2Email").val("");
        $("#a2Email").attr("disabled", "disabled");
        $("#CustomerDetails").find("input").val("");
        $("#CustomerDetails").removeClass('hidden');
        $("#saveCustomerBtn").removeClass('hidden');
        $(".saveCreateInvoice").removeClass('hidden');
        $("#a2_accountId").val("");
        $("#a2_contactId").val("");
        $("#siteNumber").val("");
        $("#qb_customerId").val("");
        $("#anniversary_Date").val("");
        $("#memo").val("");
    }


}




function saveCreateInvoice(element) {
    var isValidate = validateInputs(element);
    if (isValidate == true) {
        var CSRF_TOKEN = $('input[name="_token"]').val();
        var companyName = $("#companyName").val();
        var emailAddress = $("#emailAddress").val();
        var first_name = $("#first_name").val();
        var last_name = $("#last_name").val();
        var add1 = $("#add1").val();
        var add2 = $("#add2").val();
        var state = $("#state").val();
        var city = $("#city").val();
        var zipcode = $("#zipcode").val();
        var a2_accountId = $(".searchContent").attr('accountid');
        var a2_contactId = $(".searchContent").attr('contactid');
        var qb_customerId = $(".searchContent").attr('qbid');
        var anniversary_Date = $("#anniversary_Date").val();
        var siteNumber = $("#siteNumber").val();
        var from = "saveCreateInvoice";
        var cus_GUID = $("#cus_GUID").val();
        var companyName_Invoice = $("#companyName_Invoice").val(companyName);
        showLoader();
        $.ajax({
            url: 'addCustomer',
            type: 'post',
            data: {_token: CSRF_TOKEN, siteNumber: siteNumber, anniversary_Date: anniversary_Date, cus_GUID: cus_GUID, qb_customerId: qb_customerId, a2_accountId: a2_accountId, a2_contactId: a2_contactId, from: from, companyName: companyName, emailAddress: emailAddress, first_name: first_name, last_name: last_name, add1: add1, add2: add2, state: state, city: city, zipcode: zipcode},
            success: function (response) {

                appendClick(response, "saveCreateInvoice");
                hideLoader();
            }
        });
    }


}



function createCustomer(element) {
    var parent = findParent(element);
    $("#invoiceItemTable").find('tbody').find('.clonnedInvoiceItem').remove();

    $("#InvoiceItemsDetails").addClass('hidden');
    $(".save_send").addClass('hidden');
    $(".saveInvoiceItems").addClass('hidden');
    $("#InvoiceDetails").removeClass('hidden');
    //$("#addInvoice_saveCreateInvoice").click();

    var invId = $("#customerId_fromcreateInvoice").val($(parent).find(".fromInv_customerId").val());
    $("#customer").val($(parent).find('.email_customer').text());
    $("#Email").val($(parent).find('.email_customer').text());
    $("#inv_firstname").val($(parent).find('.fname_customer').val());
    $("#inv_lastname").val($(parent).find('.lname_customer').val());
    $("#CompanyName_Invoices").val($(parent).find('.cName_customer').text());
    $("#inv_add1").val($(parent).find('.add1_customer').val());
    $("#inv_add2").val($(parent).find('.add2_customer').val());

    $("#inv_state").val($(parent).find('.state_customer').val());
    $("#inv_city").val($(parent).find('.city_customer').val());

    $("#inv_anniversary_Date").val($(parent).find('.add2_anniversary_date').val());
    $("#inv_siteNumber").val($(parent).find('.add2_site_number').val());
//$("#inv_terms").val();
    $("#inv_terms").val($("#inv_terms option:first").val());
    var inv_siteNumber = $(parent).find('.add2_site_number').val();
    var inv_anniversary_Date = $(parent).find('.add2_anniversary_date').val();
    var dt = new Date(inv_anniversary_Date);

    var dateMonth = dt.getMonth() + 1;
    var DateValue = dt.getDate();
    var memoString = "";
    if ((inv_siteNumber != "" || inv_anniversary_Date != "")) {
        if (inv_siteNumber != "" && inv_anniversary_Date != "null") {
            memoString = "Site #" + inv_siteNumber + '\n' + "Renewal Date: " + dateMonth + "/" + DateValue;
        } else if (inv_anniversary_Date != "null" && inv_siteNumber == "") {
            memoString = "Renewal Date: " + dateMonth + "/" + DateValue;
        } else if (inv_anniversary_Date == "null" && inv_siteNumber != "") {
            memoString = "Site #" + inv_siteNumber;
        }
    }
    var memo = $("#memo").val(memoString);


    $("#inv_zip").val($(parent).find('.zipcode_customer').val());
    $(".saveInvoice").removeClass('hidden');

    checkForPresetItems('addnew');

}


