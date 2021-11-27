$(document).ready(function () {
    $("#addNewArticle").click(function () {
        $("#newArticleDiv").show(500);
    });

    $("#closeNewArticleDiv").click(function () {
        $("#newArticleDiv").hide(500);
    });
})

var previous;
var indexx;

function editArticle(index, indexOfArticle){
    previous = document.getElementById("body" + index).innerHTML;
    indexx = index;
    var title = document.getElementById("title"+index).innerText;
    var content = document.getElementById("content" + index).innerText;
    document.getElementById("body" + index).innerHTML = "<form method='post' enctype='multipart/form-data' autocomplete='on'> " +
        "<div class='mb-3 col-md-3 col-sm-12'>" +
        " <label for='Nadpis' class='form-label'>Nadpis</label>" +
        "<input type='text' class='form-control' id='Nadpis' name='titleEdit' value='"+title+"' placeholder='Nadpis' required></div>"+
        "<label for='abstract' class='form-label'>Abstrakt</label><br>"+
        "<textarea name='abstractEdit' class='w-50' style='height: 10vw;'>"+ content +"</textarea>"+
        "<br><label for='pdf_file' class='form-label'>Připojit soubor (.pdf)</label>"+
        "<div class='mb-3'>"+
        "<div class='mb-3 col-md-4 col-sm-12'>"+
        "<input type='file' class='form-control' name='pdf_file' aria-label='pdf_file' accept='application/pdf' required>"+
        "</div>"+
        "</div>"+
        "<div class='row '>"+
        "<div style='text-align: center;'><button type='submit' class='btn btn-success' name='action' value='editArticle'>Upravit článek</button>"+
        "<input type='hidden' name='id_articleEdit' value='"+indexOfArticle+"'>"+
        "<button type='button' class='btn btn-danger ms-3' name='action' id='cancelEditArticle' value='cancelEditArticle' onclick='closeEdit()'>zrušit</button></div>"+
        "</div>"+
        "</form>";
}

function closeEdit(){
    document.getElementById("body" + indexx).innerHTML = previous;
}

function deleteArticle(articleID) {
    var result = confirm("Opravdu si přejete odstranit daný příspěvěk?");

    if (result){
        $.post(
            "App/models/deleteArticle-ajax.php",

            {
                "articleID" : articleID
            },

            // reakce na odpoved
            function(response, status) {
                console.log(response);
                if( status == "success" ){
                    var article = "#article"+articleID;

                    $(article).remove();
                    alert("Příspěvek úspěšně vymazán!");
                }
                else if( status == "error" ){
                    alert("Došlo k chybě!");
                }
            }
        );
    }
    
}