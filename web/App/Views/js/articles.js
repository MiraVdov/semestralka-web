/**
 * Funkce schova pdf soubor
 * @param index
 */
function hidePDFFile(index){
    document.getElementById("showPDF"+index).style.display = "none";
}

/**
 * Funkce zobrazi pdf soubor
 * @param index
 */
function showPDFFile(index){
    document.getElementById("showPDF"+index).style.display = "block";
}