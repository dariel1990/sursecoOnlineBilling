$(function () {
    let initializeTable = (tableID, url) => {
        return $(tableID).DataTable({
            serverSide: true,
            stateSave: true,
            destroy: true,
            ajax: url,
            processing: true,
            searching: false,
            info: false,
            paging: false,
            ordering: false,
            language: {
                processing:
                    '<i class="text-primary fa fa-spinner fa-spin fa-2x fa-fw"></i><span class="sr-only">Loading...</span> ',
            },
            columns: [
                {
                    defaultContent: "",
                    class: "align-middle lead",
                    name: "accountTitle",
                    data: "accountTitle",
                },
                {
                    defaultContent: "",
                    class: "align-middle text-center lead",
                    name: "computation",
                    data: "computation",
                },
                {
                    defaultContent: "",
                    class: "align-middle text-center lead",
                    name: "isDeducted",
                    data: "isDeducted",
                },
                {
                    defaultContent: "",
                    class: "align-middle text-center lead",
                    name: "action",
                    data: "action",
                },
            ],
        });
    };

    initializeTable("#mandatory-table", `/api/mandatory/deductions`);
    initializeTable("#personal-table", `/api/personal/deductions`);

    $("#McloseForm").click(() => {
        $("#mandatoryDeductionsForm").fadeOut().addClass("d-none");
        $(".mandatoryTable").removeClass("col-9");
        $(".mandatoryTable").addClass("col-12").hide();
        $(".mandatoryTable").fadeIn().removeClass("d-none");
    });

    $("#PcloseForm").click(() => {
        $("#personalDeductionsForm").fadeOut().addClass("d-none");
        $(".personalTable").removeClass("col-9");
        $(".personalTable").addClass("col-12").hide();
        $(".personalTable").fadeIn().removeClass("d-none");
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

    $("#computationP").change(function (e) {
        let computation = e.target.value;
        $(`.computationP, .percentageP, .amountP`).removeClass("is-invalid");
        $(
            "#computationP-error-message, #percentageP-error-message, #amountP-error-message"
        ).html("");

        if (computation == 0) {
            $("#percentageP, #amountP").attr("disabled", true);
            $("#percentageP").removeAttr("placeholder");
            $("#amountP").removeAttr("placeholder");
            $("#percentageP, #amountP").val("");
        } else if (computation == 1) {
            $("#percentageP").attr("disabled", false);
            $("#amountP").attr("disabled", true);
            $("#percentageP").attr("placeholder", "1-100");
            $("#amountP").removeAttr("placeholder");
            $("#percentageP, #amountP").val("");
        } else {
            $("#percentageP").attr("disabled", true);
            $("#amountP").attr("disabled", false);
            $("#percentageP").removeAttr("placeholder");
            $("#amountP").attr("placeholder", "Input amount");
            $("#percentageP, #amountP").val("");
        }
    });

    //SHOW RECORD OF the ACCOUNT to be Updated in Mandatory Deduction Setting
    $(document).on("click", "#editSettingsM", function () {
        dCodeM = $(this).attr("data-dCode");
        // Ajax request for fetching leave type data.
        $.ajax({
            url: `/maintenance/deduction/${dCodeM}/edit`,
            success: function (deductionSettings) {
                $("#mandatoryDeductionsForm").fadeIn().removeClass("d-none");
                $(".mandatoryTable").removeClass("col-12");
                $(".mandatoryTable").addClass("col-8");
                $(".mandatoryTable").fadeIn().removeClass("d-none");
                //Configure form Controls
                $(
                    `.accountCode, .computation, .percentage, .amount`
                ).removeClass("is-invalid");
                $(
                    `#accountCode-error-message, #computation-error-message, #percentage-error-message`
                ).html("");
                $(`#amount-error-message`).html("");
                if (deductionSettings.isDeducted == 1) {
                    $("#isDeducted").prop("checked", true);
                }else{
                    $("#isDeducted").prop("checked", false);
                }
                // Collect data of form fields.
                $("#accountTitle").val(deductionSettings.account.accountTitle);
                $("#computation").val(deductionSettings.computation);
                
                if (deductionSettings.computation == 0) {
                    $("#percentage, #amount").attr("disabled", true);
                    $("#percentage, #amount").val("");
                } else if (deductionSettings.computation == 1) {
                    $("#percentage").attr("disabled", false);
                    $("#amount").attr("disabled", true);
                    $("#percentage").val(deductionSettings.percentage * 100);
                    $("#amount").val("");
                } else {
                    $("#percentage").attr("disabled", true);
                    $("#amount").attr("disabled", false);
                    $("#percentage").val("");
                    $("#amount").val(deductionSettings.amount);
                }
            },
        });
    });

    //SAVE CHANGES of the Updated record
    $("#btnSaveChangesM").click((e) => {
        e.preventDefault();
        dType = "M";
        $("#save-spinner").removeClass("d-none");
        let data = $("#mandatory-deduction-form").serialize();
        $.ajax({
            url: `/maintenance/deduction/${dCodeM}/${dType}/edit`,
            method: "PUT",
            data: data,
            success: function (response) {
                if (response.success) {
                    $("#save-spinner").addClass("d-none");

                    if(parent.window.document.location.pathname == '/deductions/mandatory') {
                        socket.emit('ADD_NEW_MANDATORY_DEDUCTION');
                    }

                    swal("Good job!", "Successfully updated!", "success", {
                        closeOnClickOutside: false,
                        button: false,
                        timer: 1000,
                    });
                    setTimeout(function () {
                        $(
                            `.accountCode, .computation, .percentage, .amount`
                        ).removeClass("is-invalid");
                        $(
                            `#accountCode-error-message, #computation-error-message, #percentage-error-message, #amount-error-message`
                        ).html("");
                        $("#mandatory-table").DataTable().ajax.reload();
                    }, 1000);
                }
            },
            error: function (response) {
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    const inputNames = ["computation", "percentage", "amount"];
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

    //SHOW RECORD OF the ACCOUNT to be Updated in Mandatory Deduction Setting
    $(document).on("click", "#editSettingsP", function () {
        dCodeP = $(this).attr("data-dCode");
        // Ajax request for fetching leave type data.
        $.ajax({
            url: `/maintenance/deduction/${dCodeP}/edit`,
            success: function (deductionSettings) {
                $("#personalDeductionsForm").fadeIn().removeClass("d-none");
                $(".personalTable").removeClass("col-12");
                $(".personalTable").addClass("col-8");
                $(".personalTable").fadeIn().removeClass("d-none");
                //Configure form Controls
                $(
                    `.accountCodeP, .computationP, .percentageP, .amountP`
                ).removeClass("is-invalid");
                $(
                    `#accountCodeP-error-message, #computationP-error-message, #percentageP-error-message, #amountP-error-message`
                ).html("");
                // Collect data of form fields.
                $("#accountTitleP").val(deductionSettings.account.accountTitle);
                $("#computationP").val(deductionSettings.computation);
                if (deductionSettings.isDeducted == 1) {
                    $("#isDeductedP").prop("checked", true);
                }else{
                    $("#isDeductedP").prop("checked", false);
                }

                if (deductionSettings.computation == 0) {
                    $("#percentageP, #amountP").attr("disabled", true);
                    $("#percentageP, #amountP").val("");
                } else if (deductionSettings.computation == 1) {
                    $("#percentageP").attr("disabled", false);
                    $("#amountP").attr("disabled", true);
                    $("#percentageP").val(deductionSettings.percentage * 100);
                    $("#amountP").val("");
                } else {
                    $("#percentageP").attr("disabled", true);
                    $("#amountP").attr("disabled", false);
                    $("#percentageP").val("");
                    $("#amountP").val(deductionSettings.amount);
                }
            },
        });
    });

    //SAVE CHANGES of the Updated record
    $("#btnSaveChangesP").click((e) => {
        e.preventDefault();
        dType = "P";
        $("#save-spinner").removeClass("d-none");
        let data = $("#personal-deduction-form").serialize();
        $.ajax({
            url: `/maintenance/deduction/${dCodeP}/${dType}/edit`,
            method: "PUT",
            data: data,
            success: function (response) {
                if (response.success) {
                    $("#save-spinner").addClass("d-none");
                    swal("Good job!", "Successfully updated!", "success", {
                        closeOnClickOutside: false,
                        button: false,
                        timer: 1000,
                    });
                    setTimeout(function () {
                        $(
                            `.accountCodeP, .computationP, .percentageP, .amountP`
                        ).removeClass("is-invalid");
                        $(
                            `#accountCodeP-error-message, #computationP-error-message, #percentageP-error-message, #amountP-error-message`
                        ).html("");
                        $("#personal-table").DataTable().ajax.reload();
                    }, 1000);
                }
            },
            error: function (response) {
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    const inputNames = [
                        "computationP",
                        "percentageP",
                        "amountP",
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

    //SAVE CHANGES of the Updated record
    $("#mandatory-nav").click((e) => {
        $("#PcloseForm").trigger("click");
    });

    $("#personal-nav").click((e) => {
        $("#McloseForm").trigger("click");
    });
});
