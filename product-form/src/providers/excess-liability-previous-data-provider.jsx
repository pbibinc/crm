import { ExcessLiabilityPreviousDataContext } from "../contexts/excess-liability-previous-data-context";
import ExcessLiabilityPreviousData from "../data/excess-liability-previous-data";

const ExcessLiabilityPreviousDataProvider = ({ children }) => {
    const { excessLiabilityPreviousData } = ExcessLiabilityPreviousData();

    return (
        <ExcessLiabilityPreviousDataContext.Provider
            value={{ excessLiabilityPreviousData }}
        >
            {children}
        </ExcessLiabilityPreviousDataContext.Provider>
    );
};

export default ExcessLiabilityPreviousDataProvider;
