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
                    name: "addToSalary",
                    data: "addToSalary",
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

    initializeTable("#compensation-table", `compensation/list`);

    $("#closeForm").click(() => {
        $("#ComSettingsForm").fadeOut().addClass("d-none");
        $(".ComSettingsTable").removeClass("col-9");
        $(".ComSettingsTable").addClass("col-12").hide();
        $(".ComSettingsTable").fadeIn().removeClass("d-none");
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

    // //SHOW RECORD OF the ACCOUNT to be Updated in Mandatory Deduction Setting
    $(document).on("click", "#editSettings", function () {
        comCode = $(this).attr("data-comCode");
        // Ajax request for fetching leave type data.
        $.ajax({
            url: `/maintenance/compensation/${comCode}/edit`,
            success: function (compensationSettings) {
                $("#ComSettingsForm").fadeIn().removeClass("d-none");
                $(".ComSettingsTable").removeClass("col-12");
                $(".ComSettingsTable").addClass("col-8");
                $(".ComSettingsTable").fadeIn().removeClass("d-none");
                //Configure form Controls
                $(
                    `.accountCode, .computation, .percentage, .amount`
                ).removeClass("is-invalid");
                $(
                    `#accountCode-error-message, #computation-error-message, #percentage-error-message`
                ).html("");
                $(`#amount-error-message`).html("");
                // Collect data of form fields.
                $("#accountTitle").val(compensationSettings.account.accountTitle);
                $("#computation").val(compensationSettings.computation);
                if (compensationSettings.addToSalary == true) {
                    $("#addToSalary").prop("checked", true);
                }else{
                    $("#addToSalary").prop("checked", false);
                }

                if (compensationSettings.computation == 0) {
                    $("#percentage, #amount").attr("disabled", true);
                    $("#percentage, #amount").val("");
                } else if (compensationSettings.computation == 1) {
                    $("#percentage").attr("disabled", false);
                    $("#amount").attr("disabled", true);
                    $("#percentage").val(compensationSettings.percentage * 100);
                    $("#amount").val("");
                } else {
                    $("#percentage").attr("disabled", true);
                    $("#amount").attr("disabled", false);
                    $("#percentage").val("");
                    $("#amount").val(compensationSettings.amount);
                }
            },
        });
    });

    //SAVE CHANGES of the Updated record
    $("#btnSaveChanges").click((e) => {
        e.preventDefault();
        $("#save-spinner").removeClass("d-none");
        let data = $("#compensation-form").serialize();
        $.ajax({
            url: `/maintenance/compensation/${comCode}/edit`,
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
                            `.accountCode, .computation, .percentage, .amount`
                        ).removeClass("is-invalid");
                        $(
                            `#accountCode-error-message, #computation-error-message, #percentage-error-message, #amount-error-message`
                        ).html("");
                        $("#compensation-table").DataTable().ajax.reload();
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
});
