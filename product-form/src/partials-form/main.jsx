import React, { useEffect } from "react";
import Header from "./header.jsx";
import Card from "../element/card-element.jsx";
import GeneralInformation from "../views/general-information.jsx";
import Footer from "./footer.jsx";
import ContextDataProvider from "../contexts/context-data-provider.jsx";

const Main = () => {
    // const leadDetailsInstance = LeadDetails();

    return (
        <div>
            <ContextDataProvider>
                <Header />
            </ContextDataProvider>
            <div className="page-content">
                <GeneralInformation />
            </div>
        </div>
    );
};

export default Main;
