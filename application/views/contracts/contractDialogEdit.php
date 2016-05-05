<div class="row collapse headerGeneral" >
	<div class="small-12 medium-12 large-12 columns headerModalBtn"  > 
		<a id="btn" class="secondary hollow button tiny"><i class="fa fa-columns fa-lg">&nbsp;&nbsp;Front Page</i></a>
		<a id="btn" class="secondary hollow button tiny"><i class="fa fa-money  fa-lg">&nbsp;&nbsp;I will pay</i></a>
		<a id="btn" class="secondary hollow button tiny"><i class="fa fa-file-text-o fa-lg">&nbsp;&nbsp;Voucher</i></a>
		<a id="btn" class="secondary hollow button tiny"><i class="fa fa-list-alt  fa-lg">&nbsp;&nbsp;Data sheet</i></a>
		<a id="btn" class="secondary hollow button tiny"><i class="fa fa-credit-card fa-lg">&nbsp;&nbsp;Account status</i></a>
	</div>
</div>
<div class="row headerDescription headerGeneral">
	<div class="small-12 medium-12 large-8 columns"  >
		<label class="headerDescriptionTitle">[0000-0000] Nombre del contrato </label>
		<label class="headerGeneral" >Marlin 1 Planta 2 Rec, 10, 1 semana(s), Av. Roca </label>
		<label class="headerGeneral">Año: 2016</label>
	</div>
	<div class="small-12 medium-12 large-4 columns"  >
		<label class="headerGeneral">Estatus:<span>Pendiente de Imprimir</span></label>
		<label class="headerGeneral">Banderas:<span>0</span></label>
	</div>
</div>
<!-- tabs de los modales -->
<div class="tabsModal" id="tabsModalContrats">
	<ul class="tabs" id="tabsContrats" data-tabs>
		<li class="tabs-title active" attr-screen="tab-CGeneral" >
			<a>General</a>
		</li>
		<li class="tabs-title" attr-screen="tab-CAccounts">
			<a>Accounts</a>
		</li>
		<li class="tabs-title" attr-screen="tab-CVendors">
			<a>Vendors</a>
		</li>
		<li class="tabs-title" attr-screen="tab-CProvisions">
			<a>Provisions</a>
		</li>
		<li class="tabs-title" attr-screen="tab-COccupation">
			<a>Years of Occupation</a>
		</li>
		<li class="tabs-title" attr-screen="tab-CDocuments">
			<a>Documents</a>
		</li>
		<li class="tabs-title" attr-screen="tab-CNotes">
			<a>Notes</a>
		</li>
		<li class="tabs-title" attr-screen="tab-CFlags">
			<a>Flags</a>
		</li>
		<li class="tabs-title" attr-screen="tab-CFiles">
			<a>Files</a>
		</li>
	</ul>
</div>

<!-- contenido del modal -->
<div class="ModalContractEdit">
	
	<div id="tab-CGeneral" class="large-12 columns tab-modal" style="display:inline;">
		<!-- Error Message -->
		<div class="row" id="alertValidateContrato" style="display:none;">
			<div class="small-12 columns">
				<div data-alert class="alert-box alert " >
					Por favor rellene los campos Obligatorios(rojo)
				</div>
			</div>
		</div>
		<form id="editDataContract" data-abide='ajax'>
			<fieldset class="fieldset">
				<legend>
					Contract Data
				</legend>
				<div class="containerContract">
					<div class="row">
						<div class="small-12 columns">
							<a id="btnAddPeople" class="button tiny"><i class="fa fa-user-plus">&nbsp;&nbsp;Refinancing contract</i></a>
						</div>
						<table id="tablePeopleSelected" width="100%">
							<thead>
								<tr class="trColspan" >
									<th colspan="8" class="thColspan" >People</tr>
								</tr> 
								<tr>
									<th class="cellEdit" >ID</th>
									<th class="cellGeneral">Nombre</th>
									<th class="cellGeneral">Apellidos</th>
									<th class="cellGeneral" >Dirección</th>
									<th class="cellGeneral" >Persona Principal</th>
									<th class="cellGeneral" >Persona Secundaria</th>
									<th class="cellGeneral" >Beneficiario</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>23</td>
									<td>Faustino</td>
									<td>Loeza</td>
									<td>Cancun</td>
									<td><input type="radio" name="peopleContract" value="1"></td>
									<td><input type="radio" name="peopleContract" value="2"></td>
									<td><input type="radio" name="peopleContract" value="3"></td>
									<td><button type="button" class="alert button"><i class="fa fa-minus-circle fa-lg" aria-hidden="true"></i></button></td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
				<!-- Unidades -->
				<div class="containerContract" style="margin-top:10px">
				
                    <div class="row">
                        <table id="tableUnidades" width="100%">
                            <thead>
								<tr class="trColspan">
									<th colspan="8">Units</tr>
								</tr>
								<tr>
									<th class="cellEdit" >Code</th>
									<th class="cellGeneral">Description</th>
									<th class="cellGeneral">Precio</th>
									<th class="cellGeneral" ># de Semana</th>
									<th class="cellGeneral" >Primer año OCC</th>
									<th class="cellGeneral" >Ultimo año OCC</th>
									<th class="cellGeneral" >Frecuencia</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>sds5d5</td>
									<td>PArgo 1 3Rec</td>
									<td>$38,000.00</td>
									<td>#1</td>
									<td>2016</td>
									<td>2017</td>
									<td><input type="radio" name="people" value="3"></td>
									<td><button type="button" class="alert button"><i class="fa fa-minus-circle fa-lg" aria-hidden="true"></i></button></td>
								</tr>
                            </tbody>
                        </table>
                    </div>
                </div>
			</fieldset>
			
			<!-- Condiciones de venta -->
			<fieldset class="fieldset">
				<legend class="btnCollapseField"  attr-screen="editTermsOfSale" >
					<img class="imgCollapseFieldset" src="<?php echo base_url().IMG; ?>common/iconCollapseDown.png"/>
					Terms of sale
				</legend>
				<div class="row" id="editTermsOfSale" style="display:none;">
					<table class="tableAccountResult">
						<thead>
							<tr class="trColspan">
								<th colspan="4">Results</tr>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Price</td>
								<td>$000,000.00</td>
								<td>Number of weeks</td>
								<td>$000,000.00</td>
							</tr>
							<tr>
								<td>Reference pack</td>
								<td>$000,000.00</td>
								<td>Sale price</td>
								<td>$000,000.00</td>
							</tr>
							<tr>
								<td>Hitch</td>
								<td>$000,000.00</td>
								<td>Transferred amount</td>
								<td>$000,000.00</td>
							</tr>
							<tr>
								<td>Cost contract</td>
								<td>$000,000.00</td>
								<td>Hook amount transferred more</td>
								<td>$000,000.00</td>
							</tr>
							<tr>
								<td>Pack amount</td>
								<td>$000,000.00</td>
								<td>Balance to be financed</td>
								<td>$000,000.00</td>
							</tr>
						</tbody>
					</table>
				</div>
			</fieldset>
			
			<!-- Condiciones de financiamiento -->
			<fieldset class="fieldset">
				<legend class="btnCollapseField"  attr-screen="editTermsOfFinancing" >
					<img class="imgCollapseFieldset" src="<?php echo base_url().IMG; ?>common/iconCollapseDown.png"/>
					Terms of financing
				</legend>
				<div class="row" id="editTermsOfFinancing" style="display:none;">
					<table class="tableAccountResult">
						<thead>
							<tr class="trColspan">
								<th colspan="4">Results</tr>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>Balance to be Financed</td>
								<td>$000,000.00</td>
								<td>Type of funding</td>
								<td>$000,000.00</td>
							</tr>
							<tr>
								<td>Monthly payment</td>
								<td>$000,000.00</td>
								<td>Cost collection</td>
								<td>$000,000.00</td>
							</tr>
							<tr>
								<td>% Hitch</td>
								<td>$000,000.00</td>
								<td>Total funding</td>
								<td>$000,000.00</td>
							</tr>
							<tr>
								<td>Total monthly payment</td>
								<td>$000,000.00</td>
							</tr>
						</tbody>
					</table>
				</div>
			</fieldset>
			
			<!-- tour -->
			<fieldset class="fieldset">
				<legend class="btnCollapseField" attr-screen="editTourID" >
					<img class="imgCollapseFieldset" src="<?php echo base_url().IMG; ?>common/iconCollapseDown.png"/>
					Tour
				</legend>
				<div class="row" id="editTourID" style="display:none;">
					<div class="small-12 medium-8 large-6 columns">
						<!-- Tour ID-->
						<div class="row">
							<div class="small-3 columns">
								<label  for="TourID" class="text-left">Tour ID</label>
							</div>
							<div class="large-9 columns">
								<div class="row collapse">
									<div class="small-10 columns">
										<input value="0" readonly type="text" placeholder="ID" name="TourID" id="TourID" required>
									</div>
									<div class="small-2 columns">
										<a id="btnAddTourID" href="#" class="button postfix"><i class="fa fa-user-plus">&nbsp;&nbsp;Add</i></a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="small-12 medium-8 large-6 columns" style="text-align:right;"> 
						<a id="btn" class="button small"><i class="fa fa-save fa-lg">&nbsp;&nbsp;Guardar</i></a>
						<a id="btn" class="button small"><i class="fa fa-minus-circle fa-lg">&nbsp;&nbsp;Eliminar</i></a>
					</div>
				</div>				
			</fieldset>
		</form>
	</div>
	<!-- tabs cuentas -->
	<div id="tab-CAccounts" class="large-12 columns tab-modal" style="display:none;">
		<div class="tabsModal" id="tabsModalContrats">
			<ul class="tabs" id="tabsContratsAccounts"  data-tabs>
				<li class="tabs-title active" attr-screen="tab-CASales" >
					<a>Accounts</a>
				</li>
				<li class="tabs-title" attr-screen="tab-CAMaintenance">
					<a>Maintenance</a>
				</li>
				<li class="tabs-title" attr-screen="tab-CAMiscellaneous">
					<a>Miscellaneous</a>
				</li>
			</ul>
		</div>
		<!-- contenido del modal -->
		<div class="ModalContractAccounts">
			<!-- ventas--->
			<div id="tab-CASales" class="large-12 columns tab-modal" style="display:inline;">
				
				<fieldset class="fieldset">
					<div class="row" id="editTermsOfSale">
						<table class="tableAccountResult">
							<thead>
								<tr class="trColspan">
									<th colspan="4">Results</tr>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Folio Contract</td>
									<td>00000</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Balance</td>
									<td>$000,000.00</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Balance of Deposits</td>
									<td>$000,000.00</td>
									<td>Defeated Deposits</td>
									<td>$000,000.00</td>
								</tr>
								<tr>
									<td>Balance Sales</td>
									<td>$000,000.00</td>
									<td>Defeated Sales</td>
									<td>$000,000.00</td>
								</tr>
							</tbody>
						</table>
					</div>
				</fieldset>
				<fieldset class="fieldset">
					<div class="containerContract">
						<div class="row">
							<table id="tableSellerSelected" width="100%" style="min-height:250px;">
								<thead>
									<tr class="trColspan" >
										<th colspan="9" class="thColspan" >Seller</tr>
									</tr> 
									<tr>
										<th class="cellEdit" >Id</th>
										<th class="cellGeneral">Code</th>
										<th class="cellGeneral">Active</th>
										<th class="cellGeneral" >Type</th>
										<th class="cellGeneral" >Sign transaction</th>
										<th class="cellGeneral" >Concept Trxid</th>
										<th class="cellGeneral" >Date</th>
										<th class="cellGeneral" >Rode</th>
										<th class="cellGeneral" >Monto Bal</th>
									</tr>
								</thead>
								<tbody>
									<tr></tr>
								</tbody>
							</table>
						</div>
					</div>
				</fieldset>
			</div>
			<!-- mantenimiento --->
			<div id="tab-CAMaintenance" class="large-12 columns tab-modal" style="display:none;">
				<fieldset class="fieldset">
					<div class="row" id="editTermsOfSale">
						<table class="tableAccountResult">
							<thead>
								<tr class="trColspan">
									<th colspan="4">Results</tr>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Folio Contract</td>
									<td>00000</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Balance Maintenance</td>
									<td>$000,000.00</td>
									<td>Defeated Maintenance</td>
									<td>$000,000.00</td>
								</tr>
							</tbody>
						</table>
					</div>
				</fieldset>
				<fieldset class="fieldset">
					<div class="containerContract">
						<div class="row">
							<table id="tableSellerSelected" width="100%" style="min-height:250px;">
								<thead>
									<tr class="trColspan" >
										<th colspan="9" class="thColspan" >Maintenance accounts</tr>
									</tr> 
									<tr>
										<th class="cellEdit" >Id</th>
										<th class="cellGeneral">Code</th>
										<th class="cellGeneral">Active</th>
										<th class="cellGeneral" >Type</th>
										<th class="cellGeneral" >Sign transaction</th>
										<th class="cellGeneral" >Concept Trxid</th>
										<th class="cellGeneral" >Date</th>
										<th class="cellGeneral" >Rode</th>
										<th class="cellGeneral" >Monto Bal</th>
									</tr>
								</thead>
								<tbody>
									<tr></tr>
								</tbody>
							</table>
						</div>
					</div>
				</fieldset>
			</div>
			<!-- Misceláneos --->
			<div id="tab-CAMiscellaneous" class="large-12 columns tab-modal" style="display:none;">
				<fieldset class="fieldset">
					<div class="row" id="editTermsOfSale">
						<table class="tableAccountResult">
							<thead>
								<tr class="trColspan">
									<th colspan="4">Results</tr>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Folio Contract</td>
									<td>00000</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Miscellaneous balance</td>
									<td>$000,000.00</td>
									<td></td>
									<td></td>
								</tr>
								<tr>
									<td>Balance of Deposits</td>
									<td>$000,000.00</td>
									<td>Defeated Deposits</td>
									<td>$000,000.00</td>
								</tr>
								<tr>
									<td>Balance Sales</td>
									<td>$000,000.00</td>
									<td>Defeated Sales</td>
									<td>$000,000.00</td>
								</tr>
							</tbody>
						</table>
					</div>
				</fieldset>
				<fieldset class="fieldset">
					<div class="containerContract">
						<div class="row">
							<table id="tableSellerSelected" width="100%" style="min-height:250px;">
								<thead>
									<tr class="trColspan" >
										<th colspan="9" class="thColspan" >Miscellaneous accounts</tr>
									</tr> 
									<tr>
										<th class="cellEdit" >Id</th>
										<th class="cellGeneral">Code</th>
										<th class="cellGeneral">Active</th>
										<th class="cellGeneral" >Type</th>
										<th class="cellGeneral" >Sign transaction</th>
										<th class="cellGeneral" >Concept Trxid</th>
										<th class="cellGeneral" >Date</th>
										<th class="cellGeneral" >Rode</th>
										<th class="cellGeneral" >Monto Bal</th>
									</tr>
								</thead>
								<tbody>
									<tr></tr>
								</tbody>
							</table>
						</div>
					</div>
				</fieldset>
			</div>
		</div>
	</div>
	<!-- tabs vendedores -->
	<div id="tab-CVendors" class="large-12 columns tab-modal" style="display:none;">
		<form id="editDataContract" data-abide='ajax'>
			<fieldset class="fieldset">
				<div class="containerContract">
					<div class="row">
						<table id="tableSellerSelected" width="100%" style="min-height:250px;">
							<thead>
								<tr class="trColspan" >
									<th colspan="8" class="thColspan" >Seller</tr>
								</tr> 
								<tr>
									<th class="cellEdit" ></th>
									<th class="cellGeneral">Code</th>
									<th class="cellGeneral">Name</th>
									<th class="cellGeneral" >Role</th>
									<th class="cellGeneral" >Commission Amount</th>
									<th class="cellGeneral" >Comision Porcentaje</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr></tr>
							</tbody>
						</table>
					</div>
				</div>
			</fieldset>
			<div class="small-12 medium-12 large-12 columns" > 
				<a id="btn" class="button tiny"><i class="fa fa-user-plus fa-lg">&nbsp;&nbsp;New seller</i></a>
				<a id="btn" class="button tiny"><i class="fa fa-user-times fa-lg">&nbsp;&nbsp;Remove seller</i></a>
			</div>
		</form>
	</div>
	<!-- tabs vendedores -->
	<div id="tab-CProvisions" class="large-12 columns tab-modal" style="display:none;">
		<form id="editDataContract" data-abide='ajax'>
			<fieldset class="fieldset">
				
				<div class="containerContract">
					<div class="row">
						<table id="tableProvisionsSelected" width="100%" style="min-height:250px;">
							<thead>
								<tr class="trColspan" >
									<th colspan="8" class="thColspan" >Provisions</tr>
								</tr> 
								<tr>
									<th class="cellGeneral">Code</th>
									<th class="cellGeneral">Description</th>
									<th class="cellGeneral" >Precio</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr></tr>
							</tbody>
						</table>
					</div>
				</div>
			</fieldset>
			<div class="small-12 medium-12 large-12 columns" > 
				<a id="btn" class="button tiny"><i class="fa fa-plus-circle fa-lg">&nbsp;&nbsp;New Provision</i></a>
			</div>
		</form>
	</div>
	<!-- tabs años de ocupacion -->
	<div id="tab-COccupation" class="large-12 columns tab-modal" style="display:none;">
		<form id="editDataContract" data-abide='ajax'>
			<fieldset class="fieldset">
				<div class="containerContract">
					<div class="row">
						<table id="tableCOccupationSelected" width="100%" style="min-height:250px;">
							<thead>
								<tr class="trColspan" >
									<th colspan="8" class="thColspan" >Years of occupation</tr>
								</tr> 
								<tr>
									<th class="cellGeneral">Occupancy Type</th>
									<th class="cellGeneral">Occupation Year</th>
									<th class="cellGeneral">Week</th>
									<th></th>
								</tr>
							</thead>
							<tbody>
								<tr></tr>
							</tbody>
						</table>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
	<!-- tabs años de ocupacion -->
	<div id="tab-CDocuments" class="large-12 columns tab-modal" style="display:none;">
		<form id="editDataContract" data-abide='ajax'>
			<fieldset class="fieldset">
				<div class="containerContract">
					<div class="row">
						<table id="tableCDocumentsSelected" width="100%" style="min-height:250px;">
							<thead>
								<tr class="trColspan" >
									<th colspan="8" class="thColspan" >Years of occupation</tr>
								</tr> 
								<tr>
									<th class="cellEdit"></th>
									<th class="cellGeneral">Creation date</th>
									<th class="cellGeneral">Document type</th>
									<th class="cellGeneral">User</th>
									<th class="cellGeneral">Impreso</th>
								</tr>
							</thead>
							<tbody>
								<tr></tr>
							</tbody>
						</table>
					</div>
				</div>
			</fieldset>
		</form>
	</div>
	<!-- tabs notas -->
	<div id="tab-CNotes" class="large-12 columns tab-modal" style="display:none;">
		<form id="editDataContract" data-abide='ajax'>
			<fieldset class="fieldset">
				<div class="containerContract">
					<div class="row">
						<table id="tableCNotesSelected" width="100%" style="min-height:250px;">
							<thead>
								<tr class="trColspan" >
									<th colspan="8" class="thColspan" >Notes</tr>
								</tr> 
								<tr>
									<th class="cellEdit"></th>
									<th class="cellGeneral">Code</th>
									<th class="cellGeneral">Note type</th>
									<th class="cellGeneral">Note</th>
									<th class="cellGeneral">Creation date</th>
									<th class="cellGeneral">Created by</th>
									<th class="cellGeneral">Occupation year</th>
								</tr>
							</thead>
							<tbody>
								<tr></tr>
							</tbody>
						</table>
					</div>
				</div>
			</fieldset>
			<div class="small-12 medium-12 large-12 columns" > 
				<a id="btn" class="button tiny"><i class="fa fa-plus-circle fa-lg">&nbsp;&nbsp;New Note</i></a>
				<a id="btn" class="button tiny"><i class="fa fa-sticky-note-o fa-lg">&nbsp;&nbsp;See all notes</i></a>
			</div>
		</form>
	</div>
	<!-- Banderas -->
	<div id="tab-CFlags" class="large-12 columns tab-modal" style="display:none;">
		<form id="editDataContract" data-abide='ajax'>
			<fieldset class="fieldset">
				<div class="containerContract">
					<div class="row">
						<div class="small-12 medium-6 large-6 columns">
							<table id="tableCNotesListSelected" width="100%" style="min-height:250px;">
								<thead>
									<tr class="trColspan" >
										<th colspan="2" class="thColspan" >List of flags</tr>
									</tr> 
									<tr>
										<th class="cellGeneral">Code</th>
										<th class="cellGeneral">Descripción</th>
									</tr>
								</thead>
								<tbody>
									<tr></tr>
								</tbody>
							</table>
						</div>
						<div class="small-12 medium-6 large-6 columns">
							<table id="tableCNotesAssignedSelected" width="100%" style="min-height:250px;">
								<thead>
									<tr class="trColspan" >
										<th colspan="2" class="thColspan" >Assigned flags</tr>
									</tr> 
									<tr>
										<th class="cellGeneral">Code</th>
										<th class="cellGeneral">Descripción</th>
									</tr>
								</thead>
								<tbody>
									<tr></tr>
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</fieldset>
			<div class="small-12 medium-12 large-12 columns" > 
				<a id="btn" class="button tiny"><i class="fa fa-save fa-lg">&nbsp;&nbsp;Save</i></a>
				<a id="btn" class="button tiny"><i class="fa fa-refresh fa-lg">&nbsp;&nbsp;Next Status</i></a>
			</div>
		</form>
	</div>
	<!-- archivos -->
	<div id="tab-CFiles" class="large-12 columns tab-modal" style="display:none;">
		<form id="editDataContract" data-abide='ajax'>
			<fieldset class="fieldset">
				<div class="containerContract">
					<div class="row">
						<table id="tableCFilesSelected" width="100%" style="min-height:250px;">
							<thead>
								<tr class="trColspan" >
									<th colspan="8" class="thColspan" >Notes</tr>
								</tr> 
								<tr>
									<th class="cellGeneral">Id</th>
									<th class="cellGeneral">File</th>
									<th class="cellGeneral">Description</th>
									<th class="cellGeneral">User</th>
									<th class="cellGeneral">Date</th>
								</tr>
							</thead>
							<tbody>
								<tr></tr>
							</tbody>
						</table>
					</div>
				</div>
			</fieldset>
			<div class="small-12 medium-12 large-12 columns" > 
				<a id="btn" class="button tiny"><i class="fa fa-plus-circle fa-lg">&nbsp;&nbsp;New file</i></a>
			</div>
		</form>
	</div>
	
</div>
<script>
   /* $('#btnAddTourID').click(function(){
        ajaxHTML('dialog-tourID', 'tours/modal');
        showModals('dialog-tourID', cleanAddPeople);
    });
    $('#btnAddPeople').click(function(){
        $('#dialog-People').empty();
        ajaxHTML('dialog-People', 'people/');
        showModals('dialog-People', cleanAddPeople);
    });
    $('#btnAddUnidades').click(function(){
        ajaxHTML('dialog-Unidades', 'contract/modalUnidades');
        showModals('dialog-Unidades', cleanAddUnidades);
    });*/

</script>