///////////////////////////CKEDITOR/////////////////////////
ClassicEditor
    .create( document.querySelector( '.editor' ))
    .catch( error => {
        console.log( error );
    } );


    $('.editor').each(function () {
        ClassicEditor.replace($(this).prop('id'));
});




