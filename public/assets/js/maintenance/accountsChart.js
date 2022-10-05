
$(function() {
    let mainAccounts = JSON.parse(
        $('meta[name="mainAccounts"]').attr("content")
    );
    let subAccounts = JSON.parse($('meta[name="subAccounts"]').attr("content"));

    function renderMainAccountCodes() {
        $("#pCode").children().remove();

        $.each(mainAccounts, function (i, item) {
            $("#pCode").append(
                $("<option>", {
                    value: item.accountCode,
                    text: item.accountTitle,
                })
            );
        });
    }

    function renderSubAccountCodes() {
        $("#pCode").children().remove();

        $.each(subAccounts, function (i, item) {
            $("#pCode").append(
                $("<option>", {
                    value: item.accountCode,
                    text: item.accountTitle,
                })
            );
        });
    }

    $(".pCode").addClass("d-none");

    let table = $("#accounts-table").DataTable({
        serverSide: true,
        stateSave: true,
        ajax: `/maintenance/accountsChart/list`,
        processing: true,
        ordering: false,
        lengthMenu: [8],
        language: {
            processing:
                '<i class="text-primary fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Loading...</span> ',
        },
        pagingType: "full_numbers",
        columns: [
            {
                defaultContent: "",
                class: "align-middle lead",
                name: "accountCode",
                data: "accountCode",
            },
            {
                defaultContent: "",
                class: "align-middle lead",
                name: "accountTitle",
                data: "accountTitle",
                render: function (data, type, row) {
                    if (row.aType === "M") {
                        return row.accountTitle;
                    } else if (row.aType === "S") {
                        return "--> " + row.accountTitle;
                    } else {
                        return "---> " + row.accountTitle;
                    }
                },
            },
            {
                defaultContent: "",
                class: "align-middle lead text-center",
                name: "accountEntryType",
                data: "accountEntryType",
            },
            {
                defaultContent: "",
                class: "align-middle lead text-center",
                name: "payrollTransType",
                data: "payrollTransType",
                render: function (data, type, row) {
                    if (row.payrollTransType === "0") {
                        return `Compensation`;
                    } else if (row.payrollTransType === "1") {
                        return `Deduction`;
                    } else {
                        return `Government Share`;
                    }
                },
            },
            {
                defaultContent: "",
                class: "align-middle text-center lead",
                name: "action",
                data: "action",
            },
        ],
    });

    $("#btnAdd").click(() => {
        $(`.accountCode, .accountTitle, .pCode, .accountDesc, .accountEntryType, .payrollTransType`).removeClass("is-invalid");
        $(`#accountCode-error-message, #accountTitle-error-message, #pCode-error-message, #accountDesc-error-message, #accountEntryType-error-message, #payrollTransType-error-message`).html("");
        $("#btnAdd").addClass("disabled");
        $("#accountsForm").fadeIn().removeClass("d-none");
        $("#accountsTable").removeClass("col-12");
        $("#accountsTable").addClass("col-9");
        $("#accountsTable").fadeIn().removeClass("d-none");
        $("#btnCancel").removeClass("d-none");
        $(".aType").attr("disabled", false);
        $(".accountCode").attr("disabled", false);
        $(`#accountCode, #accountTitle, #accountDesc, #accountEntryType`).val("");
        $("#btnSaveAccount").removeClass("d-none");
        $("#btnSaveAccountChanges").addClass("d-none");
        $(".form-method").text("Add New Account");
        $("#pCode").attr("disabled", false);
        $("#pCode, #payrollTransType").val("");
    });

    $("#btnCancel").click(() => {
        $("#btnAdd").removeClass("disabled");
        $("#accountsForm").fadeOut().addClass("d-none");
        $("#accountsTable").removeClass("col-9");
        $("#accountsTable").addClass("col-12").hide();
        $("#accountsTable").fadeIn().removeClass("d-none");
        $("#btnCancel").addClass("d-none");
    });

    $("#mainAccount").click(() => {
        $(".accountCode").val("");
        $(
            `.accountCode, .accountTitle, .pCode, .accountDesc, .accountEntryType, .payrollTransType`
        ).removeClass("is-invalid");
        $(
            `#accountCode-error-message, #accountTitle-error-message, #pCode-error-message, #accountDesc-error-message, #accountEntryType-error-message, #payrollTransType-error-message`
        ).html("");
        let selector = document.querySelector("#accountCode");
        // $("#accountCode").removeAttr("data-inputmask");
        // var im = new Inputmask("9-99-99-999");
        // im.mask(selector);
        $(".pCode").addClass("d-none");
    });

    $("#subAccount").click(() => {
        renderMainAccountCodes();
        $(".accountCode").val("");
        $(
            `.accountCode, .accountTitle, .pCode, .accountDesc, .accountEntryType, .payrollTransType`
        ).removeClass("is-invalid");
        $(
            `#accountCode-error-message, #accountTitle-error-message, #pCode-error-message, #accountDesc-error-message, #accountEntryType-error-message, #payrollTransType-error-message`
        ).html("");
        let selector = document.querySelector("#accountCode");
        // $("#accountCode").removeAttr("data-inputmask");
        // var im = new Inputmask("9-99-99-999(99)");
        // im.mask(selector);
        $('.pCode').removeClass('d-none');
        $('#pCode').html('');
        $('#pCode').append($('<option>', {
            selected: true,
            disabled: true,
            value: '',
            text : 'Select an Account'
        }));

        $.each(mainAccounts, function (i, item) {
            $('#pCode').append($('<option>', {
                value: item.accountCode,
                text : item.accountTitle
            }));
        });
    });

    $("#subSubAccount").click(() => {
        renderSubAccountCodes();
        $(".accountCode").val("");
        $(
            `.accountCode, .accountTitle, .pCode, .accountDesc, .accountEntryType, .payrollTransType`
        ).removeClass("is-invalid");
        $(
            `#accountCode-error-message, #accountTitle-error-message, #pCode-error-message, #accountDesc-error-message, #accountEntryType-error-message, #payrollTransType-error-message`
        ).html("");
        let selector = document.querySelector("#accountCode");
        // $("#accountCode").removeAttr("data-inputmask");
        // var im = new Inputmask("9-99-99-999(99)-999");
        // im.mask(selector);
        $('.pCode').removeClass('d-none');
        $('#pCode').html('');
        $('#pCode').append($('<option>', {
            selected: true,
            disabled: true,
            value: '',
            text : 'Select an Account'
        }));

        $.each(subAccounts, function (i, item) {
            $('#pCode').append($('<option>', {
                value: item.accountCode,
                text : item.accountTitle
            }));
        });
    });

    // $("#pCode").change(() => {
    //     let pcode = $("#pCode").val();
    //     $("#accountCode").val(pcode);
    // });

    //Save New Account
    $("#btnSaveAccount").click((e) => {
        e.preventDefault();

        $("#save-spinner").removeClass("d-none");
        let data = $("#account-form").serialize();
        $.ajax({
            url: "/maintenance/accountsChart/create",
            method: "POST",
            data: data,
            success: function (response) {
                if (response.aType === "M") {
                    mainAccounts.push(response.account);
                    $('meta[name="mainAccounts"]').attr(
                        "content",
                        JSON.stringify(mainAccounts)
                    );
                } else if (response.aType === "S") {
                    subAccounts.push(response.account);
                    $('meta[name="subAccounts"]').attr(
                        "content",
                        JSON.stringify(subAccounts)
                    );
                }

                if(response.success){
                    let accountsTable = $('#accounts-table').DataTable();
                    $('#save-spinner').addClass('d-none');
                    swal("Good job!", "Successfully added!", "success", {closeOnClickOutside: false}).then((isClicked) => {
                        if(isClicked) {
                            accountsTable.ajax.reload();
                            $(
                                `.accountCode, .accountTitle, .pCode, .accountDesc, .accountEntryType, .payrollTransType`
                            ).removeClass("is-invalid");
                            $(
                                `#accountCode-error-message, #accountTitle-error-message, #pCode-error-message, #accountDesc-error-message, #accountEntryType-error-message, #payrollTransType-error-message`
                            ).html("");
                            $(
                                `#accountCode, #accountTitle, #pCode, #accountDesc, #payrollTransType`
                            ).val("");
                            $("#mainAccount").trigger("click");
                        }
                    });
                }
            },
            error: function (response) {
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    const inputNames = [
                        "accountCode",
                        "accountTitle",
                        "pCode",
                        "accountDesc",
                        "accountEntryType",
                        "payrollTransType",
                    ];
                    $.each(inputNames, function (index, value) {
                        if (errors.hasOwnProperty(value)) {
                            $(`.${value}`).addClass("is-invalid");
                            $(`#${value}-error-message`).html("");
                            $(`#${value}-error-message`).append(
                                `${errors[value][0]}`
                            );
                        } else {
                            $(`.${value}`).removeClass("is-invalid");
                            $(`#${value}-error-message`).html("");
                        }
                    });
                    $("#save-spinner").addClass("d-none");
                }
            },
        });
    });

    //SHOW RECORD OF the ACCOUNT to be Updated
    $(document).on("click", ".editAccount", function () {
        accountCode = $(this).attr("data-accountCode");
        // Ajax request for fetching leave type data.
        $.ajax({
            url: `/maintenance/accountsChart/${accountCode}/edit`,
            success: function (accountData) {
                $(".form-method").text("Edit Account");
                $("#btnAdd").addClass("disabled");
                $("#deductionsForm").fadeOut().addClass("d-none");
                $("#accountsForm").fadeIn().removeClass("d-none");
                $("#accountsTable").removeClass("col-12");
                $("#accountsTable").addClass("col-9");
                $("#accountsTable").fadeIn().removeClass("d-none");
                $("#btnCancel").removeClass("d-none");
                //Configure form Controls
                $(".aType, #pCode").attr("disabled", true);
                $("#btnSaveAccount").addClass("d-none");
                $("#btnSaveAccountChanges").removeClass("d-none");
                $(`.accountCode, .accountTitle, .accountEntryType`).removeClass(
                    "is-invalid"
                );
                $(
                    `#accountCode-error-message, #accountTitle-error-message, #accountEntryType-error-message`
                ).html("");
                // Collect data of form fields.
                if (accountData.aType === "M") {
                    $("#mainAccount").trigger("click");
                    $("#mainAccount").prop("checked", true);
                } else if (accountData.aType === "S") {
                    $("#subAccount").trigger("click");
                    $("#subAccount").prop("checked", true);
                } else {
                    $("#subSubAccount").trigger("click");
                    $("#subSubAccount").prop("checked", true);
                }
                $("#pCode").val(accountData.pCode);
                $("#accountCode").val(accountData.accountCode);
                $("#accountTitle").val(accountData.accountTitle);
                $("#accountDesc").val(accountData.accountDesc);
                $("#accountEntryType").val(accountData.accountEntryType);
                $("#payrollTransType").val(accountData.payrollTransType);
            },
        });
    });

    //SAVE CHANGES of the Updated record
    $("#btnSaveAccountChanges").click((e) => {
        e.preventDefault();

        $("#save-spinner").removeClass("d-none");
        let data = $("#account-form").serialize();
        $.ajax({
            url: `/maintenance/accountsChart/${accountCode}/edit`,
            method: "PUT",
            data: data,
            success: function (response) {
                if (response.success) {
                    $("#save-spinner").addClass("d-none");
                    swal("Good job!", "Successfully added!", "success", {
                        closeOnClickOutside: false,
                    }).then((isClicked) => {
                        if (isClicked) {
                            $("#accounts-table").DataTable().ajax.reload();
                        }
                    });
                }
            },
            error: function (response) {
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    const inputNames = [
                        "accountTitle",
                        "accountDesc",
                        "accountEntryType",
                    ];
                    $.each(inputNames, function (index, value) {
                        if (errors.hasOwnProperty(value)) {
                            $(`.${value}`).addClass("is-invalid");
                            $(`#${value}-error-message`).html("");
                            $(`#${value}-error-message`).append(
                                `${errors[value][0]}`
                            );
                        } else {
                            $(`.${value}`).removeClass("is-invalid");
                            $(`#${value}-error-message`).html("");
                        }
                    });
                }
            },
        });
    });

    //Delete Account
    $(document).on('click', '.deleteAccount', function () {
        accountCode = $(this).attr('data-accountCode');
        aType = $(this).attr('data-aType');
        pCode = $(this).attr('data-pCode');

        swal({
            title: "Account Code: " + accountCode,
            text: "Are you sure you want to delete this account?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            closeOnClickOutside: false,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url : `/maintenance/accountsChart/${accountCode}/${pCode}/delete`,
                    method : 'DELETE',
                    success : function (response) {
                            if(response.deductionType === 'M' && parent.window.document.location.pathname == '/deductions/mandatory') {
                                socket.emit('ADD_NEW_MANDATORY_DEDUCTION');
                            }

                            $('#mainAccount').trigger('click');
                            if(aType == "M"){
                                let newMainAccounts = mainAccounts.filter(( account ) => account.accountCode != accountCode);
                                mainAccounts = newMainAccounts;
                                $('meta[name="mainAccounts"]').attr('content', JSON.stringify(newMainAccounts));
                            }else if(aType === "S"){
                                let newSubAccounts = subAccounts.filter(( account ) => account.accountCode != accountCode);
                                subAccounts = newSubAccounts;
                                $('meta[name="subAccounts"]').attr('content', JSON.stringify(newSubAccounts));
                            }
                            swal("Good job!", "Successfully deleted this account.", "success", {closeOnClickOutside: false}).then((isClicked) => {
                            if(isClicked) {
                                $('#accounts-table').DataTable().ajax.reload();
                                $('#btnCancel').trigger('click');
                            }
                        });
                    },
                });
            }
        });
    });

    //Delete Account
    $(document).on('click', '.deleteMainAccount', function () {
        accountCode = $(this).attr('data-accountCode');
        aType = $(this).attr('data-aType');
        pCode = $(this).attr('data-pCode');
        console.log(aType, pCode);
        swal({
            title: "Account Code: " + accountCode,
            text: "Are you sure you want to delete this account?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            closeOnClickOutside: false,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: `/maintenance/accountsChart/${accountCode}/delete`,
                    method: "DELETE",
                    success: function (response) {
                        $("#mainAccount").trigger("click");
                        if (aType == "M") {
                            let newMainAccounts = mainAccounts.filter(
                                (account) => account.accountCode != accountCode
                            );
                            mainAccounts = newMainAccounts;
                            $('meta[name="mainAccounts"]').attr(
                                "content",
                                JSON.stringify(newMainAccounts)
                            );
                        } else if (aType === "S") {
                            let newSubAccounts = subAccounts.filter(
                                (account) => account.accountCode != accountCode
                            );
                            subAccounts = newSubAccounts;
                            $('meta[name="subAccounts"]').attr(
                                "content",
                                JSON.stringify(newSubAccounts)
                            );
                        }
                        swal(
                            "Good job!",
                            "Successfully deleted this account.",
                            "success",
                            { closeOnClickOutside: false }
                        ).then((isClicked) => {
                            if (isClicked) {
                                $("#accounts-table").DataTable().ajax.reload();
                                $("#btnCancel").trigger("click");
                            }
                        });
                    },
                });
            }
        });
    });

    //SHOW RECORD OF the ACCOUNT to be Updated
    $(document).on('click', '.createDeduction', function () {
        accountCodeD = $(this).attr('data-accountCode');
        accountTitleD = $(this).attr('data-accountTitle');
        aType = $(this).attr('data-aType');
        hasSubAccounts = $(this).attr('data-hasSubAccounts');
        payrollTransType = $(this).attr('data-payrollTransType');

        $('.form-method').text('Create Deduction Settings for all Offices');
        $('#btnAdd').addClass('disabled');
        $('#accountsForm').fadeOut().addClass('d-none');
        $('#deductionsForm').fadeIn().removeClass('d-none');
        $('#accountsTable').removeClass('col-12');
        $('#accountsTable').addClass('col-9');
        $('#accountsTable').fadeIn().removeClass('d-none');
        $('#accountCodeD').val(accountCodeD);
        $('#accountTitleD').val(accountTitleD);
    });

    $("#btnCancelDeduction").click(() => {
        $("#btnAdd").removeClass("disabled");
        $("#deductionsForm").fadeOut().addClass("d-none");
        $("#accountsTable").removeClass("col-9");
        $("#accountsTable").addClass("col-12").hide();
        $("#accountsTable").fadeIn().removeClass("d-none");
    });

    $("#computation").change(function (e) {
        let computation = e.target.value;
        $(`.computation, .percentage, .amount`).removeClass("is-invalid");
        $(
            "#computation-error-message, #percentage-error-message, #amount-error-message"
        ).html("");

        if (computation == 0) {
            $("#percentage, #amount").attr("disabled", true);
            $("#percentage").removeAttr("placeholder");
            $("#amount").removeAttr("placeholder");
            $("#percentage, #amount").val("");
        } else if (computation == 1) {
            $("#percentage").attr("disabled", false);
            $("#amount").attr("disabled", true);
            $("#percentage").attr("placeholder", "1-100");
            $("#amount").removeAttr("placeholder");
            $("#percentage, #amount").val("");
        } else {
            $("#percentage").attr("disabled", true);
            $("#amount").attr("disabled", false);
            $("#percentage").removeAttr("placeholder");
            $("#amount").attr("placeholder", "Input amount");
            $("#percentage, #amount").val("");
        }
    });

    //Save New Account
    $("#btnCreateDeduction").click((e) => {
        e.preventDefault();
        $('#save-spinner').removeClass('d-none');
        let data = $('#deduction-form').serialize();

        $.ajax({
            url : '/maintenance/deduction/create',
            method : 'POST',
            data : data,
            success : function (response) {
                if(response.success){
                    if(response.data.deductionType === 'M' && parent.window.document.location.pathname == '/deductions/mandatory') {
                        socket.emit('ADD_NEW_MANDATORY_DEDUCTION');
                    }
                    let deductionTable = $('#deductions-table').DataTable();
                    $('#save-spinner').addClass('d-none');
                    swal("Good job!", "Successfully added!", "success", {closeOnClickOutside: false, button: false, timer: 1000})
                    setTimeout(function() {
                        $('#accounts-table').DataTable().ajax.reload();
                        $(`.computation, .percentage, .amount, .isDeducted, .deductionType`).removeClass("is-invalid");
                        $(`#computation-error-message, #percentage-error-message, #amount-error-message, #isDeducted-error-message, #deductionType-error-message`).html("");
                        $(`#computation, #percentage, #amount, #isDeducted, #deductionType`).val('');
                        $('#btnCancelDeduction').trigger('click');
                    }, 1000);
                }
            },
            error: function (response) {
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    const inputNames = [
                        "computation",
                        "percentage",
                        "amount",
                        "isDeducted",
                        "deductionType",
                    ];
                    $.each(inputNames, function (index, value) {
                        if (errors.hasOwnProperty(value)) {
                            $(`.${value}`).addClass("is-invalid");
                            $(`#${value}-error-message`).html("");
                            $(`#${value}-error-message`).append(
                                `${errors[value][0]}`
                            );
                        } else {
                            $(`.${value}`).removeClass("is-invalid");
                            $(`#${value}-error-message`).html("");
                        }
                    });
                    $("#save-spinner").addClass("d-none");
                }
            },
        });
    });


    //Compensation Create
    $(document).on('click', '.createCompensation', function () {
        accountCodeC = $(this).attr('data-accountCode');
        accountTitleC = $(this).attr('data-accountTitle');
        aType = $(this).attr('data-aType');
        hasSubAccounts = $(this).attr('data-hasSubAccounts');
        payrollTransType = $(this).attr('data-payrollTransType');
        
        $('.form-method').text('Create Compensation Settings for all Offices');
        $('#btnAdd').addClass('disabled');
        $('#accountsForm').fadeOut().addClass('d-none');
        $('#compensationForm').fadeIn().removeClass('d-none');
        $('#accountsTable').removeClass('col-12');
        $('#accountsTable').addClass('col-9');
        $('#accountsTable').fadeIn().removeClass('d-none');
        $('#accountCodeC').val(accountCodeC);
        $('#accountTitleC').val(accountTitleC);
    });

    $('#btnCancelCompensation').click( ()=> {
        $('#btnAdd').removeClass('disabled');
        $('#compensationForm').fadeOut().addClass('d-none');
        $('#accountsTable').removeClass('col-9');
        $('#accountsTable').addClass('col-12').hide();
        $('#accountsTable').fadeIn().removeClass('d-none');
    });

    $("#computationC").change(function(e) {
        let computationC = e.target.value;
        $(`.computationC, .percentageC, .amountC`).removeClass("is-invalid");
        $('#computationC-error-message, #percentageC-error-message, #amountC-error-message').html('');

        if (computationC == 0) {
            $('#percentageC, #amountC').attr('disabled', true);
            $('#percentageC').removeAttr('placeholder');
            $('#amountC').removeAttr('placeholder');
            $("#percentageC, #amountC").val('');
        }else if(computationC == 1){
            $('#percentageC').attr('disabled', false);
            $('#amountC').attr('disabled', true);
            $('#percentageC').attr('placeholder', '1-100');
            $('#amountC').removeAttr('placeholder');
            $("#percentageC, #amountC").val('');
        }else{
            $('#percentageC').attr('disabled', true);
            $('#amountC').attr('disabled', false);
            $('#percentageC').removeAttr('placeholder');
            $('#amountC').attr('placeholder', 'Input amount');
            $("#percentageC, #amountC").val('');
        }
    });

    //Save New Account
    $('#btnCreateCompensation').click( (e)=> {
        e.preventDefault();
        $('#save-spinner').removeClass('d-none');
        let data = $('#compensation-form').serialize();
        
        $.ajax({
            url : '/maintenance/compensation/create',
            method : 'POST',
            data : data,
            success : function (response) {
                if(response.success){
                    let deductionTable = $('#deductions-table').DataTable();
                    $('#save-spinner').addClass('d-none');
                    swal("Good job!", "Successfully added!", "success", {closeOnClickOutside: false, button: false, timer: 1000})
                    setTimeout(function() {
                        $('#accounts-table').DataTable().ajax.reload();
                        $(`.computationC, .percentageC, .amountC, .isDeductedC`).removeClass("is-invalid");
                        $(`#computationC-error-message, #percentageC-error-message, #amountC-error-message, #isDeductedC-error-message`).html("");
                        $(`#computationC, #percentageC, #amountC, #isDeductedC`).val('');
                        $('#btnCancelCompensation').trigger('click');
                    }, 1000);
                }
            },
            error: function(response) {
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    const inputNames = [
                        "computationC",
                        "percentageC",
                        "amountC",
                        "isDeductedC"
                    ];
                    $.each(inputNames, function(index, value) {
                        if (errors.hasOwnProperty(value)) {
                            $(`.${value}`).addClass('is-invalid');
                            $(`#${value}-error-message`).html("");
                            $(`#${value}-error-message`).append(
                                `${errors[value][0]}`
                            );
                        } else {
                            $(`.${value}`).removeClass("is-invalid");
                            $(`#${value}-error-message`).html("");
                        }   
                    });
                    $('#save-spinner').addClass('d-none');
                }
            }
        });
    });

    //SHOW RECORD OF the ACCOUNT to be Updated(government Share)
    $(document).on("click", ".createGS", function () {
        accountCodeGS = $(this).attr("data-accountCode");
        accountTitleGS = $(this).attr("data-accountTitle");
        aType = $(this).attr("data-aType");
        hasSubAccounts = $(this).attr("data-hasSubAccounts");
        payrollTransType = $(this).attr("data-payrollTransType");

        $(".form-method").text("Create Deduction Settings for all Offices");
        $("#btnAdd").addClass("disabled");
        $("#accountsForm").fadeOut().addClass("d-none");
        $("#governmentShareForm").fadeIn().removeClass("d-none");
        $("#accountsTable").removeClass("col-12");
        $("#accountsTable").addClass("col-9");
        $("#accountsTable").fadeIn().removeClass("d-none");
        $("#accountCodeGS").val(accountCodeGS);
        $("#accountTitleGS").val(accountTitleGS);
    });
    //cancel button for add government share
    $("#btnCancelGovernmentShare").click(() => {
        $("#btnAdd").removeClass("disabled");
        $("#governmentShareForm").fadeOut().addClass("d-none");
        $("#accountsTable").removeClass("col-9");
        $("#accountsTable").addClass("col-12").hide();
        $("#accountsTable").fadeIn().removeClass("d-none");
    });

    $("#computationGS").change(function (e) {
        let computation = e.target.value;
        $(`.computationGS, .percentageGS, .amountGS`).removeClass("is-invalid");
        $(
            "#computationGS-error-message, #percentageGS-error-message, #amountGS-error-message"
        ).html("");
        if (computation == 0) {
            $("#percentageGS, #amountGS").attr("disabled", true);
            $("#percentageGS").removeAttr("placeholder");
            $("#amountGS").removeAttr("placeholder");
            $("#percentageGS, #amountGS").val("");
        } else if (computation == 1) {
            $("#percentageGS").attr("disabled", false);
            $("#amountGS").attr("disabled", true);
            $("#percentageGS").attr("placeholder", "1-100");
            $("#amountGS").removeAttr("placeholder");
            $("#percentageGS, #amountGS").val("");
        } else {
            $("#percentageGS").attr("disabled", true);
            $("#amountGS").attr("disabled", false);
            $("#percentageGS").removeAttr("placeholder");
            $("#amountGS").attr("placeholder", "Input amount");
            $("#percentageGS, #amountGS").val("");
        }
    });
    //Save New Account(government share)
    $("#btnCreateGovernmentShare").click((e) => {
        e.preventDefault();
        $("#save-spinner").removeClass("d-none");
        let data = $("#government-share-form").serialize();

        $.ajax({
            url: "/maintenance/governmentShares/create",
            method: "POST",
            data: data,
            success: function (response) {
                if (response.success) {
                    $("#save-spinner").addClass("d-none");
                    swal("Good job!", "Successfully added!", "success", {
                        closeOnClickOutside: false,
                        button: false,
                        timer: 1000,
                    });
                    setTimeout(function () {
                        $("#accounts-table").DataTable().ajax.reload();
                        $(
                            `.computationGS, .percentageGS, .amountGS`
                        ).removeClass("is-invalid");
                        $(
                            `#computationGS-error-message, #percentageGS-error-message, #amountGS-error-message`
                        ).html("");
                        $(`#computationGS, #percentageGS, #amountGS`).val("");
                        $("#btnCancelGovernmentShare").trigger("click");
                    }, 1000);
                }
            },
            error: function (response) {
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    const inputNames = [
                        "computationGS",
                        "percentageGS",
                        "amountGS",
                    ];
                    $.each(inputNames, function (index, value) {
                        if (errors.hasOwnProperty(value)) {
                            $(`.${value}`).addClass("is-invalid");
                            $(`#${value}-error-message`).html("");
                            $(`#${value}-error-message`).append(
                                `${errors[value][0]}`
                            );
                        } else {
                            $(`.${value}`).removeClass("is-invalid");
                            $(`#${value}-error-message`).html("");
                        }
                    });
                    $("#save-spinner").addClass("d-none");
                }
            },
        });
    });


    //Delete Account
    $(document).on('click', '.deleteCompensation', function () {
        accountCode = $(this).attr('data-accountCode');
        swal({
            title: "Account Code: " + accountCode,
            text: "Are you sure you want to delete this accounts settings?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
            closeOnClickOutside: false,
        }).then((willDelete) => {
            if (willDelete) {
                $.ajax({
                    url: `/maintenance/compensation/${accountCode}/delete`,
                    method: "DELETE",
                    success: function (response) {
                        $("#mainAccount").trigger("click");
                        if (aType == "M") {
                            let newMainAccounts = mainAccounts.filter(
                                (account) => account.accountCode != accountCode
                            );
                            mainAccounts = newMainAccounts;
                            $('meta[name="mainAccounts"]').attr(
                                "content",
                                JSON.stringify(newMainAccounts)
                            );
                        } else if (aType === "S") {
                            let newSubAccounts = subAccounts.filter(
                                (account) => account.accountCode != accountCode
                            );
                            subAccounts = newSubAccounts;
                            $('meta[name="subAccounts"]').attr(
                                "content",
                                JSON.stringify(newSubAccounts)
                            );
                        }
                        swal(
                            "Good job!",
                            "Successfully deleted this account.",
                            "success",
                            { closeOnClickOutside: false }
                        ).then((isClicked) => {
                            if (isClicked) {
                                $("#accounts-table").DataTable().ajax.reload();
                                $("#btnCancel").trigger("click");
                            }
                        });
                    },
                });
            }
        });
    });
});
