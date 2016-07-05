$( document ).ready( function(){
    //na svaki login provjeri podatke i javi gresku ako su podaci krivo upisani
    $("form").submit(function(event){
        var input = $("input");

        var emailTest = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        var passwordTest =/^[A-Za-z.,-_!? čćžđšČĆŽĐŠ0-9]+$/;
        var email = input.eq(0).val();
        var password = input.eq(1).val();

        if(emailTest.test(email) === false){
            $('#error').html('Email nije dobro unesen!').css('color', 'red');
            event.preventDefault();
        }
        else if(passwordTest.test(password) === false){
            $('#error').html('Lozinka nije dobro unesena!').css('color', 'red');
            event.preventDefault();
        }
    });

});
