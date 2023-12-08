import React, { useEffect } from "react";
import Header from "./header.jsx";
import Card from "../element/card-element.jsx";
import GeneralInformation from "../views/general-information.jsx";
import Footer from "./footer.jsx";
import ContextDataProvider from "../contexts/context-data-provider.jsx";

const Main = () => {
    // const leadDetailsInstance = LeadDetails();
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
    return (
        <div>
            <ContextDataProvider>
                <Header />
            </ContextDataProvider>
            <div className="page-content" style={pageContentStyle}>
                <GeneralInformation />
            </div>
            <ContextDataProvider>
                <Footer />
            </ContextDataProvider>
        </div>
    );
};

export default Main;
