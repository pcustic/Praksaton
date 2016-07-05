$( document ).ready( function(){
    //disable button search dok se nesto ne upise

    $('#searchButton').prop('disabled', true);

    $('#searchText').on("input", function(){
        console.log("usa");
        if($("#searchText").val() === '')
            $('#searchButton').prop('disabled', true);
        else
            $('#searchButton').eq(0).prop('disabled', false);
    });

});
