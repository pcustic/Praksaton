$( document ).ready( function(){
    //na svaku registraciju tvrtke provjeri podatke i javi gresku ako su podaci krivo upisani
    $("form").submit(function(event){
        var input = $("input");

        var textTest = /^[A-Za-z.,:;-_!? #čćžđšČĆŽĐŠ\+0-9\n]+$/;
        var emailTest = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var passwordTest =/^[A-Za-z.,-_!? čćžđšČĆŽĐŠ0-9]+$/;

        var name = input.eq(0).val();
        var email = input.eq(1).val();
        var password = input.eq(2).val();
        var description = $("textarea").eq(0).val();

        if(textTest.test(name) === false){
            $('#error').html('Naziv nije dobro unesen! Morate koristiti samo slova, brojke i osnovne dijakritičke znakove.').css('color', 'red');
            event.preventDefault();
        } else if(emailTest.test(email) === false){
            $('#error').html('Email nije dobro unesen!').css('color', 'red');
            event.preventDefault();
        }
        else if(passwordTest.test(password) === false){
            $('#error').html('Lozinka nije dobro unesena!').css('color', 'red');
            event.preventDefault();
        }
        else if(textTest.test(description) === false){
            $('#error').html('Polje "O nama" nije dobro uneseno! Morate koristiti samo slova, brojke i osnovne dijakritičke znakove.').css('color', 'red');
            event.preventDefault();
        }
    });

});
