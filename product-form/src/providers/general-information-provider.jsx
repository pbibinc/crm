import React from "react";

import GeneralInformationData from "../data/general-information-data";
import { GeneralInformationContext } from "../contexts/general-information-context";

const GeneralInformationDataProvider = ({ children }) => {
    const { generalInformation } = GeneralInformationData();
    return (
        <GeneralInformationContext.Provider value={{ generalInformation }}>
            {children}
        </GeneralInformationContext.Provider>
    );
};

export default GeneralInformationDataProvider;
