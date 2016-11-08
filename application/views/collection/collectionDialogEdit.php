<div class="contentModalHeader">
<!-- tabs de los modales -->
<div class="tabsModal">
	<ul class="tabs" id="tabsCollection" data-tabs>
		<li class="tabs-title active" attr-screen="tab-CollGeneral" >
			<a>General</a>
		</li>
		<li class="tabs-title" attr-screen="tab-CollAccounts">
			<a>Accounts</a>
		</li>
	</ul>
</div>
</div>
<!-- contenido del modal -->
<div class="contentModal" id="ContenidoModalContractEdit">
	<div id="tab-CollGeneral" class="large-12 columns tab-modal" style="display:inline-block;">
		<fieldset class="fieldset">
			<legend class="btnCollapseField"  attr-screen="contResColl">
				<img class="imgCollapseFieldset" src="<?php echo base_url().IMG; ?>common/iconCollapseDown.png"/>
				Information about the contract o reservation
			</legend>
			<?php
				$this->load->view('collection/collectionRes');
			?>
		</fieldset>
		<fieldset class="fieldset">
			<legend class="btnCollapseField"  attr-screen="contPeopleColl">
				<img class="imgCollapseFieldset" src="<?php echo base_url().IMG; ?>common/iconCollapseDown.png"/>
				Personal Information
			</legend>
			<?php
				$this->load->view('collection/collectionPeople');
			?>
		</fieldset>
			
	</div>

	<!-- tabs cuentas -->
	<div id="tab-CollAccounts" class="large-12 columns tab-modal" style="display:none;">
		
		
	</div>
</div>
