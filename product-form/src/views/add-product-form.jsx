import React, { useContext, useEffect, useState } from "react";
// import Header from "../partials-form/header.jsx";
import "../App.css";
import Main from "../partials-form/main.jsx";
import "bootstrap/dist/css/bootstrap.min.css";
import ProductAccordion from "./product-accordion";
import ContextDataProvider, {
    ContextData,
} from "../contexts/context-data-provider";
import CardElement from "../element/card-element";
import GeneralInformationForm from "../product-form/general-information-form";
import Header from "../partials-form/header.jsx";
import Footer from "../partials-form/footer.jsx";

import { useGeneralInformation } from "../contexts/general-information-context.jsx";
import GeneralInformationDataProvider from "../providers/general-information-provider.jsx";
import Card from "react-bootstrap/Card";
import GeneralLiabilitiesForm from "../product-form/general-liabilites-form.jsx";
import WorkersCompensationForm from "../product-form/workers-compensation_form.jsx";
import CommercialAutoForm from "../product-form/commercial-auto_form.jsx";
import ExcessLiabilitiesForm from "../product-form/excess_liability_form.jsx";
import ToolsEquipmentForm from "../product-form/tools-equipment-form.jsx";
import BuilderRiskForm from "../product-form/builder-risk_form.jsx";
import BusinessOwnersPolicyForm from "../product-form/business-owners-policy_form.jsx";
import { useGeneralLiabilities } from "../contexts/general-liabilities-context.jsx";
import GeneralLiabilitiesDataProvider from "../providers/general-liabilities-provider.jsx";
import WorkersCompensationDataProvider from "../providers/workers-compensation-provider.jsx";
import CommercialAutoDataProvider from "../providers/commercial-auto-provider.jsx";
import ExcessLiabilityDataProvider from "../providers/excess-liability-provider.jsx";
import ToolsEquipmentDataProvider from "../providers/tools-equipment-provider.jsx";
import BuildersRiskDataProvider from "../providers/builders-risk-provider.jsx";
import BusinessOwnersPolicyDataProvider from "../providers/business-owners-policy-provider.jsx";

export default function AddProductForm() {
    const { generalInformation } = useGeneralInformation() || {};
    const { lead } = useContext(ContextData);
    const { generalLiabilitiesData } = useGeneralLiabilities();
    // const { generalLiabilitiesData } = useGeneralLiabilities();
    const [isLoading, setIsLoading] = useState(true);
    const [isGeneralLiabilitiesLoading, setIsGeneralLiabilitiesLoading] =
        useState(true);
    const [activeTab, setActiveTab] = useState("generalLiabilities");
    const footerStyle = {
        backgroundColor: "#3998D9",
        textAlign: "center",
        padding: "20px",
        position: "fixed",
        bottom: "0",
        width: "100%",
        height: "50px",
    };
    const pageContentStyle = {
        marginRight: "20px", // Add margin to the right
        marginLeft: "20px",
    };
    useEffect(() => {
        if (generalInformation) {
            setIsLoading(false);
        }
    }, [generalInformation]);

    var [products, setProducts] = useState([]);
    useEffect(() => {
        if (lead?.data.products) {
            setProducts(lead?.data?.products);
        }
    }, [lead]);

    useEffect(() => {
        if (generalLiabilitiesData) {
            setIsGeneralLiabilitiesLoading(false);
        }
    }, [generalLiabilitiesData]);

    return (
        <>
            <Header />
            <div className="page-content" style={pageContentStyle}>
                <main>
                    <CardElement
                        headerContent="General Information"
                        bodyContent={
                            <ContextDataProvider>
                                <GeneralInformationDataProvider>
                                    {isLoading ? (
                                        <div>Loading...</div>
                                    ) : (
                                        <GeneralInformationForm />
                                    )}
                                </GeneralInformationDataProvider>
                            </ContextDataProvider>
                        }
                    />

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
                                        onClick={() =>
                                            setActiveTab("commercialAuto")
                                        }
                                    >
                                        Commercial Auto
                                    </button>
                                    <button
                                        size="md"
                                        className="form-button"
                                        onClick={() =>
                                            setActiveTab("ExcessLiability")
                                        }
                                    >
                                        Excess Liability
                                    </button>
                                </div>
                                <div className="button-row">
                                    <button
                                        size="md"
                                        className="form-button"
                                        onClick={() =>
                                            setActiveTab("toolsEquipment")
                                        }
                                    >
                                        Tools Equipment
                                    </button>

                                    <button
                                        size="md"
                                        className="form-button"
                                        onClick={() =>
                                            setActiveTab("buildersRisk")
                                        }
                                    >
                                        Builders Risk
                                    </button>
                                </div>
                                <button
                                    size="md"
                                    className="form-button"
                                    onClick={() =>
                                        setActiveTab("businessOwnersPolicy")
                                    }
                                >
                                    Business Owners Policy
                                </button>
                            </div>
                        </Card.Body>
                    </Card>
                    <>
                        <GeneralLiabilitiesDataProvider>
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
                        </GeneralLiabilitiesDataProvider>
                        <WorkersCompensationDataProvider>
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
                        </WorkersCompensationDataProvider>
                        <CommercialAutoDataProvider>
                            {activeTab === "commercialAuto" && (
                                <CardElement
                                    headerContent="Commercial Auto"
                                    bodyContent={<CommercialAutoForm />}
                                />
                            )}
                        </CommercialAutoDataProvider>
                        <ExcessLiabilityDataProvider>
                            {activeTab === "ExcessLiability" && (
                                <CardElement
                                    headerContent="Excess Liabilitiy"
                                    bodyContent={<ExcessLiabilitiesForm />}
                                />
                            )}
                        </ExcessLiabilityDataProvider>
                        <ToolsEquipmentDataProvider>
                            {activeTab === "toolsEquipment" && (
                                <CardElement
                                    headerContent="Tools Equipment"
                                    bodyContent={<ToolsEquipmentForm />}
                                />
                            )}
                        </ToolsEquipmentDataProvider>{" "}
                        <BuildersRiskDataProvider>
                            {activeTab === "buildersRisk" && (
                                <CardElement
                                    headerContent="Builders Risk"
                                    bodyContent={<BuilderRiskForm />}
                                />
                            )}
                        </BuildersRiskDataProvider>
                        <BusinessOwnersPolicyDataProvider>
                            {activeTab === "businessOwnersPolicy" && (
                                <CardElement
                                    headerContent="Business Owners Policy"
                                    bodyContent={<BusinessOwnersPolicyForm />}
                                />
                            )}
                        </BusinessOwnersPolicyDataProvider>
                    </>
                </main>
            </div>
            <ContextDataProvider>
                <Footer />
            </ContextDataProvider>
        </>
    );
}
