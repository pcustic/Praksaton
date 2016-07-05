$( document ).ready( function(){
    //ako je status == primljen ili odbijen onda disableaj buttone primi, odbij

    var statusList = $(".status");
    var primljenList = $(".primljen");
    var odbijenList = $(".odbijen");

    for(var i = 0; i<statusList.length; ++i){
        var status = statusList.eq(i).html();
        console.log("status: " + status);
        if(status === "primljen" || status === "odbijen"){
            $(".primljen").eq(i).prop("disabled", true);
            $(".odbijen").eq(i).prop("disabled", true);
        }
    }
});
