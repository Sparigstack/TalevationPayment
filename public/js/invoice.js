$(document).ready(function () {
    var customer = document.getElementById("customer");
    var arr = new Array();
    populateCustomers(customer, arr);


    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    //var end = new Date(date.getFullYear(), date.getMonth(), date.getDate());
    $('#invoice-date').datepicker({
        todayHighlight: true,
        format: "mm/dd/yyyy"
    });
    $('#due-date').datepicker({
        todayHighlight: true,
        format: "mm/dd/yyyy"
    });





//    $("#addInvoice").find("#default-datepicker2").val($("#default-datepicker2").val());
});
var currentFocus;
function OnCustomerSearch(element) {
    $("#InvoiceDetails").addClass('hidden');
    $(".saveInvoice").addClass("hidden");
    var a, b, c, i, val = element.value;
    /*close any already open lists of autocompleted values*/
    closeAllLists(null, element);
    if (!val) {
        return false;
    }

    var customer = $('#customer').val();
    var fName = $(".searchContent").attr("firstname");
    var input = element;
    var CSRF_TOKEN = $('input[name="_token"]').val();
    showInputLoader(input);
    $.ajax({
        url: 'getCustomerFromdb',
        type: 'post',
//        async: false,
        data: {_token: CSRF_TOKEN, customer: customer},
        success: function (response) {
//                console.log(response);
            hideInputLoader(input);
            var existingList = $("#" + input.id + "autocomplete-list");
            if (existingList != null && existingList != undefined && existingList.length > 0)
                $(existingList).remove();

            arr = response;

            currentFocus = -1;
            /*create a DIV element that will contain the items (values):*/
            var a = document.createElement("DIV");
            a.setAttribute("id", input.id + "autocomplete-list");
            a.setAttribute("class", "autocomplete-items invoiceAutoComplete");

            /*append the DIV element as a child of the autocomplete container:*/
            input.parentNode.appendChild(a);

//        var c = document.getElementById("myDiv");
//        var aTag = document.createElement('a');
//        aTag.setAttribute('href', "yourlink.htm");
//        aTag.innerHTML = "link text";
//        a.appendChild(aTag);
            c = document.createElement("DIV");
            c.setAttribute("id", input.id + "Default");
            c.setAttribute("onclick", "return appendClick('" + input.value + "','fromADDInvoice');");
            c.innerHTML = "<i class='fa fa-plus'></i> Add Customer";
            a.appendChild(c);



            /*for each item in the array...*/
            for (i = 0; i < arr.length; i++) {

                /*check if the item starts with the same letters as the text field value:*/
                //        if (arr[i]['label'].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
                var stringtoUpperCase = val.toUpperCase();
                var Fromarray = arr[i]['email'].toUpperCase();

                if (Fromarray.includes(stringtoUpperCase)) {
                    /*create a DIV element for each matching element:*/
                    b = document.createElement("DIV");
                    /*make the matching letters bold:*/

                    var stringindex = arr[i]['email'].toLowerCase().indexOf(val.toLowerCase());
                    b.innerHTML = arr[i]['first_name'] + "  " + arr[i]['last_name'] + " ";
                    b.innerHTML += arr[i]['email'].substr(0, stringindex);
                    b.innerHTML += "<strong>" + arr[i]['email'].substr(stringindex, val.length) + "</strong>";
                    b.innerHTML += arr[i]['email'].substr(parseInt(stringindex + val.length));
                    /*insert a input field that will hold the current array item's value:*/
                    b.innerHTML += "<input  type='hidden' class='searchContentInvoice' SiteNumber ='" + arr[i]["site_number"] + "'Anniversary_Date='" + arr[i]["anniversary_date"] + "'companyName='" + arr[i]["name"] + "'GUID='" + arr[i]["GUID"] + "' db-customerID='" + arr[i]["id"] + "'lastName='" + arr[i]["last_name"] + "'firstName='" + arr[i]["first_name"] + "'add1='" + arr[i]["address1"] + "'add2='" + arr[i]["address2"] + "'city='" + arr[i]["city_name"] + "'state='" + arr[i]["state_name"] + "'zipcode='" + arr[i]["zipcode"] + "'value='" + arr[i]['email'] + "'id='" + arr[i]['id'] + "'>";
                    /*execute a function when someone clicks on the item value (DIV element):*/
                    b.addEventListener("click", function (e) {
                        /*insert the value for the autocomplete text field:*/

                        var div = $(this);
                        $("#customer").addClass("fromDb");
                        input.value = this.getElementsByTagName("input")[0].value;





//                    inp.setAttribute("firstName",this.attr("input")[0].value; );
//                     inp.setAttribute("LastName",arr[i]['last_name'] );
                        /*close the list of autocompleted values,
                         (or any other open lists of autocompleted values:*/
                        closeAllLists();
                        $("#searchDivSection_Invoice").empty();
                        $("#searchDivSection_Invoice").append(this);



                        $("#customerDb_id").val($(".searchContentInvoice").attr("db-customerID"));
                        $("#CompanyName_Invoices").val($(".searchContentInvoice").attr("companyName"));
                        $("#inv_firstname").val($(".searchContentInvoice").attr("firstname"));
                        $("#inv_lastname").val($(".searchContentInvoice").attr("lastname"));
                        $("#Email").val(this.getElementsByTagName("input")[0].value);
                        $("#inv_add1").val($(".searchContentInvoice").attr("add1"));
                        var address2 = $(".searchContentInvoice").attr("add2");
                        if (address2 != null)
                            $("#inv_add2").val();
                        else
                            $("#inv_add2").val(address2);
                        $("#inv_state").val($(".searchContentInvoice").attr("state"));
                        $("#inv_city").val($(".searchContentInvoice").attr("city"));
                        $("#inv_zip").val($(".searchContentInvoice").attr("zipcode"));
                        $("#anniversary_Date").val($(".searchContentInvoice").attr("anniversary_date"));
                        $("#siteNumber").val($(".searchContentInvoice").attr("sitenumber"));
                        $("#companyName_Invoice").val($(".searchContentInvoice").attr("companyName"));
                        $("#InvoiceDetails").removeClass('hidden');
                        $("#saveInvoiceBtn").removeClass('hidden');
                        $(".saveInvoice").removeClass("hidden");
//                            $('#invoice-date').val('setDate', today);

                        var inv_siteNumber = $(".searchContentInvoice").attr("sitenumber");
                        var inv_anniversary_Date = $(".searchContentInvoice").attr("anniversary_date");


                        var dt = new Date(inv_anniversary_Date);
                        if (inv_siteNumber != "" || inv_anniversary_Date != "") {
                            var dateMonth = dt.getMonth() + 1;
                            var DateValue = dt.getDate();
                        }
                        var memoString = "";
                        if (inv_siteNumber != "" && inv_anniversary_Date != "null") {
                            memoString = "Site #" + inv_siteNumber + '\n' + "Renewal Date: " + dateMonth + "/" + DateValue;
                        } else if (inv_anniversary_Date != "null" && inv_siteNumber == "") {
                            memoString = "Renewal Date:" + dateMonth + "/" + DateValue;
                        } else if (inv_anniversary_Date == "null" && inv_siteNumber != "") {
                            memoString = "Site #" + inv_siteNumber;
                        }

                        var memo = $("#memo").val(memoString);





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

function populateCustomers(inp, arr) {
//    var searchBtn = document.getElementById('searchBtn');
    /*the autocomplete function takes two arguments,
     the text field element and an array of possible autocompleted values:*/


    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function (e) {
        var currentInput = this;
        typewatch(function () {
            OnCustomerSearch(currentInput)// executed only 500 ms after the last keyup event.
        }, 500);
        //OnCustomerSearch(this);
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
var typewatch = (function () {
    var timer = 0;
    return function (callback, ms) {
        clearTimeout(timer);
        timer = setTimeout(callback, ms);
    };
})();


function editCustomer(element) {
    $("#InvoiceDetails").removeClass("hidden");
    $("#customer").removeClass("hidden");
    $(".saveInvoiceItems").addClass("hidden");
    $(".save_send").addClass("hidden");
    $(".saveInvoice").removeClass("hidden");
    $("#InvoiceItemsDetails").addClass("hidden");
    $("#contentToShow").text("Lookup  Customer by Email");
    $("#edit_customer").addClass("hidden");

}

//function emailAddress(element) {
//    var email = $(element).val();
//    var CSRF_TOKEN = $('input[name="_token"]').val();
//    $.ajax({
//        url: 'getEmail',
//        type: 'post',
//        data: {_token: CSRF_TOKEN, email: email},
//        success: function (response) {
//            console.log(response);
////            populateCustomers(document.getElementById("email"), response);
////            var customerrecords = $("#default-datatable").find('tbody').find('tr');
////            var hasClass = ($(element).hasClass("fromA2"));
////            for (var l = 0; l < customerrecords.length; l++) {
////                var fromdbemail = customerrecords[l].childNodes[3].innerHTML;
////                if (hasClass == true && fromdbemail == email) {
////                    for (var i = 0; i < response.length; i++) {
////                        $("#companyName").val(response[i]['value']);
////                        $("#first_name").val(response[i]['first_name']);
////                        $("#last_name").val(response[i]['last_name']);
////                        $("#add1").val(response[i]['add1']);
////                        $("#add2").val(response[i]['add2']);
////                        $("#state").val(response[i]['state']);
////                        $("#city").val(response[i]['city']);
////                        $("#zipcode").val(response[i]['zipcode']);
////                    }
////                }
////            }
//
//
//
//        }
//    });
//}
//function emailAddress(element) {
//    var email = $(element).val();
//    var CSRF_TOKEN = $('input[name="_token"]').val();
//    $.ajax({
//        url: 'getEmail',
//        type: 'post',
//        data: {_token: CSRF_TOKEN, email: email},
//        success: function (response) {
//          
//        }
//    });
//}


function appendClick(element, from) {

    if (from == "fromADDInvoice") {
        $("#addInvoice_form").find(".close").click();
        $("#AddNewCustomer").click();
        $("#addCustomer").find("#first_name").val(element);


    }
    if (from == "saveCreateInvoice") {
        $("#addCustomer").find(".close").click();
        $("#addInvoice_saveCreateInvoice").click();
        $("#addInvoice_form").find("#customer").val(element['email']);
        $("#customerDb_id").val(element['id']);
        $("#inv_firstname").val(element['first_name']);
        $("#CompanyName_Invoices").val(element['name']);
        $("#inv_lastname").val(element['last_name']);
        $("#Email").val(element['email']);
        $("#inv_add1").val(element['address1']);
        $("#inv_add2").val(element['address2']);
        $("#inv_state").val(element['state_name']);
        $("#inv_city").val(element['city_name']);
        $("#inv_zip").val(element['zipcode']);
        $("#inv_siteNumber").val(element['site_number']);
        $("#inv_anniversary_Date").val(element['anniversary_date']);
        $("#InvoiceDetails").removeClass('hidden');
        $(".saveInvoice").removeClass('hidden');

        //AddNewInvoice();
        //checkForPresetItems('addnew');
    }
}
function datesByTerms(element) {
    $("#due-date").removeAttr('disabled');
    var date = "";
    var numberOfDaysToAdd = 0;
    var termsValue = $("#inv_terms option:selected").attr('id');
    if (termsValue == "1")
        numberOfDaysToAdd = 10;
    if (termsValue == "2")
        numberOfDaysToAdd = 30;
    if (termsValue == "3")
        numberOfDaysToAdd = 90;
    if (termsValue == "4") {
        numberOfDaysToAdd = 40;
        $("#due-date").attr('disabled', 'disabled');
        $("#due-date").removeClass('required');
        $("#due-date").attr('value', '');
    }
    if (termsValue == "5") {
        $("#due-date").addClass('required');
        $("#due-date").attr('value', '');
    }

    var date = new Date($('#invoice-date').val());
    var newdate = new Date(date);
    newdate.setDate(newdate.getDate() + numberOfDaysToAdd);


    var dd = newdate.getDate();
    for (var i = 0; i < 9; i++) {
        if (dd < 10)
            dd = '0' + newdate.getDate();
    }
    var mm = newdate.getMonth() + 1;
    var y = newdate.getFullYear();
    var someFormattedDate = mm + '/' + dd + '/' + y;
    if (termsValue == "4")
        $('#due-date').val("");
    else
        $('#due-date').val(someFormattedDate);
    if (termsValue == "5")
        $('#due-date').val("");
}
function getBaseURL() {
    var urlString = window.location.host;
    var httpString = "http://";
    var domainString = "";
    if ((urlString.toLowerCase()).indexOf('127.0.0.1') !== -1 || (urlString.toLowerCase()).indexOf('dev') !== -1) {
        if ((urlString.toLowerCase()).indexOf('dev') !== -1) {
            domainString = "/TalevationPayment/public";
            httpString = "https://";
        }
    } else {
        domainString = "/TalevationPayment/public";
    }
    var fullBaseURL = httpString + urlString + domainString;

    return fullBaseURL;
}
function showHideInvoiceDetails(element) {
    var isValidate = validateInputs(element);
    var parent = findParent(element);

    if (isValidate == true) {
        var inv_firstname = $("#inv_firstname").val();
        var inv_lastname = $("#inv_lastname").val();
        var string = inv_firstname + " " + inv_lastname + " (" + $("#customer").val() + ")";
        $("#contentToShow").text(string);
        $("#customer").addClass('hidden');
        $("#InvoiceDetails").addClass('hidden');
        $(".saveInvoice").addClass('hidden');

//        if ($('#invoiceItemTable').hasClass('NewItem')) {
//            $('#hiddenTrTag').each(function () {
////                alert($(this));
//                $(this).addClass('hiddenTrTag2');
//            });
//            $('.hiddenTrTag2').each(function () {
////                alert($(this));
//                $(this).remove();
//            });
//        }
        $("#invoiceItemTable").removeClass('hidden');
        $(".saveInvoiceItems").removeClass('hidden');
        $(".save_send").removeClass('hidden');
        $("#InvoiceItemsDetails").removeClass('hidden');
        $("#edit_customer").removeClass("hidden");

        var inv_state = $("#InvoiceDetails").find("#inv_state").val();
        var state_tax_id = $(parent).find("#state_tax_id").val();
        var matchFound = false;

        var selectedItem = $(".state_name option[id='" + state_tax_id + "']");
        if (selectedItem != null && selectedItem.length > 0) {
            $(".state_name option[id='" + state_tax_id + "']").attr("selected", "selected");
        } else {
            $(".state_name option").each(function () {
                if (state_tax_id == $(this).attr("id"))
                    matchFound = true;
                else if ($(this).text().toLowerCase().indexOf(inv_state.toLowerCase()) >= 0)
                    matchFound = true;

                if (matchFound) {
                    $(this).prop('selected', true);
                    return false;
                } else {
                    $(this).prop('selected', false);
                }
                //, 'selected');
            });
        }





        SetTaxableValue();
    }
}
function setInvoiceDetails(element) {
    var presetItems = $('option:selected', element);
    var parent = findParent(element);
    var presetItem = presetItems.attr('id');
    if (presetItem == -1) {
        $(parent).find(".descValue").val('');
        $(parent).find(".qtyValue").val('');
        $(parent).find(".rateValue").val('');
        $(parent).find(".totalValue").text('$' + 0);
//        $(parent).find(".isTaxable").prop('checked', false);

    } else {
        $(parent).find(".descValue").val($(presetItems).attr('desc'));
        $(parent).find(".qtyValue").val('1');
        $(parent).find(".rateValue").val($(presetItems).attr('price'));
        var Total = parseFloat(1 * $(presetItems).attr('price') + 0);
        $(parent).find(".totalValue").text('$' + Total);
    }

    var totalPriceSum = 0;
    $(".totalValue").each(function (e) {
        if (!$(this).parent().parent().hasClass("hidden")) {
            var totalPrice = $(this).text().replace('$', '');
            totalPriceSum += Number(totalPrice);
        }
    });
    $(".invoiceTotalPrice").text('$' + totalPriceSum.toFixed(2));
    $(".invoiceTotalBalance").text('$' + totalPriceSum.toFixed(2));

    SetTaxableValue();
}


function InsertInvoiceItems(element) {
    var isValidateInvoiceTable = false;
    $("#invoiceItemTable").find("tbody").find("tr").each(function (e) {
        if ($(this).hasClass("hidden") != true) {
            if ($(this).hasClass("parent") == true) {
                var presetItemValuefeild = $(this).find(".preset_line_items").val();
                var descValuefeild = $(this).find(".descValue").val();
                var qtyValuefeild = $(this).find(".qtyValue").val();
                var rateValuefeild = $(this).find(".rateValue").val();
                Number($('.invoiceTotalTax').text().replace('$', ''));
                if (descValuefeild != "" && rateValuefeild !== "" && qtyValuefeild !== "")
                    isValidateInvoiceTable = true;
            }
        }
    });

    var isValidate = validateInputs(element);
    if (isValidate == true && isValidateInvoiceTable == true) {

        var inv_firstname = $("#inv_firstname").val();
        var inv_lastname = $("#inv_lastname").val();
        var resultURL = getBaseURL();
        var InvoiceLink = resultURL + "/payment?token=" + $("#inv_GUID").val();
        var clickHere = "Hello " + inv_firstname + " " + inv_lastname + "\n \n" + "Please pay your pending invoice with Talevation." + "\n" + "You can pay it online with the link below." + "\n" + InvoiceLink + "\n \n" + "If you are not able to click the link above, please copy and paste it in your browser." + "\n \n" + "Thanks," + "\n" + "Talevation";
        var mailToLinkBody = encodeURIComponent(clickHere);
        var save_send_Href_String = 'mailto:' + $("#customer").val() + '?subject=Talevation: Pay Invoice!&body=' + mailToLinkBody;
        var save_send = $(".save_send_href").attr('href', save_send_Href_String);
//        $(".saveInvoice").addClass('hidden');
//        $("#customer").addClass('hidden');
//        $("#InvoiceDetails").addClass('hidden');
        var string = inv_firstname + " " + inv_lastname + " (" + $("#customer").val() + ")";
        $("#contentToShow").text(string);

        $("#edit_customer").removeClass("hidden");
        var CSRF_TOKEN = $('input[name="_token"]').val();
        var customer = $("#addInvoice_form").find("#customer").val();

        var Email = $("#Email").val();
        var inv_add1 = $("#inv_add1").val();
        var inv_add2 = $("#inv_add2").val();
        var inv_state = $("#inv_state").val();
        var inv_city = $("#inv_city").val();
        var inv_zip = $("#inv_zip").val();
        var inv_terms = $("#inv_terms").val();
        var state_tax_id = $("#state_taxes option:selected").attr('id');
        var inv_due_date = null;
        if (inv_terms != 'Due On Receipt') {
            inv_due_date = $("#due-date").val();
        } else
            inv_due_date = "due on receipt";

        var invoice_created_date = $("#invoice-date").val();

        var customerDb_id = $("#customerDb_id").val();

//        if (customerDb_id == "" || customerDb_id == null || customerDb_id == undefined) {
//            customerDb_id = $(".edit_customerDb_Id").val();
//        }


        var inv_GUID = $("#inv_GUID").val();
        var companyName_Invoice = $("#CompanyName_Invoices").val();
//        var inv_siteNumber = $("#inv_siteNumber").val();
//        var inv_anniversary_Date = $("#inv_anniversary_Date").val();
        var memo = $("#memo").val();
        $("#InvoiceItemsDetails").removeClass('hidden');

        var InvoiceIdFromEditIcon = $("#Inv_id_fromEditIcon").val();
        //alert(InvoiceIdFromEditIcon);
        var customerId_fromcreateInvoice = $("#customerId_fromcreateInvoice").val();
        showLoader();
        $.ajax({
            url: 'InsertInvoice',
            type: 'post',
            data: {_token: CSRF_TOKEN, customerId_fromcreateInvoice: customerId_fromcreateInvoice, InvoiceIdFromEditIcon: InvoiceIdFromEditIcon, customer: customer, inv_firstname: inv_firstname,
                inv_lastname: inv_lastname, Email: Email, inv_add1: inv_add1, inv_add2: inv_add2
                , inv_state: inv_state, inv_city: inv_city, inv_zip: inv_zip,
                inv_due_date: inv_due_date, invoice_created_date: invoice_created_date, inv_terms: inv_terms, state_tax_id: state_tax_id,
                customerDb_id: customerDb_id, inv_GUID: inv_GUID, companyName_Invoice: companyName_Invoice, memo: memo},
            success: function (response) {

                if (!parseInt(response)) {
                    alert('Something went wrong creating your invoice, please try again after sometime or report this error!');
                    return;
                }

                //$(".LastInsertedInvoiceId").val(response);
                $(".saveInvoiceItems").removeClass('hidden');
                $(".save_send").removeClass('hidden');

                //Save Invoice Items
                var invoiceItems = new Array();
                var invoiceItem;
                var presetItemId, presetItemValue, descValue, qtyValue, rateValue, dbinvoice_itemid, deletedInvoiceId;
                deletedInvoiceId = $("#deleted_invoiceId").val();
                $("#invoiceItemTable").find("tbody").find("tr").each(function (e) {


                    if (!$(this).hasClass("hidden")) {

                        //LastInsertedInvoiceId = $(".LastInsertedInvoiceId").val();
                        presetItemId = $(this).find(".preset_line_items option:selected").attr("id");
                        presetItemValue = $(this).find(".preset_line_items").val();

                        if (presetItemId == -1 && presetItemValue == -1) {
                            presetItemId = '';
                            presetItemValue = '';
                        }

                        descValue = $(this).find(".descValue").val();
                        qtyValue = $(this).find(".qtyValue").val();
                        rateValue = $(this).find(".rateValue").val();
                        if (descValue != "" && qtyValue != "" && rateValue != "")
                        {
                            invoiceItem = new Object();
                            dbinvoice_itemid = $(this).attr("dbInvoice_itemId");
                            invoiceItem.preset_line_item_id = presetItemId;
                            invoiceItem.part_number = presetItemValue;
                            invoiceItem.invoice_id = parseInt(response);
                            invoiceItem.discription = descValue;
                            invoiceItem.quantity = qtyValue;
                            invoiceItem.rate = rateValue;
                            invoiceItem.is_taxable = $(this).find(".isTaxable").prop('checked') ? 1 : 0;
                            invoiceItem.dbinvoice_itemid = dbinvoice_itemid;
                            invoiceItems.push(invoiceItem);
                        }
                    }
                });
                if (invoiceItems.length != 0) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                    showLoader();
                    $.ajax({
                        url: 'saveInvoiceItems',
                        type: 'post',
                        data: {_token: CSRF_TOKEN, invoiceItems: invoiceItems, deletedInvoiceId: deletedInvoiceId},
                        success: function (response) {
//                            console.log(response);
                            location.reload();
                        }
                    });
                }

            }
        });
    } else {
        alert("Please add minimum one invoice item.");
    }



}
function CloneElement(element) {

    var newtrTag = $("#invoiceItemTable").find('tbody').find("#hiddenTrTag").clone().appendTo($("#invoiceItemTable").find('tbody'));
    $(newtrTag).removeClass('hidden');
    $(newtrTag).addClass('parent');
    $(newtrTag).addClass("clonnedInvoiceItem");
    var count = $("#invoiceItemTable").find('tbody').find(".clonnedInvoiceItem").length;
    $(newtrTag).attr("id", "invoiceItem" + count);
}

function DeleteElement(element) {
    var parent = findParent(element);
    $(parent).remove();

    $("#deleted_invoiceId").val(function () {
        return this.value + $(parent).attr('dbinvoice_itemid') + ',';
    });

    var totalPriceSum = 0;
    $(".totalValue").each(function (e) {
        if (!$(this).parent().parent().hasClass("hidden")) {
            var totalPrice = $(this).text().replace('$', '');
            totalPriceSum += Number(totalPrice);
        }
    });
//        alert (totalPriceSum);
    $(".invoiceTotalPrice").text('$' + totalPriceSum.toFixed(2));
    $(".invoiceTotalBalance").text('$' + totalPriceSum.toFixed(2));

    var stateTaxes = 0;
    var countTotalTax = 0;
    var totalAmount = 0;
    var totalBalance = 0;
    stateTaxes = $('.state_name').val();
    if (stateTaxes > 0) {
        totalAmount = Number($(parent).find('.totalValue').text().replace('$', ''));
        countTotalTax = parseFloat(((stateTaxes * totalAmount) / 100).toFixed(2));
        var oldVal = parseFloat($('.invoiceTotalTax ').text().replace('$', ''));

        if ($(element).is(':checked')) {
            countTotalTax = countTotalTax + oldVal;
        } else {
            countTotalTax = oldVal - countTotalTax;
        }

        $(".invoiceTotalTax").text('$' + countTotalTax.toFixed(2));

        var totalPrice = Number($('.invoiceTotalPrice').text().replace('$', ''));
        var totalTax = Number($('.invoiceTotalTax').text().replace('$', ''));
        totalBalance = parseFloat(totalPrice) + parseFloat(totalTax);
        $(".invoiceTotalBalance").text('$' + totalBalance.toFixed(2));
    }
}

function ItemTotalValue(element) {
    var parent = findParent(element);
    var total = 0;
    var rateValue = $(parent).find('.rateValue').val();
    var qtyValue = $(parent).find('.qtyValue').val();
    var descValue = $(parent).find('.descValue').val();

    if (rateValue != "" && qtyValue != "") {
//        total = parseFloat(rateValue * qtyValue) + parseFloat(rateValue * qtyValue * taxValue / 100);
        total = parseFloat(rateValue * qtyValue);
        $(parent).find(".totalValue").text('$' + total.toFixed(2));

        var totalPriceSum = 0;
        $(".totalValue").each(function (e) {
            if (!$(this).parent().parent().hasClass("hidden")) {
                var totalPrice = $(this).text().replace('$', '');
                totalPriceSum += Number(totalPrice);
            }
        });
//        alert (totalPriceSum);
        $(".invoiceTotalPrice").text('$' + totalPriceSum.toFixed(2));
        $(".invoiceTotalBalance").text('$' + totalPriceSum.toFixed(2));

        SetTaxableValue();

//        var stateTaxes = 0;
//        var countTotalTax = 0;
//        var totalAmount = 0;
//        var totalBalance = 0;
//        stateTaxes = $('.state_name').val();
//        if (stateTaxes > 0) {
//            var totalPrice = Number($('.invoiceTotalPrice').text().replace('$', ''));
//            var totalTax = Number($('.invoiceTotalTax').text().replace('$', ''));
//            totalBalance = parseFloat(totalPrice) + parseFloat(totalTax);
//            $(".invoiceTotalBalance").text('$' + totalBalance.toFixed(2));
//        }
    }
}

function SetTaxableValue() {
//    var parent = findParent(element);
    var stateTaxes = 0;
    var countTotalTax = 0;
    var totalAmount = 0;
    var totalBalance = 0;
    stateTaxes = $('.state_name').val();
    if (stateTaxes > 0) {
        var totalNewTax = 0;
        $(".isTaxable").each(function (e) {
            if (!$(this).parent().parent().hasClass("hidden")) {
                if ($(this).is(':checked')) {
                    var RowPrice = Number($(this).parent().parent().find('.totalValue').text().replace('$', ''));
                    var countTotalTax2 = parseFloat(((stateTaxes * RowPrice) / 100).toFixed(2));
                    totalNewTax += countTotalTax2;
                }
            }
        });
        $(".invoiceTotalTax").text('$' + totalNewTax.toFixed(2));

        var totalPrice = Number($('.invoiceTotalPrice').text().replace('$', ''));
        totalBalance = parseFloat(totalNewTax) + parseFloat(totalPrice);
        $(".invoiceTotalBalance").text('$' + totalBalance.toFixed(2));
    } else {
        $(".invoiceTotalTax").text('$0');
    }

//    if (stateTaxes > 0 && !$(element).hasClass('state_name')) {
//        totalAmount = Number($(parent).find('.totalValue').text().replace('$', ''));
//        countTotalTax = parseFloat(((stateTaxes * totalAmount) / 100).toFixed(2));
//        var oldVal = parseFloat($('.invoiceTotalTax ').text().replace('$', ''));
//
//        if ($(element).is(':checked')) {
//            countTotalTax = countTotalTax + oldVal;
//        } else {
//            countTotalTax = oldVal - countTotalTax;
//        }
//
//        $(".invoiceTotalTax").text('$' + countTotalTax.toFixed(2));
//
//        var totalPrice = Number($('.invoiceTotalPrice').text().replace('$', ''));
//        var totalTax = Number($('.invoiceTotalTax').text().replace('$', ''));
//        totalBalance = parseFloat(totalPrice) + parseFloat(totalTax);
//        $(".invoiceTotalBalance").text('$' + totalBalance.toFixed(2));
//    } else if ($(element).hasClass('state_name')) {
//        var totalNewTax = 0;
//        $(".isTaxable").each(function (e) {
//            if (!$(this).parent().parent().hasClass("hidden")) {
//                if ($(this).is(':checked')) {
//                    var RowPrice = Number($(this).parent().parent().find('.totalValue').text().replace('$', ''));
//                    var countTotalTax2 = parseFloat(((stateTaxes * RowPrice) / 100).toFixed(2));
//                    totalNewTax += countTotalTax2;
//                }
//            }
//        });
//        $(".invoiceTotalTax").text('$' + totalNewTax.toFixed(2));
//
//        var totalPrice = Number($('.invoiceTotalPrice').text().replace('$', ''));
//        totalBalance = parseFloat(totalNewTax) + parseFloat(totalPrice);
//        $(".invoiceTotalBalance").text('$' + totalBalance.toFixed(2));
//    }
}

function editInvoice(element, InvoiceItemObject) {
    var parent = findParent(element);
    $('#addInvoice_form').removeClass('NewItem');
    $("#InvoiceItemsDetails").addClass('hidden');
    $(".save_send").addClass('hidden');
    $(".saveInvoiceItems").addClass('hidden');
    $("#InvoiceDetails").removeClass('hidden');
    //$("#addInvoice_saveCreateInvoice").click();

    $("#addInvoice_form").find("#customer").val($(parent).find('.edit_Email').text());
    $("#addInvoice_form").find("#customerDb_id").val($(parent).find('.edit_customerDb_Id').val());
    $("#addInvoice_form").find("#state_tax_id").val($(parent).find('.edit_state_tax_id').val());

    $("#addInvoice_form").find("#customer").val($(parent).find('.edit_Email').text());
    $("#addInvoice_form").find("#Email").val($(parent).find('.edit_Email').text());
    $("#addInvoice_form").find("#inv_firstname").val($(parent).find('.edit_fname').val());
    $("#addInvoice_form").find("#inv_lastname").val($(parent).find('.edit_lname').val());
    $("#addInvoice_form").find("#CompanyName_Invoices").val($(parent).find('.edit_cName').text());
    $("#addInvoice_form").find("#inv_add1").val($(parent).find('.edit_add1').val());
    $("#addInvoice_form").find("#inv_add2").val($(parent).find('.edit_add2').val());

    $("#addInvoice_form").find("#inv_state").val($(parent).find('.edit_state').val());
    $("#addInvoice_form").find("#inv_city").val($(parent).find('.edit_city').val());
    $("#addInvoice_form").find("#inv_zip").val($(parent).find('.edit_zip').val());
    $("#addInvoice_form").find("#Inv_id_fromEditIcon").val($(parent).find('.edit_id').val());
    $("#addInvoice_form").find("#invoice-date").val($(parent).find('.edit_invoice_date').val());
    $("#addInvoice_form").find("#due-date").val($(parent).find('.edit_due_date').val());
    $("#addInvoice_form").find("#inv_terms").val($(parent).find('.edit_terms').val());


    $("#memo").val($(parent).find('.edit_memo').val());
    $(".saveInvoice").removeClass('hidden');

    //removing old invoice items of previously edited or added invoice
    $("#invoiceItemTable").find('tbody').find('.clonnedInvoiceItem').remove();

    var presetItemsStr = "";
    var hiddenInvoiceItem = $("#InvoiceItemsDetails").find("#invoiceItemTable").find("#hiddenTrTag");
    var presetLineItems = $(hiddenInvoiceItem).find(".preset_line_items");
//    if (presetLineItems.find('option').length > 1) {
//        presetLineItems.find('option').each(function () {
//            presetItemsStr += "<option  price='" + $(this).attr("price") + "'desc='" + $(this).attr("desc") + "' id='" + $(this).attr("id") + "'>" + $(this).text() + "</option>";
//        });
//    }
    var isTaxable = '';
    var selectedItem = '';
    var OptionID = '';
    for (var k = 0; k < InvoiceItemObject.length; k++) {
        if (presetLineItems.find('option').length > 1) {
            presetItemsStr = '';
            presetLineItems.find('option').each(function () {

                selectedItem = '';
//
                if (InvoiceItemObject[k]['preset_line_item_id'] == null) {
                    OptionID = null;
                } else {
                    OptionID = $(this).attr("id");
                }
                if (OptionID == InvoiceItemObject[k]['preset_line_item_id']) {
                    selectedItem = 'selected';
                }
                presetItemsStr += "<option " + selectedItem + " price='" + $(this).attr("price") + "'desc='" + $(this).attr("desc") + "' id='" + $(this).attr("id") + "'>" + $(this).text() + "</option>";
            });
        }

        //$("#invoiceItemTable").find('tbody').find(".BlankData").remove();
        isTaxable = InvoiceItemObject[k]['is_taxable'] == 1 ? 'checked' : '';
        $("#invoiceItemTable").find('tbody').append('<tr dbInvoice_itemId="' + InvoiceItemObject[k]['id'] + '"class="parent clonnedInvoiceItem">\n\
<td class="w13"><input type="hidden" value="' + InvoiceItemObject[k]['preset_line_item_id'] + '" id="preset_line_item_id" /><select onchange="setInvoiceDetails(this);" class="form-control preset_line_items">' + presetItemsStr + ' </select></td>\n\
<td class=""><input type="text" value="' + InvoiceItemObject[k]['discription'] + '" class="form-control descValue"></td>\n\
<td class="w8"><input min="0" onkeyup="return ItemTotalValue(this);"  onchange="return ItemTotalValue(this);" value="' + InvoiceItemObject[k]['quantity'] + '" type="number" class="form-control qtyValue"></td><td class="w10"><div class="input-group">\n\
<div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-dollar-sign" aria-hidden="true"></i></span></div>\n\
<input min="0" onkeyup="return ItemTotalValue(this);" onchange="return ItemTotalValue(this);" value="' + InvoiceItemObject[k]['rate'] + '"type="number" class="form-control rateValue"></div></td>\n\
\n\<td class="w8"><input type="checkbox" ' + isTaxable + ' onkeyup="return SetTaxableValue(this);" onchange="return SetTaxableValue(this);" class="form-control isTaxable ml-4" style="max-width: 20px !important;"></td>\n\
<td class="w7 text-right"><label readonly="readonly" class="totalValue">$' + parseFloat(InvoiceItemObject[k]['quantity'] * InvoiceItemObject[k]['rate']) + '<label></label></label></td>\n\
<td class="text-right" onclick="DeleteElement(this)"><i class="user-pointer fas fa-trash mt-8" aria-hidden="true"></i></td></tr>\n');

    }



//    + (InvoiceItemObject[k]['quantity'] * InvoiceItemObject[k]['rate'] * InvoiceItemObject[k]['tax'] / 100)).toFixed(2) 

    checkForPresetItems('editinvoice');

    $(".invoiceTotalPrice").find('tbody').find('tr').addClass('hidden');
    var totalPriceSum = 0;
    $(".totalValue").each(function (e) {
        if (!$(this).parent().parent().hasClass("hidden")) {
            var totalPrice = $(this).text().replace('$', '');
            totalPriceSum += Number(totalPrice);
        }
    });
    $(".invoiceTotalPrice").text('$' + totalPriceSum.toFixed(2));
    $(".invoiceTotalBalance").text('$' + totalPriceSum.toFixed(2));

//    SetTaxableValue();

//    var totalBalance = 0;
//    var totalNewTax = 0;
//    $(".invoiceTotalTax").text('$' + totalNewTax.toFixed(2));
//    var totalPrice = Number($('.invoiceTotalPrice').text().replace('$', ''));
//    totalBalance = parseFloat(totalNewTax) + parseFloat(totalPrice);
//    $(".invoiceTotalBalance").text('$' + totalBalance.toFixed(2));

//        alert('in' + k+" "+InvoiceItemObject[k]['discription']);
}

function markInvoicePaid(element) {
    var confirmPaid = confirm("Are you sure you want to mark this invoice Paid?");
    if (!confirmPaid)
        return;
    var parent = findParent(element);
    var invoiceId = $(element).attr('db-id');
    showLoader();
    var CSRF_TOKEN = $(parent).find('.csrf-token').val();
    $.ajax({
        url: 'markInvoicePaid',
        type: 'post',
        data: {_token: CSRF_TOKEN, invoiceId: invoiceId},
        success: function (response) {
            //location.reload();

            $(parent).find('.edit_status').text("Paid");
            $(element).remove();
            hideLoader();
        }
    });
}

function AddNewInvoice() {
    //first hiding all elements of second and third steps
    $('#invoiceItemTable').addClass('NewItem');
    $("#InvoiceDetails").addClass('hidden');
    $(".saveInvoiceItems").addClass("hidden");
    $(".save_send").addClass("hidden");
    $("#InvoiceItemsDetails").addClass("hidden");
    $("#edit_customer").addClass("hidden");
    $("#saveCustomerBtn").addClass('hidden');
    $(".saveCreateInvoice").addClass('hidden');
    $(".saveInvoice").addClass('hidden');
    $("#customer").val('');
    $("#Inv_id_fromEditIcon").val('');

    //
    $("#InvoiceDetails").find('input').each(function (e) {
        var id = $(this).attr('id');
        if (id != 'invoice-date' && id != 'due-date') {
            $(this).val('');
        }
    });

    //showing first step of choosing customer
    $("#customer").removeClass("hidden");
    $("#contentToShow").text("Lookup Customer by Email");



    //removing all previously used invoice items in add/edit popup
    var InvoiceItemsDetails = $("#InvoiceItemsDetails");
    $(InvoiceItemsDetails).find(".clonnedInvoiceItem").each(function () {
        $(this).remove();
    });

    checkForPresetItems('addnew');
}

function checkForPresetItems(calledFrom) {
    var InvoiceItemsDetails = $("#InvoiceItemsDetails");
    //finding hidden preset line items and setting options
    var hiddenInvoiceItem = $(InvoiceItemsDetails).find("#invoiceItemTable").find("#hiddenTrTag");
    var presetLineItems = $(hiddenInvoiceItem).find(".preset_line_items");

    if (presetLineItems.find('option').length > 1) {
        if (calledFrom == "addnew") {
            //clonning and adding one fresh invoice item
            var clonnedFirstInvoiceItem = $(hiddenInvoiceItem).clone();
            $(clonnedFirstInvoiceItem).removeClass("hidden");
            $(clonnedFirstInvoiceItem).addClass("parent");
            $(clonnedFirstInvoiceItem).addClass("clonnedInvoiceItem");
            $(clonnedFirstInvoiceItem).attr('id', 'invoiceItem0');
            $(hiddenInvoiceItem).parent().append(clonnedFirstInvoiceItem);

            $(".invoiceTotalPrice").find('tbody').find('tr').addClass('hidden');
            var totalPriceSum = 0;
            $(".totalValue").each(function (e) {
                if (!$(this).parent().parent().hasClass("hidden")) {
                    var totalPrice = $(this).text().replace('$', '');
                    totalPriceSum += Number(totalPrice);
                }
            });
            $(".invoiceTotalPrice").text('$' + totalPriceSum.toFixed(2));
            $(".invoiceTotalBalance").text('$' + totalPriceSum.toFixed(2));

            var totalBalance = 0;
            var totalNewTax = 0;
            $(".invoiceTotalTax").text('$' + totalNewTax.toFixed(2));
            var totalPrice = Number($('.invoiceTotalPrice').text().replace('$', ''));
            totalBalance = parseFloat(totalNewTax) + parseFloat(totalPrice);
            $(".invoiceTotalBalance").text('$' + totalBalance.toFixed(2));
        }
//        else {
//            var clonnedInvoiceItem = $("#InvoiceItemsDetails #invoiceItemTable").find(".clonnedInvoiceItem");
//            $(clonnedInvoiceItem).each(function () {
//                var line_items_selectbox = $(this).find(".preset_line_items");
//                $(line_items_selectbox).append($(presetLineItems).find('option'));
//            });
////            presetLineItems.find('option').each(function () {
////                var optionItem = $(this);
////                
////
////            });
//
//        }
    } else {
        //showLoader();
        var CSRF_TOKEN = $('input[name="_token"]').val();
        $.ajax({
            url: 'preset_line_items',
            type: 'post',
            data: {_token: CSRF_TOKEN},
            success: function (response) {
                var clonnedInvoiceItem = $("#InvoiceItemsDetails #invoiceItemTable").find(".clonnedInvoiceItem");

                for (var k = 0; k < response.preset_line_items.length; k++) {
                    $(presetLineItems).append("<option  price='" + response.preset_line_items[k].price + "'desc='" + response.preset_line_items[k].description + "' id='" + response.preset_line_items[k].id + "'>" + response.preset_line_items[k].part_number + "</option>")
                    var selectedPresetItem = '';

                }

                if (calledFrom == "editinvoice") {
                    $(clonnedInvoiceItem).each(function () {

                        var presetItemsContainer = $(this);
                        var preset_line_item_id = $(presetItemsContainer).find("#preset_line_item_id").val();
                        presetLineItems.find('option').each(function () {
                            selectedPresetItem = '';

                            if (preset_line_item_id == $(this).attr("id")) {
                                selectedPresetItem = 'selected';
                            }
                            $(presetItemsContainer).find(".preset_line_items").append("<option " + selectedPresetItem + " price='" + $(this).attr("price") + "'desc='" + $(this).attr("desc") + "' id='" + $(this).attr("id") + "'>" + $(this).text() + "</option>");
                        });
                    });
                }

                if (calledFrom == "addnew") {
                    var clonnedFirstInvoiceItem = $(hiddenInvoiceItem).clone();
                    $(clonnedFirstInvoiceItem).removeClass("hidden");
                    $(clonnedFirstInvoiceItem).addClass("parent");
                    $(clonnedFirstInvoiceItem).addClass("clonnedInvoiceItem");
                    $(clonnedFirstInvoiceItem).attr('id', 'invoiceItem0');
                    $(hiddenInvoiceItem).parent().append(clonnedFirstInvoiceItem);
                }

                for (var j = 0; j < response.state_taxes.length; j++) {
                    $(".state_name").append("<option  id='" + response.state_taxes[j].id + "'value='" + response.state_taxes[j].tax_rate + "'>" + response.state_taxes[j].state_name + "</option>");

                }
                //hideLoader();
            }
        });
    }
}