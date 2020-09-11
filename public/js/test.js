$(document).ready(function(){
    $("#payments").change(function(){
       let selectedValue = $(this).children("option:selected").val();
       if(selectedValue === "transaction")
       {
           makeBankBranchDiv();
       }
        else
       {
           removeDom();
       }

    });
});

function makeBankBranchDiv()
{
    let labelDiv =$("<div id='branch_label_div' class='mr-3'></div>");
    let label = $("<label></label>").text("Bank");
    labelDiv.append(label);
    let bankBranchDiv = $("<div id='branch_bank_div' class='align-content-center'></div>");
    let otpOption = $("<option value='Otp' id='otpOption'></option>").text("Otp");
    let ersteOption = $("<option value='Erste' id='ersteOption'></option>").text("Erste");
    let cibOption = $("<option value='Cib' id='cibOption'></option>").text("Cib");
    let card = $("<select name='branch_bank' id='branch_bank' class='mr-5'>");
    card.append(otpOption,ersteOption,cibOption);
    bankBranchDiv.append(card);
    $("#card_data").append(labelDiv,bankBranchDiv);
    makeBankNumber();
    makeRecipient();

}

function makeBankNumber()
{
    let labelDiv = $("<div id='number_label_div' class='mr-5'></div>")
    let label = $("<label></label>").text("Bank number");
    labelDiv.append(label);
    let inputBankNumber = $("<input name='bank_number_input'/>")
    let inputDiv = $("<div id='number_input_div' class='mr-5'></div>")
    inputDiv.append(inputBankNumber)
    $("#card_data").append(labelDiv,inputDiv);
}

function makeRecipient()
{
    let labelDiv = $("<div id='recipient_label_div' class='mr-3'></div>")
    let label = $("<label></label>").text("Recipient");
    labelDiv.append(label);
    let inputBankNumber = $("<input name='recipient_input'/>")
    let inputDiv = $("<div id='recipient_input_div' class='mr-3'></div>")
    inputDiv.append(inputBankNumber)
    $("#card_data").append(labelDiv,inputDiv);
}

function removeDom()
{
    $("#card_data").empty();
}
