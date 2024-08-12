import { GeneralLiabilitiesContext } from "../contexts/general-liabilities-context";
import GeneralLiabilitiesData from "../data/general-liabilities-data";

const GeneralLiabilitiesDataProvider = ({ children }) => {
    const { generalLiabilitiesData } = GeneralLiabilitiesData();
    return (
        <GeneralLiabilitiesContext.Provider value={{ generalLiabilitiesData }}>
            {children}
        </GeneralLiabilitiesContext.Provider>
    );
};

export default GeneralLiabilitiesDataProvider;
