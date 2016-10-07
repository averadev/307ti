<div class="row section" id=<?="section-people".$SECCION;?>>
    <div class="large-12 columns fiter-section">
        <div class="box" id=<?=$SECCION. "-boxPeopleSearch";?> relation-attr=<?= "box-people".$SECCION."-relation";?>>
            <div class="box-header pr-color">
                <div class="pull-right box-tools">
                    <span id=<?=$SECCION. "-minusPeople";?> class="box-btn" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </span>
                </div>
                <h3 class="box-title">
                    <span>People Search</span>
                </h3>
                <a data-widget="newContrat" id=<?=$SECCION. "-newUser";?> class="btn btn-new">
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
                                <input type="checkbox" id=<?=$SECCION. "-checkFilter1";?> class="checkFilter" value="peopleId">
                                <label for="checkFilter1">People Id</label>
                            </div>
                            <div class="rdoField">
                                <input type="checkbox" id=<?=$SECCION. "-checkFilter2";?> class="checkFilter" value="lastName" checked>
                                <label for="checkFilter2">Last name</label>
                            </div>
                            <div class="rdoField">
                                <input type="checkbox" id=<?=$SECCION. "-checkFilter3";?> class="checkFilter" value="Name" checked>
                                <label for="checkFilter3">Name</label>
                            </div>
                        </fieldset>
                    </div>
                    <div class="small-12 medium-12 large-12 columns">
                        <fieldset class="large-12 columns fieldsetFilter">
                            <div class="rdoField">
                                <input type="checkbox" id=<?=$SECCION. "-checkFilterAdvance";?> class="checkFilter">
                                <label for="checkFilterAdvance">Advanced search</label>
                            </div>
                            <div class="filtersAdvanced" id=<?=$SECCION. "-containerFilterAdv";?> style="display:none;">
                                <div class="rdoField">
                                    <input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="initials" id=<?=$SECCION. "-RadioInitials";?> checked>
                                    <label for="RadioInitials">initials / Employee code</label>
                                </div>
                                <div class="rdoField">
                                    <input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="EmailDesc" id=<?=$SECCION. "-RadioEmail";?>>
                                    <label for="RadioEmail">Email</label>
                                </div>
                                <div class="rdoField">
                                    <input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="Folio" id=<?=$SECCION. "-RadioFolio";?>>
                                    <label for="RadioFolio">Folio</label>
                                </div>
                                <div class="rdoField">
                                    <input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="ResCode" id=<?=$SECCION. "-RadioCode";?>>
                                    <label for="RadioCode">Contract Id</label>
                                </div>
                                <div class="rdoField">
                                    <input type="radio" name="advancedSearchPeople" class="RadioSearchPeople" value="FloorPlanDesc" id=<?=$SECCION. "-RadioFloorPlan";?>>
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
                                    <input type="text" id=<?=$SECCION. "-txtSearch";?> class="txtSearch" placeholder="Enter a search parameter" />
                                </div>
                                <div class="small-12 large-6 columns" style="padding-left: 0;">
                                    <a id=<?=$SECCION. "-btnSearch";?> class="btn btn-primary btn-Search" attr_people="">
                                        <div class="label">Search</div>
                                        <img src="<?php echo base_url().IMG; ?>common/BUSCAR.png" />
                                    </a>
                                    <a id=<?=$SECCION. "-btnCleanSearch";?> class="btn btn-primary spanSelect">
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
        <div class="box" id=<?="box-people".$SECCION."-relation";?>>
            <div class="box-header pr-color">
                <div class="pull-right box-tools">
                </div>
                <h3 class="box-title">
                <span>People Relation</span>
               </h3>
            </div>
            <div class="box-body" id=<?=$SECCION. "-section-table-people";?> style="display: block;">
                <div class="table" id=<?=$SECCION."-tb";?>>
                    <div class="" id="Contrato-divTablePeople">
                        <table id=<?=$SECCION."-tablePeople";?> class="display hover" class="cell-border" cellspacing="0" width="100%" style="display:none;">
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
                    <span id=<?=$SECCION."-NP";?>>Total:</span>
                        <div class="pagination" id=<?=$SECCION."-paginationPeople";?>>
                            <a href="#" class="first" data-action="first">&laquo;</a>
                            <a href="#" class="previous" data-action="previous">&lsaquo;</a>
                            <input type="text" class="general" readonly="readonly" />
                            <a href="#" class="next" data-action="next">&rsaquo;</a>
                            <a href="#" class="last" data-action="last">&raquo;</a>
                        </div>
                        <input type="hidden" id=<?=$SECCION."-paginationPeopleInput";?> value="true" />
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<div id=<?=$SECCION."-dialog-User";?> title="People"></div>
<script>
    var SECCION = '<?php echo $SECCION; ?>';
</script>
<script type="text/javascript" src="<?php echo base_url().JS; ?>peopleContrato.js"></script>