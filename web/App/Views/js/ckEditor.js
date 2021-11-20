///////////////////////////CKEDITOR/////////////////////////
ClassicEditor
    .create( document.querySelector( '#editor' ))
    .catch( error => {
        console.log( error );
    } );

/*
var editors = [];
function createEditor( elementId, data ) {
    return ClassicEditor
        .create( document.querySelector( '#' + elementId ) )
        .then( editor => {
        editors[ elementId ] = editor;
        editor.setData( data ); // You should set editor data here
    } )
        .catch( err => console.error( err ) );
}

$(document).ready( function() {
    createEditor( 'editor', 'test' );
    createEditor( 'director1', 'test' );
});
 */