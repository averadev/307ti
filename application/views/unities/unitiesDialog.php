<div class="large-12 columns">
    <div class="box">
        <div class="box-header green">
            <div class="pull-right box-tools">
					<span class="box-btn" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</span>
            </div>
            <h3 class="box-title">
                <span>Add Unidades</span>
            </h3>
        </div>
        <div class="box-body" style="display: block;">
            <div class="row">
                <!-- Property-->
                <div class="row">
                    <div class="small-3 columns">
                        <label for="property" class="text-left">Property</label>
                    </div>
                    <div class="small-9 columns">
                        <select type="text" id="property" name="property" class="general" required></select>
                    </div>
                </div>
                <!-- Unit Type-->
                <div class="row">
                    <div class="small-3 columns">
                        <label for="unitType" class="text-left">Unit Type</label>
                    </div>
                    <div class="small-9 columns">
                        <select type="text" id="unitType" name="unitType" class="general" required></select>
                    </div>
                </div>
                <!-- Frequency-->
                <div class="row">
                    <div class="small-3 columns">
                        <label for="frequency" class="text-left">Frequency</label>
                    </div>
                    <div class="small-9 columns">
                        <select type="text" id="frequency" name="frequency" class="general" required></select>
                    </div>
                </div>
                <!-- Season-->
                <div class="row">
                    <div class="small-3 columns">
                        <label for="season" class="text-left">Season</label>
                    </div>
                    <div class="small-9 columns">
                        <select type="text" id="season" name="season" class="general" required></select>
                    </div>
                </div>
                <!-- interval-->
                <div class="row">
                    <div class="small-3 columns">
                        <label for="interval" class="text-left">Interval</label>
                    </div>
                    <div class="small-9 columns">
                        <select type="text" id="interval" name="interval" class="general" required></select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="medium-12columns">
                    <div class="row">
                        <div class="large-12 columns">
                            <div class="row">
                                <div class="small-6 columns">

                                </div>
                                <div class="small-6 columns">
                                    <a  id="btngetUnidades" href="#" class="button postfix"><i class="fa fa-search"></i></a>
<!--                                    <a id="btnClearSelects"  href="#" class="button postfix"><i class="fa fa-trash"></i></a>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="large-12 columns">
    <div class="box">
        <div class="box-header blue_divina">

        </div>
        <div class="box-body" style="display: block;">
            <div class=" table" >
                <table id="tblUnidades" style="width:100%;">
                    <thead id="Unidadesthead"></thead>
                    <tbody id="Unidadestbody"></tbody>
                </table>
            </div>
            <div class="pagina" >
                <div class="pages">
                    <div class="pagination" id="paginationPeople">
                        <a href="#" class="first" data-action="first">&laquo;</a>
                        <a href="#" class="previous" data-action="previous">&lsaquo;</a>
                        <input type="text" class="general" readonly="readonly" />
                        <a href="#" class="next" data-action="next">&rsaquo;</a>
                        <a href="#" class="last" data-action="last">&raquo;</a>
                    </div>
                    <input type="hidden" id="paginationPeople" value="true" />
                </div>
            </div>
        </div>
    </div>
</div>
<script>

    ajaxSelects('contract/getProperties','try again', generalSelects, 'property');
    ajaxSelects('contract/getUnitTypes','try again', generalSelects, 'unitType');
    ajaxSelects('contract/getFrequencies','try again', generalSelects, 'frequency');
    ajaxSelects('contract/getSeasons','try again', generalSelects, 'season');

    $('#btnClearSelects').click(function () {
        $('#property').empty();
        $('#unitType').empty();
        $('#frequency').empty();
        $('#season').empty();
    });


    $('#btngetUnidades').click(function(){
        getUnidades();
    });

    $('#busquedaAvanazadaUnidades').click(function(){
        $("#avanzadaUnidades").slideToggle("slow");
    });

    function getUnidades(){
        showLoading('#tblUnidades',true);
        $.ajax({
            data:{
                words: "1"
            },
            type: "POST",
            url: "contract/getUnidades",
            dataType:'json',
            success: function(data){
                if(data != null){
                    showLoading('#tblUnidades',false);
                    alertify.success("Found "+ data.length);
                    drawTable(data, 'add', "details", "Unidades");
                }else{
                    $('#contractstbody').empty();
                    alertify.error("No data found");
                }
            },
            error: function(){
                alertify.error("Try again");
            }
        });
    }
</script>