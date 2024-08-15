import GeneralLiabilitiPreviousData from "../data/general-liabilities-previous-data";
import { GeneralLiabilitiesPreviousDataContext } from "../contexts/general-liabilities-previous-data-context";

const GeneralLiabilitiesPreviousDataProvider = ({ children }) => {
    const { generalLiabilityPreviousData } = GeneralLiabilitiPreviousData();

    return (
        <GeneralLiabilitiesPreviousDataContext.Provider
            value={{ generalLiabilityPreviousData }}
        >
            {children}
        </GeneralLiabilitiesPreviousDataContext.Provider>
    );
};

export default GeneralLiabilitiesPreviousDataProvider;
