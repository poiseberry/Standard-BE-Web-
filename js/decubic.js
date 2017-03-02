$(".date").datetimepicker({
    format: "YYYY-MM-DD"
});

$(".datetime").datetimepicker({
    format: "YYYY-MM-DD H:mm:ss"
});

$(".alpha").alphanum({
    allowSpace: true,
    allowNewline: false,
    allowNumeric: false,
    allowUpper: true,
    allowLower: true,
    allowCaseless: true,
    allowOtherCharSets: false,
});

$(".number").alphanum({
    allowSpace: false,
    allowNewline: false,
    allowNumeric: true,
    allowUpper: false,
    allowLower: false,
    allowCaseless: true,
    allowOtherCharSets: false,
});

$('input').attr('autocomplete', 'off');

$(".price").autoNumeric("init", {
    aSep: ',',
    aDec: '.',
    aForm: false
});
