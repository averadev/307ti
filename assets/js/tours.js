/**
 * Created by Faustino on 20/04/2016.
 */
//Tours
$(document).ready(function(){
    maxHeight = screen.height * .25;
    maxHeight = screen.height - maxHeight;

    $(document).on( 'click', '#newTour', function () {
        var addTour = dialogAddTour();
        addTour.dialog("open");
        console.log("=D");
    });
    $('#btnCleanWordTour').click(function (){ 
        $("#stringTour").val("");
    });
    $('#btnfindTour').click(function(){
        getTours();
    });
    $("#advanceSearchTour").click(function() {
        $("#advanceTour").slideToggle("slow");
    });
});


function dialogAddTour(){
    var div = '#dialog-tourID';
    dialogo = $("#dialog-tourID").dialog ({
        open : function (event){
            if ($(div).is(':empty')) {
                showLoading(div,true);
                $(this).load ("tours/modalAddTour" , function(){
                    showLoading(div,false);
                });
            }
        },
        autoOpen: false,
        height: maxHeight,
        width: "50%",
        modal: true,
        buttons: [{
            text: "Cancel",
            "class": 'dialogModalButtonCancel',
            click: function() {
                $(this).dialog('close');
           }
        },{
            text: "ok",
            "class": 'dialogModalButtonAccept',
            click: function() {
                $(this).dialog('close');
            }
        }],
     close: function() {
     }
    });
    return dialogo;
}

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
                //drawTable(data, 'getDetalleTourByID', "details", "tours");
				drawTable2(data, "tours", false, "");
            }else{
                alertify.error("No data found");
                showLoading("#tblToursbody", false);
                var img = '<div class="divNoResults"><div class="noResultsScreen"><img src="http://localhost/307ti/assets/img/common/SIN RESULTADOS-01.png"> <label> Oh no! No Results. Try again. </label></div></div>';
                $('#tourstbody').html(img);
            }
        },
        error: function(){
            alertify.error("Conection Error");
        }
    });
}

function getDetalleTourByID(id){
	
}