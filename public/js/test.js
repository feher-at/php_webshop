$(document).ready(function(){
    $("#payments").change(function(){
       let selectedValue = $(this).children("option:selected").val();
       if(selectedValue === "transaction")
       {
           $( "#number_input" ).prop( "disabled", false );
           $( "#recipient_input" ).prop( "disabled", false );
           $( "#branch_bank" ).prop( "disabled", false );
       }
        else
       {
           $( "#number_input" ).prop( "disabled", true );
           $( "#recipient_input" ).prop( "disabled", true );
           $( "#branch_bank" ).prop( "disabled", true );
       }

    });
});





