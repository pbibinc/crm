import React, { useEffect, useState } from "react";
import Row from "../element/row-element";
import CarpentryWoodworkingForm from "./carpentry_woodworking_form";
import PressureWashingForm from "./pressure_washing_form";
import ConcreteFoundationForm from "./concrete_construction_form";
import ExcutiveSuperVisorsForm from "./executive_supervisors_form";
import MetalInstallationForm from "./metal_installation_form";
import DebrisRemovalForm from "./debris_removal_form";
import ElectricalWorkForm from "./electrical_work_form";
import ExcavationNocForm from "./excavation_noc_form";
import FenceExectionForm from "./fence_erection_form";
import GlazingContractorForm from "./glazing_contractor_form";
import GradingLandForm from "./grading_land_form";
import HandymanForm from "./handyman_form";
import HvacForm from "./hvac_form";
import JanitorialServicesForm from "./janitorial_form";
import MasonryForm from "./masonry_form";
import PaintingExteriorForm from "./painting_exterior_form";
import PaintingInteriorForm from "./painting_interior_form";
import PlasteringForm from "./plastering_form";
import PlumbingCommercialForm from "./plumbing_commercial_form";
import PlumbingResidentialForm from "./plumbing_residential_form";
import RoofingNewCommercialForm from "./roofing_new_commercial_form";
import RoofingNewResidential from "./roofing_new_residential_form";
import RoofingRepairCommercial from "./roofing_repair_commercial_form";
import RoofingRepairResidentialForm from "./roofing_repair_residential_form";
import DeckingInstallation from "./decking_installation_form";
import LandscapingForm from "./landscaping_contractor_form";

const ClassCodeMain = ({
    classCodeIdData,
    key,
    setClassCodeFormData,
    disabled,
}) => {

    const classCodeQuestionnaireMap = {
        210 : <CarpentryWoodworkingForm setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        164 : <PressureWashingForm setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        189 : <ConcreteFoundationForm setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        217 : <ExcutiveSuperVisorsForm setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        223 : <MetalInstallationForm setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        18 : <DebrisRemovalForm setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        226 : <ElectricalWorkForm setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        20 : <ExcavationNocForm setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        31 : <FenceExectionForm setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        112 : <GlazingContractorForm setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        36 : <GradingLandForm setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        114 : <HandymanForm setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        115 : <HvacForm setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        17 : <JanitorialServicesForm setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        51 : <MasonryForm setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        245 : <PaintingExteriorForm setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        246 : <PaintingInteriorForm setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        196 : <PlasteringForm setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        61 : <PlumbingCommercialForm setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        191 : <PlumbingResidentialForm setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        252 : <RoofingNewCommercialForm setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        253 : <RoofingNewResidential setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        254 : <RoofingRepairCommercial setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        255 : <RoofingRepairResidentialForm setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        132 : <DeckingInstallation setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,
        119 : <LandscapingForm setClassCodeFormData={setClassCodeFormData} disabled={disabled}/>,

    };
    const classCodeQuestionare = classCodeQuestionnaireMap[classCodeIdData];

    return (
        <>
            <React.StrictMode>
                <Row
                    key={key}
                    classValue=""
                    rowContent={classCodeQuestionare}
                />
            </React.StrictMode>
        </>
    );
};

export default ClassCodeMain;
