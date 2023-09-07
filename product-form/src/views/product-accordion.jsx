import React from "react";
import Accordion from "react-bootstrap/Accordion";
import GeneralLiabilitiesForm from "../product-form/general-liabilites-form";
import WorkersCompensationForm from "../product-form/workers-compensation_form";
import CommercialAutoForm from "../product-form/commercial-auto_form";
import ContextDataProvider from "../contexts/context-data-provider";
import ExcessLiabilitiesForm from "../product-form/excess_liability_form";
import ToolsEquipmentForm from "../product-form/tools-equipment-form";
import BuilderRiskForm from "../product-form/builder-risk_form";


function ProductAccordion() {
    return (
        <>
            <div className="row mb-4">
                <Accordion>
                    <Accordion.Item eventKey="0">
                        <Accordion.Header className="info">
                            General Liabilites Questionare
                        </Accordion.Header>
                        <Accordion.Body>
                            <ContextDataProvider>
                             <GeneralLiabilitiesForm />
                            </ContextDataProvider>
                        </Accordion.Body>
                    </Accordion.Item>
                </Accordion>
            </div>

            <div className="row mb-4">
                <Accordion>
                    <Accordion.Item eventKey="0">
                        <Accordion.Header className="info">
                            Workers Compensation Questionare
                        </Accordion.Header>
                        <Accordion.Body>
                            <WorkersCompensationForm />
                        </Accordion.Body>
                    </Accordion.Item>
                </Accordion>
            </div>

            <div className="row mb-4">
            <Accordion>
                <Accordion.Item eventKey="0">
                    <Accordion.Header className="info">
                        Commercial Auto Questionare
                    </Accordion.Header>
                    <Accordion.Body>
                        <CommercialAutoForm />
                    </Accordion.Body>
                </Accordion.Item>
            </Accordion>
            </div>

            <div className="row mb-4">
            <Accordion>
                <Accordion.Item eventKey="0">
                    <Accordion.Header className="info">
                        Excess Liabilities
                    </Accordion.Header>
                    <Accordion.Body>
                        <ExcessLiabilitiesForm
                         />
                    </Accordion.Body>
                </Accordion.Item>
            </Accordion>
            </div>

            <div className="row mb-4">
            <Accordion>
                <Accordion.Item eventKey="0">
                    <Accordion.Header className="info">
                        Tools Equipment
                    </Accordion.Header>
                    <Accordion.Body>
                        <ToolsEquipmentForm
                         />
                    </Accordion.Body>
                </Accordion.Item>
            </Accordion>
            </div>

            <div className="row mb-4">
            <Accordion>
                <Accordion.Item eventKey="0">
                    <Accordion.Header className="info">
                        Builders Risk
                    </Accordion.Header>
                    <Accordion.Body>
                        <BuilderRiskForm
                         />
                    </Accordion.Body>
                </Accordion.Item>
            </Accordion>
            </div>

        </>
    );
}

export default ProductAccordion;
