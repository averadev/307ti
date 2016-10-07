<div class="tabsModal" id=<?=$SECCION."-tabsModalPeople";?>>
    <ul class="tabs" data-tabs>
        <li class="tabs-title active" attr-screen=<?=$SECCION."-tab-PGeneral";?>>
            <a>General</a>
        </li>
        <li class="tabs-title" attr-screen=<?=$SECCION."-tab-PReservaciones";?>>
            <a>Reservations</a>
        </li>
        <li class="tabs-title" attr-screen=<?=$SECCION."-tab-PContratos";?>>
            <a>Contract</a>
        </li>
        <li class="tabs-title" attr-screen=<?=$SECCION."-tab-PEmpleados";?>>
            <a>Employee</a>
        </li>
    </ul>
</div>
<div class="large-12 columns contentModal" id=<?=$SECCION."-contentModalPeople";?>>

    <div id=<?=$SECCION."-tab-PGeneral";?> class="large-12 columns tab-modal" style="display:inline;">
        <div class="row" id=<?=$SECCION."-alertValPeopleGeneral";?> style="display:inline;">
            <div class="small-12 columns">
                <div class="callout alert">
                    Please complete fields in red
                </div>
            </div>
        </div>

        <fieldset class="fieldset">
            <legend>Personal information</legend>
            <!-- nombre-->
            <div class="row">
                <div class="small-12 large-3 columns">
                    <label id="alertName" for="right-label" class="text-left">Name</label>
                </div>
                <div class="small-12 large-9 columns">
                    <input type="text" id=<?=$SECCION."-textName";?> class="round general mayuscula">
                </div>
            </div>
            <!-- segundo nombre-->
            <div class="row">
                <div class="small-12 large-3 columns">
                    <label id=<?=$SECCION."-alertMiddleName";?> for="right-label" class="text-left">Middle name</label>
                </div>
                <div class="small-12 large-9 columns">
                    <input type="text" id=<?=$SECCION."-textMiddleName";?> class="round general mayuscula">
                </div>
            </div>
            <!-- apellido paterno-->
            <div class="row">
                <div class="small-12 large-3 columns">
                    <label id=<?=$SECCION."-alertLastName";?> for="right-label" class="text-left">Last name</label>
                </div>
                <div class="small-12 large-9 columns">
                    <input type="text" id=<?=$SECCION."-textLastName";?> class="round general mayuscula">
                </div>
            </div>
            <!-- apellido materno-->
            <div class="row">
                <div class="small-12 large-3 columns">
                    <label for="right-label" class="text-left">Second last name</label>
                </div>
                <div class="small-12 large-9 columns">
                    <input type="text" id=<?=$SECCION."-TextSecondLastName";?> class="round general mayuscula">
                </div>
            </div>
            <!-- genero -->
            <div class="row">
                <div class="small-12 large-3 columns">
                    <label id=<?=$SECCION."-alertGender";?> for="right-label" class="text-left">Gender</label>
                </div>
                <div class="small-12 large-9 columns">
                    <input type="radio" name="RadioGender" class="RadioGender" value="M" id=<?=$SECCION."-RadioMale";?> required>
                    <label for="RadioMale">Male</label>
                    <input type="radio" name="RadioGender" class="RadioGender" value="F" id=<?=$SECCION."-RadioFemale";?>>
                    <label for="RadioFemale">Female</label>
                </div>
            </div>

            <div class="row">
                <!-- fecha de nacimiento-->
                <div class="small-12 large-6 columns" style="float:right">
                    <label id=<?=$SECCION."-alertBirthdate";?> class="text-left">Birth date
                        <div class="input-group date" id="dateBirthdate">
                            <span class="input-group-label prefix"><i class="fa fa-calendar"></i></span>
                            <input type="text" id=<?=$SECCION."-textBirthdate";?> class="input-group-field roundRight" readonly/>
                        </div>
                    </label>
                </div>

                <!-- aniversario boda-->
                <div class="small-12 large-6 columns">
                    <label id="alertWeddingAnniversary" for="textWeddingAnniversary" class="text-left">Wedding anniversary
                        <div class="input-group date" id=<?=$SECCION."-dateAnniversary";?>>
                            <span class="input-group-label prefix"><i class="fa fa-calendar"></i></span>
                            <input type="text" id=<?=$SECCION."-textWeddingAnniversary";?> class="input-group-field roundRight" readonly/>
                        </div>
                    </label>
                </div>
            </div>

            <div class="row">
                <!-- Nacionalidad-->
                <div class="small-12 large-6 columns">
                    <label id="alertNationality" for="textNationality" class="text-left">Nationality
                        <div class="caja">
                            <select id=<?=$SECCION."-textNationality";?> class="input-group-field round">
                                <option value="0">Select your nationality</option>
                                <?php foreach($nationality as $item){ ?>
                                <option value="<?php echo $item->Nationality; ?>">
                                    <?php echo $item->Nationality; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </label>
                </div>
                <!-- Calificacion-->
                <div class="small-12 large-6 columns">
                    <label class="text-left">Qualification
                        <div class="caja">
                            <select id=<?=$SECCION."-textQualification";?> class="input-group-field round">
                                <option value="0">Select your Qualification</option>
                                <?php foreach($qualifications as $item){ ?>
                                <option value="<?php echo $item->ID; ?>">
                                    <?php echo $item->Description; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </label>
                </div>
            </div>
        </fieldset>
        <!-- Datos del domicilio -->
        <div class="row" id=<?=$SECCION."-alertValPeopleAddress";?> style="display:none;">
            <div class="small-12 columns">
                <div class="callout alert">
                    Please complete fields in red
                </div>
            </div>
        </div>
        <fieldset class="fieldset">
            <legend class="btnAddressData"><img id=<?=$SECCION."-imgCoppapseAddress";?> class="imgCollapseFieldset down" src="<?php echo base_url().IMG; ?>common/iconCollapseDown.png" />Address data</legend>
            <div id=<?=$SECCION."-containerAddress";?> style="display:none;">
                <!-- calle, numero-->
                <div class="row">
                    <div class="small-12 large-3 columns">
                        <label id=<?=$SECCION."-alertStreet";?> for="textStreet" class="text-left">Street</label>
                    </div>
                    <div class="small-12 large-9 columns">
                        <input id=<?=$SECCION."-textStreet";?> type="text" class="round general">
                    </div>
                </div>
                <!-- Colonia -->
                <div class="row">
                    <div class="small-12 large-3 columns">
                        <label id=<?=$SECCION."-alertColony";?> for="textColony" class="text-left">Street 2</label>
                    </div>
                    <div class="small-12 large-9 columns">
                        <input id=<?=$SECCION."-textColony";?> type="text" class="round general">
                    </div>
                </div>

                <div class="row">
                    <!-- Pais -->
                    <div class="small-12 large-6 columns">
                        <label id=<?=$SECCION."-alertCountry";?> for="textCountry" class="text-left">Country
                            <div class="caja">
                                <select id=<?=$SECCION."-textCountry";?> class="input-group-field round">
                                    <option value="0" code="0">Select your country</option>
                                    <?php foreach($country as $item){ ?>
                                    <option value="<?php echo $item->pkCountryId; ?>" code="<?php echo $item->CountryCode; ?>">
                                        <?php echo $item->CountryDesc; ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </label>
                    </div>
                    <!-- Estado-->
                    <div class="small-12 large-6 columns">
                        <label id="alertState" for="textState" class="text-left">State
                            <div class="caja">
                                <select id=<?=$SECCION."-textState";?> class="input-group-field round">
                                    <option value="0" code="0">Select your state</option>
                                </select>
                            </div>
                        </label>
                    </div>
                </div>

                <div class="row">
                    <!-- Ciudad -->
                    <div class="small-12 large-6 columns">
                        <label id="alertCity" for="textCity" class="text-left">City
                            <input id=<?=$SECCION."-textCity";?> type="text" class="round general">
                        </label>
                    </div>
                    <!-- Zip Code -->
                    <div class="small-12 large-6 columns">
                        <label id=<?=$SECCION."-alertPostalCode";?> for=<?=$SECCION."-alertPostalCode";?> class="text-left">Zip Code
                            <input id=<?=$SECCION."-textPostalCode";?> type="text" class="round general">
                        </label>
                    </div>
                </div>

            </div>
        </fieldset>
        <!-- Datos del contacto -->
        <div class="row" id=<?=$SECCION."-alertValPeopleContact";?> style="display:none;">
            <div class="small-12 columns">
                <div class="callout alert">
                    Please complete fields in red
                </div>
            </div>
        </div>
        <fieldset class="fieldset">
            <legend class="btnContactData"><img id="imgCoppapseContact" class="imgCollapseFieldset down" src="<?php echo base_url().IMG; ?>common/iconCollapseDown.png" />Contact information</legend>
            <div id=<?=$SECCION."-containerContact";?> style="display:none">
                <!-- Telefono 1-->
                <div class="row">
                    <div class="small-12 large-3 columns">
                        <label id=<?=$SECCION."-alertPhone1";?> for="textPhone1" class="text-left">Phone number 1</label>
                    </div>
                    <div class="small-12 large-9 columns">
                        <input type="tel" class="phonePeople round general" id=<?=$SECCION."-textPhone1";?> maxlength="11" placeholder="xxxx-xxx-xxxx">
                    </div>
                </div>
                <!-- Telefono 2 -->
                <div class="row">
                    <div class="small-12 large-3 columns">
                        <label id=<?=$SECCION."-alertPhone2";?> for="textPhone2" class="text-left">Phone number 2</label>
                    </div>
                    <div class="small-12 large-9 columns">
                        <input type="tel" class="phonePeople round general" id=<?=$SECCION."-textPhone2";?> maxlength="11" placeholder="xxxx-xxx-xxxx">
                    </div>
                </div>
                <!-- Telefono 3 -->
                <div class="row">
                    <div class="small-12 large-3 columns">
                        <label id=<?=$SECCION."-alertPhone3";?> for="textPhone3" class="text-left">Phone number 3</label>
                    </div>
                    <div class="small-12 large-9 columns">
                        <input type="tel" class="phonePeople round general" id=<?=$SECCION."-textPhone3";?> maxlength="11" placeholder="xxxx-xxx-xxxx">
                    </div>
                </div>
                <!-- Email 1 -->
                <div class="row">
                    <div class="small-12 large-3 columns">
                        <label id=<?=$SECCION."-alertEmail1";?> for="textEmail1" class="text-left">Email 1</label>
                    </div>
                    <div class="small-12 large-9 columns">
                        <input type="email" class="emailPeople round general" id=<?=$SECCION."-textEmail1";?>>
                    </div>
                </div>
                <!-- Email 2 -->
                <div class="row">
                    <div class="small-12 large-3 columns">
                        <label id=<?=$SECCION."-alertEmail2";?> for="textEmail2" class="text-left">Email 2</label>
                    </div>
                    <div class="small-12 large-9 columns">
                        <input type="email" class="emailPeople round general" id=<?=$SECCION."-textEmail2";?>>
                    </div>
                </div>
            </div>
        </fieldset>
    </div>
    <div id=<?=$SECCION."-tab-PReservaciones";?> class="large-12 columns tab-modal">
        <div class="row tab-modal-top" id=<?=$SECCION."-divTableReservationsPeople";?>>
            <div class="large-12 columns table-section2">
                <table id=<?=$SECCION."-tableReservationsPeople";?> width="100%" class="cell-border">
                    <thead>
                        <tr>
                            <th class="cellGeneral">Res. code</th>
                            <th class="cellSmall">ResId</th>
                            <th class="cellMedium">Res Type</th>
                            <th class="cellGeneral">Year</th>
                            <th class="cellGeneral">Night num</th>
                            <th class="cellBig">Floor plan</th>
                            <th class="cellMedium">Season</th>
                            <th class="cellMedium">Occupancy type</th>
                            <th class="cellBig">Date</th>
                            <th class="cellSmall">Interval</th>
                            <th class="cellSmall">Unit</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id=<?=$SECCION."-tab-PContratos";?> class="large-12 columns tab-modal">

        <div class="row tab-modal-top">
            <div class="small-12 large-centered columns">
                <div class="row">
                    <div class="large-6 columns">
                        <input type="text" id="textSearchContractPeople" class="general txtSearch" placeholder="Id folio" />
                    </div>
                    <div class="small-12 large-6 columns" style="padding-left: 0;">
                        <a id=<?=$SECCION."-btnSearchContractPeople";?> class="btn btn-primary btn-Search">
                            <div class="label">Search</div>
                            <img src="<?php echo base_url().IMG; ?>common/BUSCAR.png" />
                        </a>
                        <a id=<?=$SECCION."-btnCleanSearchContractPeople";?> class="btn btn-primary spanSelect">
                            <div class="label">Clean</div>
                            <img src="<?php echo base_url().IMG; ?>common/BORRAR2.png" />
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="large-12 columns table-section2" id=<?=$SECCION."-divTableContractPeople";?>>
                <table id=<?=$SECCION."-tableContractPeople";?> width="100%" class="cell-border">
                    <thead>
                        <tr>
                            <th class="cellGeneral">Contract No.</th>
                            <th class="cellSmall">Contract Id</th>
                            <th class="cellMedium">First occ year</th>
                            <th class="cellMedium">Floor plan</th>
                            <th class="cellMedium">Season</th>
                            <th class="cellMedium">Frequency</th>
                            <th class="cellBig">Sale date</th>
                            <th class="cellSmall">Intv</th>
                            <th class="cellGeneral">Unit</th>
                            <th class="cellMedium">CSF balance</th>
                            <th class="cellMedium">Loan bal</th>
                            <th class="cellMedium">Status</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div id=<?=$SECCION."-tab-PEmpleados";?> class="large-12 columns tab-modal">
        <!-- Datos del contacto -->
        <div class="row" id=<?=$SECCION."-alertValPeopleEmployee";?> style="display:none;">
            <div class="small-12 columns">
                <div class="callout alert">
                    Please complete fields in red
                </div>
            </div>
        </div>
        <div class="row tab-modal-top" id=<?=$SECCION."-containerPeopleEmployee";?>>
            <div class="small-10 large-centered columns">
                <!-- Código del colaborador:-->
                <div class="row">
                    <div class="small-3 columns">
                        <label id=<?=$SECCION."-alertCodeCollaborator";?> for="textCodeCollaborator" class="text-left">Employee code</label>
                    </div>
                    <div class="small-9 columns">
                        <input type="text" class="round general" id=<?=$SECCION."-textCodeCollaborator";?>>
                    </div>
                </div>
                <div class="row">
                    <!-- Iniciales-->
                    <div class="small-12 large-6 columns" style="float:right">
                        <label id=<?=$SECCION."-alertInitials";?> for="textInitials" class="text-left">Initials</label>
                        <input type="text" id=<?=$SECCION."-textInitials";?> class="round general">
                    </div>
                    <!-- Código numérico -->
                    <div class="small-12 large-6 columns">
                        <label for="textCodeNumber" id=<?=$SECCION."-alertCodeNumber";?> class="text-left">Numeric code</label>
                        <input type="number" id=<?=$SECCION."-textCodeNumber";?>  class="round general">
                    </div>
                </div>
                <!-- tipo de vendedor -->
                <div class="row" style="margin-bottom:10px;">
                    <div class="small-3 columns">
                        <label id=<?=$SECCION."-alertTypeSeller";?>  for="textTypeSeller" class="text-left">Payroll account</label>
                    </div>
                    <div class="small-9 columns">
                        <div class="caja">
                            <select id=<?=$SECCION."-textTypeSeller";?> class="input-group-field round">
                                <option value="0" code="0">Select a type of seller</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="rdoField">
                    <input type="checkbox" class="EmployeePeople" value="active" id=<?=$SECCION."-checkPeopleEmployee";?> />
                    <label for="checkPeopleEmployee">Active</label>
                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" value="0" id=<?=$SECCION."-idPeople";?> />