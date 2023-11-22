  {{-- General Liabilities Tab --}}
  <div class="tab-pane active" id="general-liability-1" role="tabpanel">
      <div class="row mb-3">
          <div class="col-8">
              <div class="row">
                  <div class="col-2">
                      <label>Class Code</label>
                  </div>
                  <div class="col-10">
                      <select name="" id="generalLiabilitiesClassCodeDropdown" class="form-select">
                          @foreach ($sortedClassCodeLeads as $classCodeLead)
                              <option value="{{ $classCodeLead->id }}">{{ $classCodeLead->name }}</option>
                          @endforeach
                      </select>
                  </div>
              </div>
          </div>
          <div class="col-4">
              <div class="input-group">
                  <span class="input-group-text">%</span>
                  <input class="form-control classCodePercentage" type="number" value="10"
                      id="classcodePercentage">
              </div>
          </div>
      </div>

      <div id="additionalInput"></div>

      <div class="row mb-3">
          <div>
              <label>Business Description</label>
              <textarea required class="form-control" id="businessDescription" rows="5"></textarea>
          </div>
      </div>

      <div class="row mb-3">
          <label for="">Material Cost</label>
          <div class="col-6">
              <input class="form-control input-mask text-left" id="materialCost"
                  onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
          </div>
      </div>

      <div class="row mb-3">
          <div class="col-6">
              <label class="form-label">Residential</label>
              <input id="residential" type="text" value="50" name="residential">
          </div>
          <div class="col-6">
              <label class="form-label">Commercial</label>
              <input id="commercial" type="text" value="50" name="commercial">
          </div>
      </div>

      <div class="row mb-3">

          <div class="col-6">
              <label class="form-label">New Contruction</label>
              <input id="newConstruction" type="text" value="50" name="newConstruction">
          </div>

          <div class="col-6">
              <label class="form-label">Repair/Remodel</label>
              <input id="repair" type="text" value="50" name="repair">
          </div>

      </div>
      <div class="row mb-3">
          <div class="col-6">
              <label class="form-label">Multiple State Work</label>
              <div class="square-switch">
                  <input type="checkbox" id="multipleStateWork" switch="info" />
                  <label for="multipleStateWork" data-on-label="Yes" data-off-label="No"></label>
              </div>
          </div>

          <div class="col-6">
              <label class="form-label">Self Performing Roofing</label>
              <div class="square-switch">
                  <input type="checkbox" id="roofing" switch="info" />
                  <label for="roofing" data-on-label="Yes" data-off-label="No"></label>
              </div>
          </div>
      </div>

      <div class="row mb-3">

          <div class="col-6">
              <label class="form-label">Concrete Foundation Work</label>
              <div class="square-switch">
                  <input type="checkbox" id="concreteFoundation" switch="info" />
                  <label for="concreteFoundation" data-on-label="Yes" data-off-label="No"></label>
              </div>
          </div>

          <div class="col-6">
              <label class="form-label">Do you Perform Tract work?</label>
              <div class="square-switch">
                  <input type="checkbox" id="trackWork" switch="info" />
                  <label for="trackWork" data-on-label="Yes" data-off-label="No"></label>
              </div>
          </div>

      </div>

      <div class="row mb-3">

          <div class="col-6">
              <label class="form-label">Do you do any work for condominium</label>
              <div class="square-switch">
                  <input type="checkbox" id="condoTownHouse" switch="info" />
                  <label for="condoTownHouse" data-on-label="Yes" data-off-label="No"></label>
              </div>
          </div>

          <div class="col-6">
              <label class="form-label">Will you perform any new remodeling work in multi-dwelling residences?</label>
              <div class="square-switch">
                  <input type="checkbox" id="square-switch3" switch="info" />
                  <label for="square-switch3" data-on-label="Yes" data-off-label="No"></label>
              </div>
          </div>

      </div>

      <div class="row">
          <label for="form-label">
              <h6>Would you perform or subcontract work involving:</h6>
          </label>
      </div>

      <div class="row">

          <div class="col-3">
              <label class="form-label">Blasting Operation</label>
          </div>
          <div class="col-3">
              <label class="form-label">Hazardous Waste</label>
          </div>

          <div class="col-3">
              <label class="form-label">Asbestos Mold</label>
          </div>

          <div class="col-3">
              <label class="form-label">Exceeding 3 stories in height</label>
          </div>

      </div>


      <div class="row mb-3">

          <div class="col-3">
              <div class="square-switch">
                  <input type="checkbox" id="blastingOperation" switch="info" />
                  <label for="blastingOperation" data-on-label="Yes" data-off-label="No"></label>
              </div>
          </div>

          <div class="col-3">
              <div class="square-switch">
                  <input type="checkbox" id="hazardousWaste" switch="info" />
                  <label for="hazardousWaste" data-on-label="Yes" data-off-label="No"></label>
              </div>
          </div>

          <div class="col-3">
              <div class="square-switch">
                  <input type="checkbox" id="asbestosMold" switch="info" />
                  <label for="asbestosMold" data-on-label="Yes" data-off-label="No"></label>
              </div>
          </div>

          <div class="col-3">
              <div class="square-switch">
                  <input type="checkbox" id="exceedingHeight" switch="info" />
                  <label for="exceedingHeight" data-on-label="Yes" data-off-label="No"></label>
              </div>
          </div>

      </div>

      <div class="row">
          <div class="col-6">
              <label class="form-label">Any recreational facilities</label>
          </div>
      </div>

      <div class="row mb-3">
          <div class="col-6">
              <select name="" id="recreationalFacilities" multiple="multiple" class="form-select select2">
                  @foreach ($recreationalFacilities as $recreationalFacility)
                      <option value="{{ $recreationalFacility->id }}">{{ $recreationalFacility->name }}</option>
                  @endforeach
              </select>
          </div>
      </div>

      <div class="row">
          <div class="col-6">
              <label for="#busEntity">Business Entity</label>
          </div>
      </div>

      <div class="row mb-3">
          <div class="col-12">
              <select name="busEntity" id="busEntity" class="form-select">
                  <option value=""> </option>
                  <option value="Corporation">Corporation</option>
                  <option value="Individual/Sole Proprietor">Individual/Sole Proprietor</option>
                  <option value="Limited Liability Corp(LLC)">Limited Liability Company(LLC)</option>
                  <option value="Partnership">Partnership</option>
                  <option value="corp">S-corp</option>
              </select>
          </div>
      </div>

      <div class="row">
          <div class="col-6">
              <label for="#yearsInBusiness" class="form-label">Years in Business</label>
          </div>
          <div class="col-6">
              <label for="#yearsInProfession" class="form-label">Years in Profession</label>
          </div>
      </div>

      <div class="row mb-3">
          <div class="col-6">
              <input class="form-control" type="number" value="1" id="yearsInBusiness">
          </div>
          <div class="col-6">
              <input class="form-control" type="number" value="1" id="yearsInProfession">
          </div>
      </div>

      <div class="row mt-2">
          <div class="col-6">
              <label class="form-label">Largest Project</label>
          </div>
          <div class="col-6">
              <label class="form-label">Amount</label>
          </div>
      </div>

      <div class="row mb-3">
          <div class="col-6">
              <textarea name="largestProject" id="largestProject" rows="5" class="form-control"></textarea>
          </div>
          <div class="col-6">
              <input class="form-control input-mask text-left" id="largestProjectAmount"
                  onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
          </div>
      </div>

      <div class="row">
          <div class="col-6">
              <label class="form-label">Contact License</label>
          </div>
          <div class="col-6">
              <label class="form-label">Name/Company Name</label>
          </div>
      </div>

      <div class="row mb-3">
          <div class="col-6">
              <input class="form-control" type="text" id="contactLicense" placeholder="Largest Project">
          </div>
          <div class="col-6">
              <input class="form-control" type="text" id="companyNameUnderLicense" placeholder="Largest Project">
          </div>
      </div>

      <div class="row">
          <div class="col-6">
              <label for="" class="form-label">Have Losses</label>
          </div>
          <div class="col-6">
              <label for="" class="form-label">Is your office in your Home</label>
          </div>
      </div>

      <div class="row mb-3">

          <div class="col-6">
              <div class="square-switch">
                  <input type="checkbox" id="haveLosses" switch="info" />
                  <label for="haveLosses" data-on-label="Yes" data-off-label="No"></label>
              </div>
          </div>

          <div class="col-6">
              <div class="square-switch">
                  <input type="checkbox" id="homeOffice" switch="info" />
                  <label for="homeOffice" data-on-label="Yes" data-off-label="No"></label>
              </div>
          </div>

      </div>

      <div class="row mb-3">
          <div class="col-6">
              <label for="">Expiration of GL:</label>
              <input class="form-control" type="date" value="2011-08-19T13:45:00"
                  id="generalLiabilitiesExpirationInput">
          </div>
          <div class="col-6">
              <label for="">Prior Carrier</label>
              <input class="form-control" type="text" id="generalLiabilitiesPriorCarrierInput"
                  placeholder="Prior Carrier">
          </div>
      </div>

      <div class="row">
          <div class="col-6">
              <label for="" class="form-label">Limit</label>
          </div>
          <div class="col-6">
              <label for="" class="form-label">Medical</label>
          </div>
      </div>

      <div class="row mb-3">
          <div class="col-6">
              <select name="limitDropdown" id="limitDropdown" class="form-select">
                  <option value="1M/1M/1M">1M/1M/1M</option>
                  <option value="1M/2M/1M">1M/2M/1M</option>
                  <option value="1M/2M/2M">1M/2M/2M</option>
              </select>
          </div>
          <div class="col-6">
              <select name="medicalLimitDropdown" id="medicalLimitDropdown" class="form-select">
                  <option value="5000">$5,000</option>
                  <option value="10000">$10,000</option>
              </select>
          </div>
      </div>

      <div class="row">
          <div class="col-6">
              <label for="" class="form-label">Fire Damage</label>
          </div>
          <div class="col-6">
              <label for="" class="form-label">Deductible</label>
          </div>
      </div>

      <div class="row mb-3">
          <div class="col-6">
              <select name="fireDamageDropdown" id="fireDamageDropdown" class="form-select">
                  <option value="50000">$50,000</option>
                  <option value="100000">$100,000</option>>
              </select>
          </div>
          <div class="col-6">
              <select name="deductibleDropdown" id="deductibleDropdown" class="form-select">
                  <option value="0">0</option>
                  <option value="250">$250</option>
                  <option value="500">$500</option>
                  <option value="1000">$1000</option>
                  <option value="2500">$2500</option>
                  <option value="5000">$5000</option>
                  <option value="10000">$10000</option>
              </select>
          </div>
      </div>

      <div class="row mt-2">
          <div class="col-6">
              <label for="" class="form-label">Callback Date and Time</label>
          </div>
          <div class="col-6">
              <label for="" class="form-label">Cross Sale</label>
          </div>
      </div>

      <div class="row mb-3">
          <div class="col-6">
              <input class="form-control" type="datetime-local" value="2011-08-19T13:45:00"
                  id="generalLiabilitiesCallback">
          </div>
          <div class="col-6">
              <select name="crossSaleDropdown" id="crossSaleDropdown" class="form-select">
                  <option value=""></option>
                  <option value="Workers Comp">Workers Comp</option>
                  <option value="Commercial Auto">Commercial Auto</option>
                  <option value="Excess Liability">Excess Liability</option>
                  <option value="Tools and Equipment">Tools and Equipment</option>
                  <option value="Builders Risk">Builders Risk</option>
                  <option value="BOP">BOP</option>
              </select>
          </div>
      </div>

      <div class="row">
          <label for="" class="form-label">remarks</label>
      </div>

      <div class="row">
          <div class="col-12">
              <form method="post">
                  <textarea name="" id="remarks" rows="5" class="form-control"></textarea>
              </form>
          </div>
      </div>

      <div class="modal fade bs-example-modal-lg" id="haveLossModal" tabindex="-1" aria-labelledby="haveLossModal"
          aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
              <div class="modal-content">

                  <div class="modal-header">
                      <h5 class="modal-title" id="haveLossModalLabel">Have Losses Questionare</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>

                  <div class="modal-body">

                      <div class="row mb-3">
                          <div class="col-12">
                              <select name="" id="dataOptionDropdown" class="form-select">
                                  <option value="1">MM/YEAR</option>
                                  <option value="2">DD/MM/YEAR</option>
                              </select>
                          </div>
                      </div>

                      <div class="row">

                          <div class="col-6">
                              <label for="" class="form-label">Number of Year</label>
                          </div>

                          <div class="col-6">
                              <label for="" class="form-label">Amount of Claims</label>
                          </div>

                      </div>

                      <div class="row">
                          <div class="col-6">
                              <input class="form-control" type="date" value="2011-08-19" id="monthDayYear"
                                  hidden>
                              <input class="form-control" type="month" value="2020-03" id="monthDateYear" hidden>
                              <input type="hidden" value=1>
                          </div>
                          <div class="col-6">
                              <input class="form-control input-mask text-left" id="amountOfClaims"
                                  onkeypress="return event.charCode >= 48 && event.charCode <= 57"
                                  data-inputmask="'alias': 'numeric', 'groupSeparator': ',', 'digits': 2, 'digitsOptional': false, 'prefix': '$ ', 'placeholder': '0'">
                          </div>
                      </div>

                  </div>

                  <div class="modal-footer">
                      <button type="button" class="btn btn-primary"
                          id="saveHaveLossGeneralLiabilities">Submit</button>
                  </div>

              </div>
          </div>
      </div>

      @include('leads.apptaker_leads.classcode-questionare')

      {{-- start of subcontract modal --}}
      <div class="modal fade bs-example-modal-lg" id="subcontractModal" tabindex="-1"
          aria-labelledby="subcontractModal" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="subcontractModalLabel">Subcontractor</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <form action="subcontractModalForm">
                          @csrf
                          <div class="row">

                              <div class="col-6">
                                  <label class="form-label">Blasting Operation</label>
                              </div>

                              <div class="col-6">
                                  <label class="form-label">Hazardous Waste</label>
                              </div>

                          </div>

                          <div class="row">
                              <div class="col-6">
                                  <div class="square-switch">
                                      <input type="checkbox" id="blastingOperation" switch="info" />
                                      <label for="blastingOperation" data-on-label="Yes" data-off-label="No"></label>
                                  </div>
                              </div>
                              <div class="col-6">
                                  <div class="square-switch">
                                      <input type="checkbox" id="hazardousWaste" switch="info" />
                                      <label for="hazardousWaste" data-on-label="Yes" data-off-label="No"></label>
                                  </div>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-6">
                                  <label class="form-label">Asbetos Mold</label>
                              </div>
                              <div class="col-6">
                                  <label class="form-label">Any recreational facilities: hospitals, churches, school,
                                      playgrounds</label>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-6">
                                  <div class="square-switch">
                                      <input type="checkbox" id="asbestosMold" switch="info" />
                                      <label for="asbestosMold" data-on-label="Yes" data-off-label="No"></label>
                                  </div>
                              </div>
                              <div class="col-6">
                                  <div class="square-switch">
                                      <input type="checkbox" id="recreationalFacility" switch="info" />
                                      <label for="recreationalFacility" data-on-label="Yes"
                                          data-off-label="No"></label>
                                  </div>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-6">
                                  <label class="form-label">Any work exceeding 3 stories in height</label>
                              </div>
                          </div>

                          <div class="row">
                              <div class="col-6">
                                  <div class="square-switch">
                                      <input type="checkbox" id="exceedingHeight" switch="info" />
                                      <label for="exceedingHeight" data-on-label="Yes" data-off-label="No"></label>
                                  </div>
                              </div>
                          </div>

                      </form>
                  </div>
              </div>
          </div>
      </div>
      {{-- End of subcontract modal --}}

      {{-- start of modal for adding multiple statework --}}
      <div class="modal fade bs-example-modal-lg" id="dataModal" tabindex="-1" aria-labelledby="dataModal"
          aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
              <div class="modal-content">
                  <div class="modal-header">
                      <h5 class="modal-title" id="dataModalLabel">Mutiple State</h5>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                      <form id="dataModalForm">
                          @csrf
                          <div class="mb-3">
                              <div class="form-group">
                                  <table class="table table-bordered" id="dynamicAddRemove">
                                      <tr>
                                          <th>States</th>
                                          <th>Percentage</th>
                                          <th>Action</th>
                                      </tr>
                                      @php
                                          $cachedData = Cache::get('multi_state');
                                      @endphp

                                      @if ($cachedData)
                                          @foreach (array_combine(array_keys($cachedData['statesDropdown']), array_keys($cachedData['statePercentage'])) as $index)
                                              <tr>

                                                  <td>
                                                      <select name="statesDropdown[{{ $index }}][state]"
                                                          id="statesDropdown" class="form-control">
                                                          <option value="">Select a timezone</option>
                                                          <option value="">ALL</option>
                                                          @foreach ($states as $state)
                                                              <option value="{{ $state }}"
                                                                  @if ($cachedData['statesDropdown'][$index]['state'] === $state) selected @endif>
                                                                  {{ $state }}</option>
                                                          @endforeach
                                                      </select>
                                                  </td>


                                                  <td>
                                                      <div class="input-group">
                                                          <input class="form-control percentageInput" type="number"
                                                              value="{{ $cachedData['statePercentage'][$index]['percentage'] }}"
                                                              id="stateWorkPercentage"
                                                              name="statePercentage[{{ $index }}][percentage]">
                                                          <div class="input-group-append">
                                                              <span class="input-group-text">%</span>
                                                          </div>
                                                      </div>
                                                  </td>

                                                  <td>
                                                      @if ($index == 0)
                                                          <button type="button" id="addRowButton"
                                                              class="btn btn-primary">Add Row</button>
                                                      @else
                                                          <button class="btn btn-danger multiStateRemoveButton"
                                                              id="multiStateRemoveButton">Remove</button>
                                                      @endif
                                                  </td>
                                              </tr>
                                          @endforeach
                                      @else
                                          <tr>
                                              <td> <select name="statesDropdown[0][state]" id="statesDropdown"
                                                      class="form-control">
                                                      <option value="">Select a timezone</option>
                                                      <option value="">ALL</option>
                                                      @foreach ($states as $state)
                                                          <option value="{{ $state }}">{{ $state }}
                                                          </option>
                                                      @endforeach
                                                  </select>
                                              </td>
                                              <td>
                                                  <div class="input-group">
                                                      <input class="form-control percentageInput" type="number"
                                                          value="42" id="stateWorkPercentage"
                                                          name="statePercentage[0][percentage]">
                                                      <div class="input-group-append">
                                                          <span class="input-group-text">%</span>
                                                      </div>
                                                  </div>
                                              </td>
                                              <td>
                                                  <button type="button" id="addRowButton"
                                                      class="btn btn-primary">Add Row</button>
                                              </td>
                                          </tr>

                                      @endif

                                  </table>
                              </div>
                          </div>
                          <input type="hidden" name="action" id="action" value="add">
                          <input type="hidden" name="hidden_id" id="hidden_id" />
                  </div>
                  <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <input type="submit" name="action_button" id="action_button" id='#stateWorkPercentage'
                          value="Submit" class="btn btn-primary">
                  </div>
                  </form>
              </div>
          </div>
      </div>
      {{-- End of adding multiple statework --}}

  </div>

  <script src="{{ asset('backend/assets/libs/tinymce/tinymce.min.js') }}"></script>
  <script src="{{ asset('backend/assets/js/pages/form-editor.init.js') }}"></script>
  <style>
      .tox-tinymce-aux {
          z-index: 9999 !important;
      }
  </style>

  <script>
      $(document).ready(function() {

          $('#residential, #commercial').TouchSpin({
              min: 0,
              max: 100,
              step: 1,
              decimals: 0,
              boostat: 5,
              maxboostedstep: 10,
              postfix: '%'
          });


          $('#newConstruction, #repair').TouchSpin({
              min: 0,
              max: 100,
              step: 1,
              decimals: 0,
              boostat: 5,
              maxboostedstep: 10,
              postfix: '%'
          });

          $('#saveHaveLossGeneralLiabilities').on('click', function() {
              console.log('liabilit have losses button');
          });


          $('#residential').on('change', function() {
              var value1 = parseInt($(this).val()) || 0;
              var value2 = 100 - value1;

              $('#commercial').val(value2);
          });

          $('#commercial').on('change', function() {
              var value2 = parseInt($(this).val()) || 0;
              var value1 = 100 - value2;

              $('#residential').val(value1);
          });

          $('#newConstruction').on('change', function() {
              var value1 = parseInt($(this).val()) || 0;
              var value2 = 100 - value1;

              $('#repair').val(value2);
          });


          $('#repair').on('change', function() {
              var value2 = parseInt($(this).val()) || 0;
              var value1 = 100 - value2;

              $('#newConstruction').val(value1);
          });

          $('#multipleStateWork').on('change', function() {
              if ($(this).is(':checked')) {
                  $('#dataModal').modal('show');
              } else {

              }
          });

          $('.multiStateRemoveButton').on('click', function() {
              $(this).closest('tr').remove();
          });

          $('#dataOptionDropdown').on('change', function() {
              if ($(this).val() == 1) {
                  $('#monthDateYear').removeAttr('hidden');
                  $('#monthDayYear').attr('hidden', true);
              }
              if ($(this).val() == 2) {
                  $('#monthDayYear').removeAttr('hidden');
                  $('#monthDateYear').attr('hidden', true);
              }
          });

          $('#subcontract').on('change', function() {
              if ($(this).is(':checked')) {
                  $('#subcontractModal').modal('show');
              } else {

              }
          });

          $('#haveLosses').on('change', function() {
              if ($(this).is(':checked')) {
                  $('#haveLossModal').modal('show');
              } else {

              }
          });

          function calculateSum() {
              var sum = 0;
              $(".classCodePercentage").each(function() {
                  sum += parseInt($(this).val(), 10);
              });
              return sum;
          }

          function addNewInput() {
              $('#additionalInput').append(`<div class="row mb-3">
                <div class="col-8">
                    <div class="row">
                        <div class="col-2">
                            <label>Class Code</label>
                            </div>
                            <div class="col-10">
                                <select name="" id="" class="form-select">
                                    @foreach ($sortedClassCodeLeads as $classCodeLead)
                                    <option value="{{ $classCodeLead->id }}">{{ $classCodeLead->name }}</option>
                                    @endforeach
                                    </select>
                                    </div></div></div>
                                    <div class="col-4">
                                        <div class="input-group"><span class="input-group-text">%</span><input class="form-control classCodePercentage" type="number" value="10" id="classcodePercentage">
                                        <button class="btn btn-danger remove-input" style="margin-left: 10px;">Remove</button>
                                    </div>
                     </div>
                </div>
                </div>`);
          }

          $(document).on('click', '.remove-input', function() {
              $(this).closest('.row').remove();
          });

          $(document).on('change', '.classCodePercentage', function() {
              console.log(calculateSum());
              if (calculateSum() < 100) {
                  addNewInput();
              } else {}
          });

          // $('#classcodePercentage').change(function(){
          //     var value = $(this).val();

          //     if(value != 100){
          //         console.log(value);
          //         $('#classCodeDiv').append(`


        //         `);
          //     }else {
          //         $('#classcodePercentage').remove();
          //     }

          //     var sum = paserInt($())
          // });

          var rowCounter = 1;
          var maxPercentage = 100;

          // Function to recalculate total percentage
          function recalculatePercentages() {
              var totalPercentage = 0;

              $('.percentageInput').each(function() {
                  var percentage = parseInt($(this).val()) || 0;
                  totalPercentage += percentage;
              });

              $('#totalPercentage').text(totalPercentage);
          }


          // Add Row button click event
          $('#addRowButton').on('click', function() {
              var totalPercentage = parseInt($('#totalPercentage').text()) || 0;
              var remainingPercentage = maxPercentage - totalPercentage;
              // if (remainingPercentage <= 0) {
              //     alert('Total percentage has reached 100%. Cannot add more rows.');
              //     return;
              // }

              var newRow = `
            <tr id="row${rowCounter}" class="dynamic-row">
                <td>
                    <select name="statesDropdown[${rowCounter}][state]" class="form-control statesDropdown">
                        <option value="">Select a state</option>
                        <option value="ALL">ALL</option>
                        @foreach ($states as $state)
                        <option value="{{ $state }}">{{ $state }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                  <div class="input-group">
                    <input class="form-control percentageInput" type="number" value="0" name="statePercentage[${rowCounter}][percentage]">
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                  </div>
               </td>
                <td>
                    <button class="btn btn-danger removeRowButton">Remove</button>
                </td>
            </tr>
         `;

              $('#dynamicAddRemove tbody').append(newRow);
              rowCounter++;

              recalculatePercentages();

          });


          //event for showing the multiple state work
          $('#dataModal').on('show.bs.modal', function() {
              // var storedData = localStorage.getItem('formData');
              // var formData = JSON.parse(storedData);
              // var propertyNames = Object.keys(formData);

              // var rowProperties = propertyNames.filter(function(propertyName) {
              //     return propertyName.startsWith('statesDropdown[') && propertyName.endsWith('][state]');
              // });

              var rowCount = rowCounter;
              var newRow = `
            <tr id="row${rowCounter}" class="dynamic-row">
                <td>
                    <select name="statesDropdown[${rowCounter}][state]" class="form-control statesDropdown">
                        <option value="">Select a state</option>
                        <option value="ALL">ALL</option>
                        @foreach ($states as $state)
                <option value="{{ $state }}">{{ $state }}</option>
                        @endforeach
                </select>
            </td>
            <td>
              <div class="input-group">
                <input class="form-control percentageInput" type="number" value="0" name="statePercentage[${rowCounter}][percentage]">
                        <div class="input-group-append">
                            <span class="input-group-text">%</span>
                        </div>
                  </div>
               </td>
                <td>
                    <button class="btn btn-danger removeRowButton">Remove</button>
                </td>
            </tr>
        `;

              // Remove Row button click event
              $(document).on('click', '.removeRowButton', function() {
                  $(this).closest('tr').remove();
                  recalculatePercentages();
              });



          });

      });



      $('#dataModalForm').submit(function(event) {
          var form = $(this);
          var formData = form.serialize();
          var percentageInputs = form.find('.percentageInput');
          var shouldSubmit = false;
          var totalPercentage = [];
          percentageInputs.each(function() {
              var percentageInput = $(this);
              var percentageValue = percentageInput.val();
              totalPercentage.push(percentageValue);
          });
          var sumPercentage = totalPercentage.reduce(function(a, b) {
              return parseInt(a) + parseInt(b);
          }, 0);


          if (sumPercentage == 100) {
              $.ajax({
                  url: "{{ route('mutli.state.work') }}",
                  headers: {
                      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                  },
                  dataType: "json",
                  method: "POST",
                  data: formData,
                  success: function(response) {
                      $('#dataModal').modal('hide');
                  },
                  error: function(xhr, status, error) {
                      console.log('Error submitting form:', error);
                  }
              });
          } else {
              alert('Total percentage must be 100%');
          }

      });

      $(document).on('change', '#generalLiabilitiesClassCodeDropdown', function(event) {
          event.preventDefault();
          var selectedClassCode = $(this).val();
          if (selectedClassCode == 210) {
              $('#carpentryWorkingModal').modal('show');
          }
          if (selectedClassCode == 164) {
              $('#cleaningOutsideBuildingModal').modal('show');
          }
          if (selectedClassCode == 189) {
              $('#concreteFoundationModal').modal('show');
          }
          if (selectedClassCode == 217) {
              $('#executiveSupervisorModal').modal('show');
          }
          if (selectedClassCode == 18) {
              $('#debrisRemovalModal').modal('show');
          }
          if (selectedClassCode == 223) {
              $('#assembledMillworkInstallationModal').modal('show');
          }
          if (selectedClassCode == 226) {
              $('#electricalWorkModal').modal('show');
          }
          if (selectedClassCode == 227) {
              $('#excavationNocModal').modal('show');
          }
          if (selectedClassCode == 31) {
              $('#fenceErectionContractorModal').modal('show');
          }
          if (selectedClassCode == 112) {
              $('#glazingContractorModal').modal('show');
          }
          if (selectedClassCode == 36) {
              $('#gradingLandModal').modal('show');
          }
          if (selectedClassCode == 114) {
              $('#handyManModal').modal('show');
          }
          if (selectedClassCode == 115) {
              $('#hvacModal').modal('show');
          }
          if (selectedClassCode == 17) {
              $('#janitorialServicesModal').modal('show');
          }
          if (selectedClassCode == 51) {
              $('masonryContractorModal').modal('show');
          }
          if (selectedClassCode == 245) {
              $('#paintingExteriorModal').modal('show');
          }
          if (selectedClassCode == 246) {
              $('#paintingInteriorModal').modal('show');
          }
          if (selectedClassCode == 196) {
              $('#plasteringModal').modal('show');
          }
          if (selectedClassCode == 191) {
              $('#plumbingResidentiallModal').modal('show');
          }
          if (selectedClassCode == 61) {
              $('#plumbingCommercialModal').modal('show');
          }
          if (selectedClassCode == 252) {
              $('#roofingNewCommercialModal').modal('show');
          }
          if (selectedClassCode == 253) {
              $('#roofingNewResidentialModal').modal('show');
          }
          if (selectedClassCode == 254) {
              $('#roofingRepairCommercialModal').modal('show');
          }
          if (selectedClassCode == 255) {
              $('#roofingRepairResidentialModal').modal('show');
          }
          if (selectedClassCode == 132) {
              $('#sidingDeckingInstallationModal').modal('show');
          }
          if (selectedClassCode == 119) {
              $('#landscapingContractorsModal').modal('show');
          }

      });
  </script>
  {{-- End General Liabilities Tab --}}
