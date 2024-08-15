import { CommercialAutoPreviousDataContext } from "../contexts/commercial-auto-previous-data-context";
import CommercialAutoPreviousData from "../data/commercial-auto-previous-data";

const CommercialAutoPreviousDataProvider = ({ children }) => {
    const { commercialAutoPreviousData } = CommercialAutoPreviousData();

    return (
        <CommercialAutoPreviousDataContext.Provider
            value={{ commercialAutoPreviousData }}
        >
            {children}
        </CommercialAutoPreviousDataContext.Provider>
    );
};

export default CommercialAutoPreviousDataProvider;
