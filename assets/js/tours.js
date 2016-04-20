/**
 * Created by Faustino on 20/04/2016.
 */
//Tours
$('#btnCleanWordTour').click(function (){ document.getElementById("stringTourID").value = "";});
$('#btnfindTour').click(function(){getTours();});
$("#advanceSearchTour").click(function() {$("#advanceTour").slideToggle("slow");});

function getTours(){

    showLoading('#tours',true);
    var filters = getFiltersCheckboxs("filter_tourID");
    var arrayDate = ["startDateTour", "endDateTour"];
    var dates = getDates(arrayDate);
    var arrayWords = ["stringTour"];
    var words = getWords(arrayWords);

    $.ajax({
        data:{
            filters: filters,
            dates: dates,
            words: words
        },
        type: "POST",
        url: "contract/getTours",
        dataType:'json',
        success: function(data){
            showLoading('#tours',false);
            if(data != null){
                alertify.success("Found "+ data.length);
                drawTable(data, 'getDetalleContratoByID', "details", "tours");
            }else{
                alertify.error("No data found");
                showLoading("#tblToursbody", false);
            }
        },
        error: function(){
            alertify.error("Conection Error");
        }
    });
}