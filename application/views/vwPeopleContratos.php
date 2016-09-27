<div class="row section" id="section-people">
    <div class="large-12 columns fiter-section">
        <div class="box" id="Contrato-boxPeopleSearch" relation-attr="box-people-relation">
            <div class="box-header pr-color">
                <div class="pull-right box-tools">
                    <span id="Contrato-minusPeople" class="box-btn" data-widget="collapse">
						<i class="fa fa-minus"></i>
					</span>
                </div>
                <h3 class="box-title">
					<span>People Search</span>
				</h3>
                <a data-widget="newContrat" id="Contrato-newUser" class="btn btn-new">
                    <div class="label">New</div>
                    <img src="<?php echo base_url().IMG; ?>common/more.png" />
                </a>
            </div>
            <div class="box-body box-filter" style="">
                <div class="row">
                    <div class="small-12 medium-12 large-12 columns">
                        <fieldset class="large-12 columns fieldsetFilter">
                            <legend class="legendSearch">Choose a filter</legend>
                            <div class="rdoField">
                                <input type="checkbox" id="Contrato-checkFilter1" class="checkFilter" value="peopleId">
                                <label for="checkFilter1">People Id</label>
                            </div>
                            <div class="rdoField">
                                <input type="checkbox" id="Contrato-checkFilter2" class="checkFilter" value="lastName" checked>
                                <label for="checkFilter2">Last name</label>
                            </div>
                            <div class="rdoField">
                                <input type="checkbox" id="Contrato-checkFilter3" class="checkFilter" value="Name" checked>
                                <label for="checkFilter3">Name</label>
                            </div>
                        </fieldset>
                    </div>
                    <div class="small-12 medium-12 large-12 columns">
                        <fieldset class="large-12 columns fieldsetFilter">
                            <div class="rdoField">
                                <input type="checkbox" id="Contrato-checkFilterAdvance" class="checkFilter">
                                <label for="checkFilterAdvance">Advanced search</label>
                            </div>
                            <div class="filtersAdvanced" id="Contrato-containerFilterAdv" style="display:none;">
                                <div class="rdoField">
                                    <input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="initials" id="Contrato-RadioInitials" checked>
                                    <label for="RadioInitials">initials / Employee code</label>
                                </div>
                                <div class="rdoField">
                                    <input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="EmailDesc" id="Contrato-RadioEmail">
                                    <label for="RadioEmail">Email</label>
                                </div>
                                <div class="rdoField">
                                    <input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="Folio" id="Contrato-RadioFolio">
                                    <label for="RadioFolio">Folio</label>
                                </div>
                                <div class="rdoField">
                                    <input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="ResCode" id="Contrato-RadioCode">
                                    <label for="RadioCode">Contract Id</label>
                                </div>
                                <div class="rdoField">
                                    <input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="FloorPlanDesc" id="Contrato-RadioFloorPlan">
                                    <label for="RadioFloorPlan">Foor Plan</label>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="small-12 medium-12 large-12 columns">
                        <fieldset class="large-12 columns fieldsetFilter">
                            <legend class="legendSearch">Enter the filter</legend>
                            <div class="row">
                                <div class="large-6 columns">
                                    <input type="text" id="Contrato-txtSearch" class="txtSearch" placeholder="Enter a search parameter" />
                                </div>
                                <div class="small-12 large-6 columns" style="padding-left: 0;">
                                    <a id="Contrato-btnSearch" class="btn btn-primary btn-Search" attr_people="">
                                        <div class="label">Search</div>
                                        <img src="<?php echo base_url().IMG; ?>common/BUSCAR.png" />
                                    </a>
                                    <a id="Contrato-btnCleanSearch" class="btn btn-primary spanSelect">
                                        <div class="label">Clean</div>
                                        <img src="<?php echo base_url().IMG; ?>common/BORRAR2.png" />
                                    </a>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="large-12 columns">
        <div class="box" id="box-people-relation">
            <div class="box-header pr-color">
                <div class="pull-right box-tools">
                </div>
                <h3 class="box-title">
               	<span>People Relation</span>
               </h3>
            </div>
            <div class="box-body" id="Contrato-section-table-people" style="display: block;">
                <div class="table" id="Contrato-tb">
                    <div class="" id="Contrato-divTablePeople">
                        <table id="Contrato-tablePeople" class="display hover" class="cell-border" cellspacing="0" width="100%" style="display:none;">
                            <thead>
                                <tr>
                                    <th>Edit</th>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Last name</th>
                                    <th>Gender</th>
                                    <th>Birth date</th>
                                    <th>Street, number, colonia</th>
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Country</th>
                                    <th>Zip code</th>
                                    <th>Phone number 1</th>
                                    <th>Phone number 2</th>
                                    <th>Phone number 3</th>
                                    <th>Email</th>
                                    <th>Email 2</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="pagina">
                    <div class="pages">
                        <div class="pagination" id="Contrato-paginationPeople">
                            <a href="#" class="first" data-action="first">&laquo;</a>
                            <a href="#" class="previous" data-action="previous">&lsaquo;</a>
                            <input type="text" class="general" readonly="readonly" />
                            <a href="#" class="next" data-action="next">&rsaquo;</a>
                            <a href="#" class="last" data-action="last">&raquo;</a>
                        </div>
                        <input type="hidden" id="Contrato-paginationPeople" value="true" />
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div id="Contrato-dialog-User" title="People"></div>
<script type="text/javascript" src="<?php echo base_url().JS; ?>peopleContrato.js"></script>