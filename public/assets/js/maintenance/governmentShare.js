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
                    name: "action",
                    data: "action",
                },
            ],
        });
    };
    initializeTable("#goverment-share-table", `/api/governmentShares/list`);

    //compution
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

    //closes form
    $("#GScloseForm").click(() => {
        $("#governmentShareForm").fadeOut().addClass("d-none");
        $(".governmentShareTable").removeClass("col-9");
        $(".governmentShareTable").addClass("col-12").hide();
        $(".governmentShareTable").fadeIn().removeClass("d-none");
    });

    //SHOW RECORD OF the ACCOUNT to be Updated in Mandatory Deduction Setting
    $(document).on("click", "#editSettingsGS", function () {
        gsCode = $(this).attr("data-gsCode");
        // Ajax request for fetching leave type data.
        $.ajax({
            url: `/maintenance/governmentShares/${gsCode}/edit`,
            success: function (governmentShareSettings) {
                $("#governmentShareForm").fadeIn().removeClass("d-none");
                $(".governmentShareTable").removeClass("col-12");
                $(".governmentShareTable").addClass("col-8");
                $(".governmentShareTable").fadeIn().removeClass("d-none");
                //Configure form Controls
                $(`.computationGS, .percentageGS, .amountGS`).removeClass(
                    "is-invalid"
                );
                $(
                    `#computationGS-error-message, #percentageGS-error-message, #amountGS-error-message`
                ).html("");
                // Collect data of form fields.
                $("#accountTitleGS").val(
                    governmentShareSettings.account.accountTitle
                );
                $("#computationGS").val(governmentShareSettings.computation);
                if (governmentShareSettings.computation == 0) {
                    $("#percentageGS, #amountGS").attr("disabled", true);
                    $("#percentageGS, #amountGS").val("");
                } else if (governmentShareSettings.computation == 1) {
                    $("#percentageGS").attr("disabled", false);
                    $("#amountGS").attr("disabled", true);
                    $("#percentageGS").val(
                        governmentShareSettings.percentage * 100
                    );
                    $("#amountGS").val("");
                } else {
                    $("#percentageGS").attr("disabled", true);
                    $("#amountGS").attr("disabled", false);
                    $("#percentageGS").val("");
                    $("#amountGS").val(governmentShareSettings.amount);
                }
            },
        });
    });

    //SAVE CHANGES of the Updated record government share
    $("#btnSaveChangesGS").click((e) => {
        e.preventDefault();
        $("#save-spinner").removeClass("d-none");
        let data = $("#goverment-share-form").serialize();
        $.ajax({
            url: `/maintenance/governmentShares/${gsCode}/update`,
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
                            `.computationGS, .percentageGS, .amountGS`
                        ).removeClass("is-invalid");
                        $(
                            `#computationGS-error-message, #percentageGS-error-message, #amountGS-error-message`
                        ).html("");
                        $("#goverment-share-table").DataTable().ajax.reload();
                    }, 1000);
                }
            },
            error: function (response) {
                if (response.status === 422) {
                    let errors = response.responseJSON.errors;
                    const inputNames = [
                        "computationgs",
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
                }
            },
        });
    });
});
