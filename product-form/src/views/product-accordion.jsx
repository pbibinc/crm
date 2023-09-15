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
import Nav from 'react-bootstrap/Nav';
import Card from 'react-bootstrap/Card';
import BeachAccessIcon from '@mui/icons-material/BeachAccess';



function ProductAccordion() {
    const [activeTab, setActiveTab] = useState("generalLiabilities");
    // const [isFixed, setIsFixed] = useState(false);
    // const [originalPosition, setOriginalPosition] = useState(0);


    // useEffect(() => {
    //     // Store the card's original position
    //     if (cardRef.current && originalPosition === 0) {
    //         setOriginalPosition(cardRef.current.offsetTop);
    //     }

    //     const checkScroll = () => {
    //         if (!cardRef.current) return;  // Safety check

    //         if (window.scrollY > originalPosition && !isFixed) {
    //             setIsFixed(true);
    //         } else if (window.scrollY <= originalPosition && isFixed) {
    //             setIsFixed(false);
    //         }
    //     };

    //     window.addEventListener('scroll', checkScroll);

    //     return () => {
    //         window.removeEventListener('scroll', checkScroll);
    //     };
    // }, [isFixed, originalPosition]);

    // const fixedCardStyle = {
    //     position: 'fixed',
    //     top: 70,
    //     width: '98%',
    //     zIndex: 1030
    // };

    // const scrollToForm = () => {
    //     if (formRef.current) {
    //         formRef.current.scrollIntoView({ behavior: "smooth" });
    //     }
    // };

    // const cardRef = useRef();
    // const formRef = useRef();
    //ref={cardRef} style={isFixed ? fixedCardStyle : null}
    return (
        <>
        <Card >
            <Card.Body>
            <div className="row mb-4">
            <Nav justify variant="tabs">
            <Nav.Item>
                <Nav.Link  active={activeTab === 'generalLiabilities'}  onClick={() => setActiveTab('generalLiabilities')}>GL</Nav.Link>
            </Nav.Item>
            <Nav.Item>
                <Nav.Link active={activeTab === 'workersCompensation'} onClick={() => setActiveTab('workersCompensation')}>WC</Nav.Link>
            </Nav.Item>
            <Nav.Item>
                <Nav.Link active={activeTab === 'commercialAuto'} onClick={() => setActiveTab('commercialAuto')}>CA</Nav.Link>
            </Nav.Item>
            <Nav.Item>
                <Nav.Link active={activeTab === 'ExcessLiability'} onClick={() => setActiveTab('ExcessLiability')}>EL</Nav.Link>
            </Nav.Item>
            <Nav.Item>
                <Nav.Link active={activeTab === 'toolsEquipment'} onClick={() => setActiveTab('toolsEquipment')}>TE</Nav.Link>
            </Nav.Item>
            <Nav.Item>
                <Nav.Link active={activeTab === 'buildersRisk'} onClick={() => setActiveTab('buildersRisk')}>BR</Nav.Link>
            </Nav.Item>
            <Nav.Item>
                <Nav.Link active={activeTab === 'businessOwnersPolicy'} onClick={() => setActiveTab('businessOwnersPolicy')}>BOP</Nav.Link>
            </Nav.Item>
            </Nav>
            </div>

         {activeTab === "generalLiabilities" && (
            <ContextDataProvider>
                <GeneralLiabilitiesForm />
            </ContextDataProvider>
        )}
          {activeTab === "workersCompensation" && (
            <ContextDataProvider>
              <WorkersCompensationForm />
            </ContextDataProvider>
        )}
          {activeTab === "commercialAuto" && (
            <ContextDataProvider>
             <CommercialAutoForm />
            </ContextDataProvider>
        )}
        {activeTab === "ExcessLiability" && (
            <ContextDataProvider>
                <ExcessLiabilitiesForm />
            </ContextDataProvider>
        )}
        {activeTab === "toolsEquipment" && (
            <ContextDataProvider>
                <ToolsEquipmentForm />
            </ContextDataProvider>
        )}
        {activeTab === "buildersRisk" && (
            <ContextDataProvider>
                <BuilderRiskForm />
            </ContextDataProvider>
        )}
        {activeTab === "businessOwnersPolicy" && (
            <ContextDataProvider>
                <BusinessOwnersPolicyForm />
            </ContextDataProvider>
        )}
            </Card.Body>
        </Card>



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
