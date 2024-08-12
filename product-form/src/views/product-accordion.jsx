import React, { useEffect, useRef, useState } from "react";
import Accordion from "react-bootstrap/Accordion";
import GeneralLiabilitiesForm from "../product-form/general-liabilites-form";
import WorkersCompensationForm from "../product-form/workers-compensation_form";
import CommercialAutoForm from "../product-form/commercial-auto_form";
import ContextDataProvider from "../contexts/context-data-provider";
import ExcessLiabilitiesForm from "../product-form/excess_liability_form";
import ToolsEquipmentForm from "../product-form/tools-equipment-form";
import BuilderRiskForm from "../product-form/builder-risk_form";
import BusinessOwnersPolicyForm from "../product-form/business-owners-policy_form";

import Card from "react-bootstrap/Card";
import CardElement from "../element/card-element";
// import Button from "react-bootstrap/Button";
import "../style/product-accordion-style.css?v=2";
function ProductAccordion() {
    const [activeTab, setActiveTab] = useState("generalLiabilities");

    return (
        <>
            <Card>
                <Card.Body>
                    <div className="button-grid">
                        <div className="button-row">
                            <button
                                size="md"
                                className="form-button"
                                onClick={() =>
                                    setActiveTab("generalLiabilities")
                                }
                            >
                                General Liabilities
                            </button>
                            <button
                                size="md"
                                className="form-button"
                                onClick={() =>
                                    setActiveTab("workersCompensation")
                                }
                            >
                                Workers Comp
                            </button>
                        </div>
                        <div className="button-row">
                            <button
                                size="md"
                                className="form-button"
                                onClick={() => setActiveTab("commercialAuto")}
                            >
                                Commercial Auto
                            </button>
                            <button
                                size="md"
                                className="form-button"
                                onClick={() => setActiveTab("ExcessLiability")}
                            >
                                Excess Liability
                            </button>
                        </div>
                        <div className="button-row">
                            <button
                                size="md"
                                className="form-button"
                                onClick={() => setActiveTab("toolsEquipment")}
                            >
                                Tools Equipment
                            </button>
                            <button
                                size="md"
                                className="form-button"
                                onClick={() => setActiveTab("buildersRisk")}
                            >
                                Builders Risk
                            </button>
                        </div>
                        <button
                            size="md"
                            className="form-button"
                            onClick={() => setActiveTab("businessOwnersPolicy")}
                        >
                            Business Owners Policy
                        </button>
                    </div>
                </Card.Body>
            </Card>

            {activeTab === "generalLiabilities" && (
                <CardElement
                    headerContent="General Liabilities"
                    bodyContent={
                        <ContextDataProvider>
                            <GeneralLiabilitiesForm />
                        </ContextDataProvider>
                    }
                />
            )}
            {activeTab === "workersCompensation" && (
                <CardElement
                    headerContent="Workers Compensation"
                    bodyContent={
                        <ContextDataProvider>
                            <WorkersCompensationForm />
                        </ContextDataProvider>
                    }
                />
            )}
            {activeTab === "commercialAuto" && (
                <CardElement
                    headerContent="Commercial Auto"
                    bodyContent={
                        <ContextDataProvider>
                            <CommercialAutoForm />
                        </ContextDataProvider>
                    }
                />
            )}
            {activeTab === "ExcessLiability" && (
                <CardElement
                    headerContent="Excess Liabilitiy"
                    bodyContent={
                        <ContextDataProvider>
                            <ExcessLiabilitiesForm />
                        </ContextDataProvider>
                    }
                />
            )}
            {activeTab === "toolsEquipment" && (
                <CardElement
                    headerContent="Tools Equipment"
                    bodyContent={
                        <ContextDataProvider>
                            <ToolsEquipmentForm />
                        </ContextDataProvider>
                    }
                />
            )}
            {activeTab === "buildersRisk" && (
                <CardElement
                    headerContent="Builders Risk"
                    bodyContent={
                        <ContextDataProvider>
                            <BuilderRiskForm />
                        </ContextDataProvider>
                    }
                />
            )}
            {activeTab === "businessOwnersPolicy" && (
                <CardElement
                    headerContent="Business Owners Policy"
                    bodyContent={
                        <ContextDataProvider>
                            <BusinessOwnersPolicyForm />
                        </ContextDataProvider>
                    }
                />
            )}
        </>
    );
}

export default ProductAccordion;
