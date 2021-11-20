//funkce slouzi  zobrazeni loginu
$(document).ready(function () {
    // formátování datumu
    dateFormat();

    $(".pdfFiles").hide();

    $(".hidePDFFiles").hide();
});

function showPDFFile(index){
    $("#pdfFile" + index).show();
    $("#hidePDFFile" + index).show();
}

function hidePDFFile(index){
    $("#pdfFile" + index).hide();
    $("#hidePDFFile" + index).hide();
}