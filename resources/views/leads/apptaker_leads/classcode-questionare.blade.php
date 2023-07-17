{{-- Modal for class code carpentry workinng --}}
<div class="modal fade bs-example-modal-lg" id="carpentryWorkingModal" tabindex="-1" aria-labelledby="haveLossModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-dark" id="carpentryWorkingModalLabel">Carpentry Woodworking Questionare</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-8">
                        <label class="form-label">Do you perform or install playground equipment</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="playGroundEquipmentManufactureInstall" switch="info"/>
                            <label for="playGroundEquipmentManufactureInstall" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#carpentryWorkingModalSubmitButton' value="Submit" class="btn btn-primary">
            </div>

        </div>
    </div>
</div>

{{-- Modal for class code cleaning outside building --}}
<div class="modal fade bs-example-modal-lg" id="cleaningOutsideBuildingModal" tabindex="-1" aria-labelledby="haveLossModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="cleaningOutsideBuildingModalLabel">Cleaning Outside the building </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row">
                    <div class="col-8">
                        <label class="form-label">Do you pressure greater than 3,000 PSI</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="highPressureUsage" switch="info"/>
                            <label for="highPressureUsage" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-8">
                        <label class="form-label">Do you perform window cleaning</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="performWindowCleaning" switch="info"/>
                            <label for="performWindowCleaning" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#cleaningOutsideBuildingModalSubmitButton' value="Submit" class="btn btn-primary">
            </div>
            
        </div>
    </div>
</div>

{{-- Modal for class code concrete foundation contractor --}}
<div class="modal fade bs-example-modal-lg" id="concreteFoundationModal" tabindex="-1" aria-labelledby="haveLossModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-dark" id="concreteFoundationModalLabel">Concrete Foundation Contractor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you install and repair on dikes, dams, roads and highways?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="concreteFoundationWork" switch="info"/>
                            <label for="concreteFoundationWork" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <textarea name="concreteFoundationDescription" id="concreteFoundationDescription" rows="5" hidden></textarea>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#concreteFoundationModalSubmitButton' value="Submit" class="btn btn-primary">
            </div>

        </div>
    </div>
</div>


{{-- Executive Supervisor --}}
<div class="modal fade bs-example-modal-lg" id="executiveSupervisorModal" tabindex="-1" aria-labelledby="haveLossModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-dark" id="executiveSupervisorModalLabel">Executive Supervisor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you provide daily supervision of jobsite labor??</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="executiveSupervisor" switch="info"/>
                            <label for="executiveSupervisor" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#executiveSupervisorModalSubmitButton' value="Submit" class="btn btn-primary">
            </div>

        </div>
    </div>
</div>

{{-- Modal for Debris Removal --}}
<div class="modal fade bs-example-modal-lg" id="debrisRemovalModal" tabindex="-1" aria-labelledby="haveLossModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-dark" id="debrisRemovalModalLabel">Debris Removal</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you perfrom any structural demolition work?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="debrisRemoval" switch="info"/>
                            <label for="debrisRemoval" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#debrisRemovalModalSubmitButton' value="Submit" class="btn btn-primary">
            </div>

        </div>
    </div>
</div>

{{-- Modal for DOOR, WINDOW, GARAGE DOORS, ASSEMBLED MILLWORK INSTALLATION (METAL) --}}
<div class="modal fade bs-example-modal-lg" id="assembledMillworkInstallationModal" tabindex="-1" aria-labelledby="haveLossModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-dark" id="assembledMillworkInstallationModalLabel">DOOR, WINDOW, GARAGE DOORS, ASSEMBLED MILLWORK INSTALLATION (METAL)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you instal security bars on doors or windows?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="assembledMillwork" switch="info"/>
                            <label for="assembledMillwork" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#assembledMillworkInstallationModalSumbitButton' value="Submit" class="btn btn-primary">
            </div>

        </div>
    </div>
</div>

{{-- Modal for ELECTRICAL WORK (WITHIN BUILDINGS) --}}
<div class="modal fade bs-example-modal-lg" id="electricalWorkModal" tabindex="-1" aria-labelledby="haveLossModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-dark" id="electricalWorkModalLabel">ELECTRICAL WORK (WITHIN BUILDINGS)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you install Electrical Machinery??</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="installElectricalMachinery" switch="info"/>
                            <label for="installElectricalMachinery" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-8">
                        <label for="" class="form-label">Do you install burglar or fire alarms, emergency systems work or generators?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="installBulgarFireAlarms" switch="info"/>
                            <label for="installBulgarFireAlarms" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#electricalWorkModalSubmitButton' value="Submit" class="btn btn-primary">
            </div>

        </div>
    </div>
</div>

{{-- Modal for Excavation NOC Modal --}}
<div class="modal fade bs-example-modal-lg" id="excavationNocModal" tabindex="-1" aria-labelledby="haveLossModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title text-dark" id="excavationNocModalLabel">Excavation NOC</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you perfrom work for Public street, road, highway, dams, landfills?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="performWorkForPublic" switch="info"/>
                            <label for="performWorkForPublic" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#excavationNocModalSubmitButton' value="Submit" class="btn btn-primary">
            </div>

        </div>
    </div>
</div>


{{-- Modal for FENCE ERECTION CONTRACTORS--}}
<div class="modal fade bs-example-modal-lg" id="fenceErectionContractorModal" tabindex="-1" aria-labelledby="fenceErectionContractorModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="fenceErectionContractorModalLabel">FENCE ERECTION CONTRACTORS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you provide electrically-charged fencing, Barbed wire fencing?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="provideElectricalCharged" switch="info"/>
                            <label for="provideElectricalCharged" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#fenceErectionContractorModalSubmitButton' value="Submit" class="btn btn-primary">
            </div>
        </div>
    </div>
</div>

{{-- Modal for FENCE ERECTION CONTRACTORS--}}
<div class="modal fade bs-example-modal-lg" id="fenceErectionContractorModal" tabindex="-1" aria-labelledby="fenceErectionContractorModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="fenceErectionContractorModalLabel">FENCE ERECTION CONTRACTORS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you provide electrically-charged fencing, Barbed wire fencing?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="provideElectricalCharged" switch="info"/>
                            <label for="provideElectricalCharged" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#fenceErectionContractorModalSubmitButton' value="Submit" class="btn btn-primary">
            </div>
        </div>
    </div>
</div>



{{-- Modal for Class Code Questionare--}}
<div class="modal fade bs-example-modal-lg" id="glazingContractorModal" tabindex="-1" aria-labelledby="glazingContractorModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="glazingContractorModalLabel">Glazing Contractor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you install bullet prof glass or perform auto work?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="installBulletProof" switch="info"/>
                            <label for="installBulletProof" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#glazingContractorModalSubmitButton' value="Submit" class="btn btn-primary">
            </div>
        </div>
    </div>
</div>

{{-- Modal for Class Code Questionare--}}
<div class="modal fade bs-example-modal-lg" id="gradingLandModal" tabindex="-1" aria-labelledby="glazingContractorModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="gradingLandModalLabel">Grading</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you perfrom work on Public street, road, bridge, highway or overpass work?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="performPublicStreet" switch="info"/>
                            <label for="performPublicStreet" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#gradingLandModalSubmitButton' value="Submit" class="btn btn-primary">
            </div>
        </div>
    </div>
</div>

{{-- Modal for Handyman Questionare--}}
<div class="modal fade bs-example-modal-lg" id="handyManModal" tabindex="-1" aria-labelledby="glazingContractorModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="handyManModalLabel">Handyman</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you perform electrical, plumbing, remodeling or roofing work?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="performElectricalPlumbingRemodeling" switch="info"/>
                            <label for="performElectricalPlumbingRemodeling" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#handyManModalSubmitButton' value="Submit" class="btn btn-primary">
            </div>
        </div>
    </div>
</div>

{{-- Modal for HVAC Questionare--}}
<div class="modal fade bs-example-modal-lg" id="hvacModal" tabindex="-1" aria-labelledby="hvacModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="hvacModalLabel">HVAC - HEATING OR COMBINED HEATING AND AIR CONDITIONING SYSTEMS, INSTALLATION, SERVICING OR REPAIR (NO LPG EQUIPMENT SALES OR WORK)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you install or repair LPG work or fire suppression system?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="installLpgFireSuspension" switch="info"/>
                            <label for="installLpgFireSuspension" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#hvacModalSubmitButton' value="Submit" class="btn btn-primary">
            </div>
        </div>
    </div>
</div>

{{-- Modal for HVAC Questionare--}}
<div class="modal fade bs-example-modal-lg" id="janitorialServicesModal" tabindex="-1" aria-labelledby="hvacModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="janitorialServicesModalLabel">JANITORIAL SERVICES</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you do any retail work or sales on cleaning supplies?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="retailWorkSales" switch="info"/>
                            <label for="retailWorkSales" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">How about Commercial Floor Waxing?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="commercialFloorWaxing" switch="info"/>
                            <label for="commercialFloorWaxing" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#janitorialServicesModalSubmitButton' value="Submit" class="btn btn-primary">
            </div>

        </div>
    </div>
</div>


{{-- Modal for Masonry Contractor Questionare--}}
<div class="modal fade bs-example-modal-lg" id="masonryContractorModal" tabindex="-1" aria-labelledby="masonryContractorModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="masonryContractorModalLabel">MASONRY</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you perfrom any work on swimming pools?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="performSwimmingPoolWork" switch="info"/>
                            <label for="performSwimmingPoolWork" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you perfrom work on retaining walls greater than 6 feet in height?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="performTallWallWork" switch="info"/>
                            <label for="performTallWallWork" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#masonryContractorModalSubmitButton' value="Submit" class="btn btn-primary">
            </div>

        </div>
    </div>
</div>


{{-- Modal for PAINTING EXTERIOR Questionare--}}
<div class="modal fade bs-example-modal-lg" id="paintingExteriorModal" tabindex="-1" aria-labelledby="paintingExteriorModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="paintingExteriorModalLabel">PAINTING EXTERIOR</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you perfrom spray work above 3 stories?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="performSprayWorkHighBuildingExterior" switch="info"/>
                            <label for="performSprayWorkHighBuildingExterior" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you perform painting on roofs or roof decks, roads and highways?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="performPaintingRoofsDecksRoadsHighwaysExterior" switch="info"/>
                            <label for="performPaintingRoofsDecksRoadsHighwaysExterior" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you perform any automotive painting?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="automotivePaintingExterior" switch="info"/>
                            <label for="automotivePaintingExterior" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#paintingExteriorModalSubmitButton' value="Submit" class="btn btn-primary">
            </div>

        </div>
    </div>
</div>

{{-- Modal for PAINTING Interior Questionare--}}
<div class="modal fade bs-example-modal-lg" id="paintingInteriorModal" tabindex="-1" aria-labelledby="paintingInteriorModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="paintingInteriorModalLabel">PAINTING INTERIOR</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you perfrom spray work above 3 stories?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="performSprayWorkHighBuildingInterior" switch="info"/>
                            <label for="performSprayWorkHighBuildingInterior" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you perform painting on roofs or roof decks, roads and highways?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="performPaintingRoofsDecksRoadsHighwaysInterior" switch="info"/>
                            <label for="performPaintingRoofsDecksRoadsHighwaysInterior" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you perform any automotive painting?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="automotivePaintingInterior" switch="info"/>
                            <label for="automotivePaintingInterior" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#paintingInteriorModalSubmitButoon' value="Submit" class="btn btn-primary">
            </div>

        </div>
    </div>
</div>

{{-- Modal for PLASTERING/STUCCO Questionare--}}
<div class="modal fade bs-example-modal-lg" id="plasteringModal" tabindex="-1" aria-labelledby="plasteringModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="plasteringModalLabel">PLASTERING/STUCCO</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you perfrom any of the following work:EIFS, work on pools, spa or ponds?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="performWorkEifs" switch="info"/>
                            <label for="performWorkEifs" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#plasteringModalSubmitButton' value="Submit" class="btn btn-primary">
            </div>

        </div>
    </div>
</div>


{{-- Modal for Plumbing Residential Questionare--}}
<div class="modal fade bs-example-modal-lg" id="plumbingResidentiallModal" tabindex="-1" aria-labelledby="plumbingResidentiallModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="plumbingResidentiallModalLabel">PLUMBING (RESIDENTIAL)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you perform or install LPG systems and piping?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="installLpgSystemResidential" switch="info"/>
                            <label for="installLpgSystemResidential" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you perform work on fire suppression systems, boiling work or swimming pools?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="performFireSuspensionResidential" switch="info"/>
                            <label for="performFireSuspensionResidential" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#plumbingResidentiallModalSubmitButton' value="Submit" class="btn btn-primary">
            </div>

        </div>
    </div>
</div>

{{-- Modal for Plumbing Commercial Questionare--}}
<div class="modal fade bs-example-modal-lg" id="plumbingCommercialModal" tabindex="-1" aria-labelledby="plumbingCommercialModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="plumbingCommercialModalLabel">PLUMBING (COMMERCIAL)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you perform or install LPG systems and piping?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="installLpgSystemCommercial" switch="info"/>
                            <label for="installLpgSystemCommercial" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you perform work on fire suppression systems, boiling work or swimming pools?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="performFireSuspensionCommercial" switch="info"/>
                            <label for="performFireSuspensionCommercial" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#plumbingCommercialModalSubmitButton' value="Submit" class="btn btn-primary">
            </div>

        </div>
    </div>
</div>

{{-- Modal for ROOFING (NEW COMMERCIAL) Questionare--}}
<div class="modal fade bs-example-modal-lg" id="roofingNewCommercialModal" tabindex="-1" aria-labelledby="roofingNewCommercialModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="roofingNewCommercialModalLabel">ROOFING (NEW COMMERCIAL)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you perform any of the following: hot work of any kind, hot tar, torch down, TPO?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="performHotWorkRoofingNewCommercial" switch="info"/>
                            <label for="performHotWorkRoofingNewCommercial" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">waterproofing, waterproof decks?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="waterProofDeckRoofingNewCommercial" switch="info"/>
                            <label for="waterProofDeckRoofingNewCommercial" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#roofingNewCommercialModalSubmitButton' value="Submit" class="btn btn-primary">
            </div>

        </div>
    </div>
</div>

{{-- Modal for ROOFING (NEW RESIDENTIAL) Questionare--}}
<div class="modal fade bs-example-modal-lg" id="roofingNewResidentialModal" tabindex="-1" aria-labelledby="roofingNewResidentialModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="roofingNewResidentialModalLabel">ROOFING (NEW RESIDENTIAL)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you perform any of the following: hot work of any kind, hot tar, torch down, TPO?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="performHotWorkRoofingNewResidential" switch="info"/>
                            <label for="performHotWorkRoofingNewResidential" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">waterproofing, waterproof decks?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="waterProofDeckRoofingNewResidential" switch="info"/>
                            <label for="waterProofDeckRoofingNewResidential" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#roofingNewResidentialModalLabelSubmitButton' value="Submit" class="btn btn-primary">
            </div>

        </div>
    </div>
</div>

{{-- Modal for ROOFING (REPAIR COMMERCIAL) Questionare--}}
<div class="modal fade bs-example-modal-lg" id="roofingRepairCommercialModal" tabindex="-1" aria-labelledby="roofingRepairCommercialModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="roofingRepairCommercialModalLabel">ROOFING (REPAIR COMMERCIAL)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you perform any of the following: hot work of any kind, hot tar, torch down, TPO?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="performHotWorkRoofingRepairCommercial" switch="info"/>
                            <label for="performHotWorkRoofingRepairCommercial" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">waterproofing, waterproof decks?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="waterProofDeckRoofingRepairCommercial" switch="info"/>
                            <label for="waterProofDeckRoofingRepairCommercial" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#roofingRepairCommercialModalSubmitButton' value="Submit" class="btn btn-primary">
            </div>

        </div>
    </div>
</div>

{{-- Modal for ROOFING (REPAIR RESIDENTIAL) Questionare--}}
<div class="modal fade bs-example-modal-lg" id="roofingRepairResidentialModal" tabindex="-1" aria-labelledby="roofingRepairResidentialModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="roofingRepairResidentialModalLabel">ROOFING (REPAIR RESIDENTIAL)</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you perform any of the following: hot work of any kind, hot tar, torch down, TPO?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="performHotWorkRoofingRepairResidential" switch="info"/>
                            <label for="performHotWorkRoofingRepairResidential" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">waterproofing, waterproof decks?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="waterProofDeckRoofingRepairResidential" switch="info"/>
                            <label for="waterProofDeckRoofingRepairResidential" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#roofingRepairResidentialModalSubmitButton' value="Submit" class="btn btn-primary">
            </div>

        </div>
    </div>
</div>

{{-- Modal for SIDING, DECKING INSTALLATION Questionare--}}
<div class="modal fade bs-example-modal-lg" id="sidingDeckingInstallationModal" tabindex="-1" aria-labelledby="sidingDeckingInstallationModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="sidingDeckingInstallationModalLabel">SIDING, DECKING INSTALLATION</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you perform or install hurricane shutters, spray on siding or roof flashings?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="installHurricanShuttersSpraySidingRoofFlashing" switch="info"/>
                            <label for="installHurricanShuttersSpraySidingRoofFlashing" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#sidingDeckingInstallationModalSubmitButton' value="Submit" class="btn btn-primary">
            </div>

        </div>
    </div>
</div>

{{-- Modal for LANDSCAPING CONTRACTORS Questionare--}}
<div class="modal fade bs-example-modal-lg" id="landscapingContractorsModal" tabindex="-1" aria-labelledby="landscapingContractorsModal" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-dark" id="landscapingContractorsModalLabel">LANDSCAPING CONTRACTORS</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

                <div class="row mb-3">
                    <div class="col-8">
                        <label class="form-label">Do you perform any work on public roads, parks, playgrounds, skateparks?</label>
                    </div>
                    <div class="col-4">
                        <div class="square-switch">
                            <input type="checkbox" id="workPublicRoadsParksPlayGroundSkatepark" switch="info"/>
                            <label for="workPublicRoadsParksPlayGroundSkatepark" data-on-label="Yes" data-off-label="No"></label>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <input type="submit" name="action_button" id="action_button" id='#landscapingContractorsModalSubmitButton' value="Submit" class="btn btn-primary">
            </div>

        </div>
    </div>
</div>







<script>
    $(document).ready(function(){
        $('#concreteFoundationWork').on('change', function(){
            if($('#concreteFoundationWork').is(':checked')){
                $('#concreteFoundationDescription').removeAttr('hidden');
                $('#concreteFoundationDescription').attr('required', 'required');
            }else{
                $('#concreteFoundationDescription').attr('hidden', true);
                $('#concreteFoundationDescription').removeAttr('required');
            }
        });
    });
</script>
