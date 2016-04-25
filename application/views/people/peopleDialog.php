<div class="row section" id="section-people">
    <div class="large-12 columns fiter-section">
        <div class="box" id="boxPeopleSearch" >
            <div class="box-header blue_divina">
                <div class="pull-right box-tools">
					<span id="minusPeople" class="box-btn" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</span>
                </div>
                <h3 class="box-title">
                    <span>People Search</span>
                </h3>
                <div class="pull-left box-tools">
					<span data-widget="newContrat" id="newUser">
						<img src="http://www.pms.307ti.com/Scripts/ext/images/icons/user_add.gif" alt="" />
						<span>New</span>
					</span>
                </div>
            </div>
            <div class="box-body" style="display: block;">
                <div class="row">
                    <div class="small-12 medium-12 large-5 columns">
                        <fieldset class="large-12 columns">
                            <legend>Choose a filter</legend>
                            <div class="rdoField">
                                <input type="checkbox" id="checkFilter1" class="checkFilter" value="peopleId">
                                <label for="checkFilter1">People Id</label>
                            </div>
                            <div class="rdoField">
                                <input type="checkbox" id="checkFilter2" class="checkFilter" value="lastName" checked>
                                <label for="checkFilter2">Last name</label>
                            </div>
                            <div class="rdoField">
                                <input type="checkbox" id="checkFilter3" class="checkFilter" value="Name" checked>
                                <label for="checkFilter3">Name</label>
                            </div>
                        </fieldset>
                    </div>
                    <div class="small-12 medium-12 large-6 columns">
                        <fieldset class="large-12 columns">
                            <legend>Enter the filter</legend>
                            <div class="row collapse">
                                <div class="large-10 columns">
                                    <input type="text" id="txtSearch" class="txtSearch" placeholder="Enter a search parameter" />
                                </div>
                                <div class="small-1 columns">
                                    <a  id="btnSearch" class="button postfix"><i class="fa fa-search"></i></a>
                                </div>
                                <div class="small-1 columns">
                                    <a id="btnCleanSearch" class="button postfix"><i class="fa fa-trash"></i></a>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="small-12 medium-12 large-12 columns">
                        <fieldset class="large-12 columns">
                            <legend><input type="checkbox" id="checkFilterAdvance" class="checkFilter">&nbsp;&nbsp;Advanced search</legend>
                            <div class="row" id="containerFilterAdv" style="display:none;">
                                <div class="rdoField">
                                    <input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="initials" id="RadioInitials" checked>
                                    <label for="RadioInitials">initials / Employee code</label>
                                </div>
                                <div class="rdoField">
                                    <input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="EmailDesc" id="RadioEmail">
                                    <label for="RadioEmail">Email</label>
                                </div>
                                <div class="rdoField">
                                    <input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="Folio" id="RadioFolio">
                                    <label for="RadioFolio">Folio</label>
                                </div>
                                <div class="rdoField">
                                    <input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="ResCode" id="RadioCode">
                                    <label for="RadioCode">Contract Id</label>
                                </div>
                                <div class="rdoField">
                                    <input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="FloorPlanDesc" id="RadioFloorPlan">
                                    <label for="RadioFloorPlan">Foor Plan</label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="large-12 columns">
        <div class="box">
            <div class="box-header blue_divina">
                <div class="pull-right box-tools">
                </div>
                <h3 class="box-title">
                    <span>Results</span>
                </h3>
            </div>
            <div class="box-body" id="section-table-people" style="display: block;">
                <div class=" table" >
                    <div class="" id="divTablePeople">
                        <table id="tablePeople" class="display hover" cellspacing="0" width="100%">
                            <thead>
                            <tr>
                                <th class="cellEdit" >Edit</th>
                                <th class="cellEdit" >Id</th>
                                <th class="cellGeneral" >Name</th>
                                <th class="cellGeneral">Last name</th>
                                <th class="cellGeneral">Gender</th>
                                <th class="cellDate" >Birth date</th>
                                <th class="cellAddress" >Street, number, colonia</th>
                                <th class="cellGeneral" >City</th>
                                <th class="cellGeneral" >State</th>
                                <th class="cellGeneral" >Country</th>
                                <th class="cellGeneral" >Zip code</th>
                                <th class="cellPhone" >Phone number 1</th>
                                <th class="cellPhone" >Phone number 2</th>
                                <th class="cellPhone" >Phone number 3</th>
                                <th class="cellEmail" >Email</th>
                                <th class="cellEmail" >Email 2</th>
                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
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

</div>
<script>
    $('#btnCleanWordPeople').click(function (){
        document.getElementById("stringPeople").value = "";
    });
    $('#btnfindPeople').click(function(){
        getPeople();
    });
    $("#busquedaAvanazadaPeople").click(function() {
        $("#avanzadaPeople").slideToggle("slow");
    });

</script>