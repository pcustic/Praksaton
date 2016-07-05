$( document ).ready( function(){
    //disable button search dok se nesto ne upise
    $('#searchButton').prop('disabled', true);

    $('#searchText').on("input", function(){
        if($("#searchText").val() === '')
            $('#searchButton').prop('disabled', true);
        else
            $('#searchButton').eq(0).prop('disabled', false);
    });

    //na svaki submit provjeri podatke i javi gresku ako su podaci krivo upisani
    $("form").submit(function(event){
        var textarea = $("textarea");

        for(var i = 0; i<textarea.length; ++i){
            var tekst = textarea.eq(i).val();
            var regex = /^[A-Za-z.,:;-_!? #čćžđšČĆŽĐŠ\+0-9\n]*$/;
            if(regex.test(tekst) === false){
                if(textarea.eq(i).prop("name") === "education"){
                    $('#error').html('Obrazovanje nije dobro uneseno. Morate koristiti samo slova, brojke i osnovne dijakritičke znakove.').css('color', 'red');
                }
                else if(textarea.eq(i).prop("name") === "experience"){
                    $('#error').html('Iskustvo nije dobro uneseno. Morate koristiti samo slova, brojke i osnovne dijakritičke znakove.').css('color', 'red');
                }
                else if(textarea.eq(i).prop("name") === "projects"){
                    $('#error').html('Projekti/radovi nisu dobro unešeni. Morate koristiti samo slova, brojke i osnovne dijakritičke znakove.').css('color', 'red');
                }
                else if(textarea.eq(i).prop("name") === "prizes"){
                    $('#error').html('Nagrade nisu dobro unesene. Morate koristiti samo slova, brojke i osnovne dijakritičke znakove.').css('color', 'red');
                }
                event.preventDefault();
                break;
            }
        }
    });

});
