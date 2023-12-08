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
            {/* <div className="row mb-4">
                        <Nav justify variant="tabs">
                            <Nav.Item>
                                <Nav.Link
                                    active={activeTab === "generalLiabilities"}
                                    onClick={() =>
                                        setActiveTab("generalLiabilities")
                                    }
                                >
                                    <div className="row">
                                        General Liabilities
                                    </div>
                                </Nav.Link>
                            </Nav.Item>
                            <Nav.Item>
                                <Nav.Link
                                    active={activeTab === "workersCompensation"}
                                    onClick={() =>
                                        setActiveTab("workersCompensation")
                                    }
                                >
                                    <div className="row">Work Compensation</div>
                                </Nav.Link>
                            </Nav.Item>
                            <Nav.Item>
                                <Nav.Link
                                    active={activeTab === "commercialAuto"}
                                    onClick={() =>
                                        setActiveTab("commercialAuto")
                                    }
                                >
                                    <div className="row"> Commercial Auto</div>
                                </Nav.Link>
                            </Nav.Item>
                            <Nav.Item>
                                <Nav.Link
                                    active={activeTab === "ExcessLiability"}
                                    onClick={() =>
                                        setActiveTab("ExcessLiability")
                                    }
                                >
                                    <div className="row"> Excess Liability</div>
                                </Nav.Link>
                            </Nav.Item>
                            <Nav.Item>
                                <Nav.Link
                                    active={activeTab === "toolsEquipment"}
                                    onClick={() =>
                                        setActiveTab("toolsEquipment")
                                    }
                                >
                                    <div className="row">Tools Equipment</div>
                                </Nav.Link>
                            </Nav.Item>

                            <Nav.Item>
                                <Nav.Link
                                    active={activeTab === "buildersRisk"}
                                    onClick={() => setActiveTab("buildersRisk")}
                                >
                                    <div className="row">builders risk</div>
                                </Nav.Link>
                            </Nav.Item>
                            <Nav.Item>
                                <Nav.Link
                                    active={
                                        activeTab === "businessOwnersPolicy"
                                    }
                                    onClick={() =>
                                        setActiveTab("businessOwnersPolicy")
                                    }
                                >
                                    <div className="row">
                                        business owners policy
                                    </div>
                                </Nav.Link>
                            </Nav.Item>
                        </Nav>
                    </div> */}
            {/* <Card>
                <Card.Body>
                    <div className="row ">
                        <div className="col-6">
                            <div className="row">
                                <div className="col-6">
                                    <Button
                                        variant="outline-primary"
                                        size="md"
                                        // className={`btn btn-link ${
                                        //     activeTab === "generalLiabilities"
                                        //         ? "active mx-2 form-button"
                                        //         : "mx-2 form-button"
                                        // }`}
                                        className="form-button mb-4"
                                    >
                                        General Liabilities
                                    </Button>
                                </div>
                                <div className="col-6">
                                    {" "}
                                    <Button
                                        variant="outline-primary"
                                        size="md"
                                        className="form-button"
                                        onClick={() =>
                                            setActiveTab("workersCompensation")
                                        }
                                    >
                                        Workers Comp
                                    </Button>
                                </div>
                            </div>
                        </div>
                        <div className="col-6">
                            <div className="row">
                                <div className="col-6">
                                    <Button
                                        variant="outline-primary"
                                        size="md"
                                        className="form-button"
                                        onClick={() =>
                                            setActiveTab("commercialAuto")
                                        }
                                    >
                                        Commercial Auto
                                    </Button>
                                </div>
                                <div className="col-6">
                                    <Button
                                        variant="outline-primary"
                                        size="md"
                                        className="form-button"
                                        onClick={() =>
                                            setActiveTab("ExcessLiability")
                                        }
                                    >
                                        Excess Liability
                                    </Button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="row">
                        <div className="col-4">
                            <Button
                                variant="outline-primary"
                                size="md"
                                className="form-button"
                                onClick={() => setActiveTab("toolsEquipment")}
                            >
                                Tools Equipment
                            </Button>
                        </div>
                        <div className="col-4">
                            <Button
                                variant="outline-primary"
                                size="md"
                                className="form-button"
                                onClick={() => setActiveTab("buildersRisk")}
                            >
                                Builders Risk
                            </Button>
                        </div>
                        <div className="col-4">
                            {" "}
                            <Button
                                variant="outline-primary"
                                size="md"
                                className="form-button"
                                onClick={() =>
                                    setActiveTab("businessOwnersPolicy")
                                }
                            >
                                Business Owners Policy
                            </Button>
                        </div>
                    </div>
                </Card.Body>
            </Card> */}
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

            {/* <div className="row mb-4">
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

            <div className="row mb-4">
            <Accordion>
                <Accordion.Item eventKey="0">
                    <Accordion.Header className="info">
                        Business Owner Policy
                    </Accordion.Header>
                    <Accordion.Body>
                        <BusinessOwnersPolicyForm/>
                    </Accordion.Body>
                </Accordion.Item>
            </Accordion>
            </div> */}
        </>
    );
}

export default ProductAccordion;
