$( document ).ready( function(){
    //testira podatke nove prakse i ispisuje gresku ako je nesto lose uneseno
    $("form").submit(function(event){
        var textTest = /^[A-Za-z.,:;-_!? #čćžđšČĆŽĐŠ\*0-9\n]+$/;

        var title = $("input").eq(1).val(); //imamo jedan hidden input
        var description = $("textarea").eq(0).val();
        var requirements = $("textarea").eq(1).val();
        console.log(title + " " + description + " " + requirements);

        if(textTest.test(title) === false){
            $('#error').html('Naziv prakse nije dobro unesen! Morate koristiti samo slova, brojke i osnovne dijakritičke znakove.').css('color', 'red');
            event.preventDefault();
        } else if(textTest.test(description) === false){
            $('#error').html('Opis nije dobro unesen! Morate koristiti samo slova, brojke i osnovne dijakritičke znakove.').css('color', 'red');
            event.preventDefault();
        }
        else if(textTest.test(requirements) === false){
            $('#error').html('Uvjeti nisu dobro uneseni! Morate koristiti samo slova, brojke i osnovne dijakritičke znakove.').css('color', 'red');
            event.preventDefault();
        }
    });
});
