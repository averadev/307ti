<div class="large-12 columns">
    <div class="box">
        <div class="box-header pr-color">
                <div class="pull-right box-tools">
                    <span class="box-btn" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </span>
                </div>
                <h3 class="box-title">
                    <span>Add Unidades</span>
                </h3>
                <div class="pull-left box-tools">
                    <span data-widget="newContrat" id="newContract">
                        <span>( New )</span>
                    </span>
                </div>
        </div>
        <div class="box-body">
                <!-- Property-->
                <div class="row">
                    <div class="small-3 columns">
                        <label for="property" class="text-left">Property</label>
                    </div>
                    <div class="small-9 columns">
						<div class="caja" >
							<select type="text" id="property" name="property" class="input-group-field round" required></select>
						</div>
                    </div>
                </div>
                <!-- Unit Type-->
                <div class="row">
                    <div class="small-3 columns">
                        <label for="unitType" class="text-left">Unit Type</label>
                    </div>
                    <div class="small-9 columns">
						<div class="caja" >
                        <select type="text" id="unitType" name="unitType" class="input-group-field round" required></select>
						</div>
                    </div>
                </div>
                <!-- Frequency-->
                <div class="row">
                    <div class="small-3 columns">
                        <label for="frequency" class="text-left">Frequency</label>
                    </div>
                    <div class="small-9 columns">
						<div class="caja" >
                        <select type="text" id="frequency" name="frequency" class="input-group-field round" required></select>
						</div>
				   </div>
                </div>
                <!-- Season-->
                <div class="row">
                    <div class="small-3 columns">
                        <label for="season" class="text-left">Season</label>
                    </div>
                    <div class="small-9 columns">
						<div class="caja" >
                        <select type="text" id="season" name="season" class="input-group-field round" required></select>
						</div>
					</div>
                </div>
                <!-- interval-->
                <div class="row">
                    <div class="small-3 columns">
                        <label for="interval" class="text-left">Interval</label>
                    </div>
                    <div class="small-9 columns">
						<div class="caja" >
                        <select type="text" id="interval" name="interval" class="input-group-field round" required>
                            <option value="0">Elige una opcion</option>
                             <option value="1">1</option>
                             <option value="2">2</option>
                             <option value="3">3</option>
                             <option value="4">4</option>
                             <option value="5">5</option>
                             <option value="6">6</option>
                             <option value="7">7</option>
                             <option value="8">8</option>
                             <option value="9">9</option>
                             <option value="10">10</option>
                             <option value="11">11</option>
                             <option value="12">12</option>
                             <option value="13">13</option>
                             <option value="14">14</option>
                             <option value="15">15</option>
                             <option value="16">16</option>
                             <option value="17">17</option>
                             <option value="18">18</option>
                             <option value="19">19</option>
                             <option value="20">20</option>
                             <option value="21">21</option>
                             <option value="22">22</option>
                             <option value="23">23</option>
                             <option value="24">24</option>
                             <option value="25">25</option>
                             <option value="26">26</option>
                             <option value="27">27</option>
                             <option value="28">28</option>
                             <option value="29">29</option>
                             <option value="30">30</option>
                             <option value="31">31</option>
                             <option value="32">32</option>
                             <option value="33">33</option>
                             <option value="34">34</option>
                             <option value="35">35</option>
                             <option value="36">36</option>
                             <option value="37">37</option>
                             <option value="38">38</option>
                             <option value="39">39</option>
                             <option value="40">40</option>
                             <option value="41">41</option>
                             <option value="41">41</option>
                             <option value="42">42</option>
                             <option value="43">43</option>
                             <option value="44">44</option>
                             <option value="45">45</option>
                             <option value="46">46</option>
                             <option value="47">47</option>
                             <option value="48">48</option>
                             <option value="49">49</option>
                             <option value="50">50</option>
                             <option value="51">51</option>
                             <option value="52">52</option>
                        </select>
						</div>
				   </div>
                </div>
            <div class="row">
                <div class="large-12 columns">
					<a id="btngetUnidades" class="btn btn-primary btn-right">
						<div class="label">Buscar</div>
						<img src="<?php echo base_url().IMG; ?>common/BUSCAR.png"/>
					</a>
					<!--<a  id="btngetUnidades" href="#" class="button postfix"><i class="fa fa-search"></i></a>-->
                </div>
            </div>
        </div>
    </div>
</div>


<div class="large-12 columns">
    <div class="box">
        <div class="box-header pr-color">

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
