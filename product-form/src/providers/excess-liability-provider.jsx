import { ExcessLiabilityContext } from "../contexts/excess-liability-context";
import ExcessLiabilityData from "../data/excess-liability-data";

const ExcessLiabilityDataProvider = ({ children }) => {
    const { excessLiabilityData } = ExcessLiabilityData();

    return (
        <ExcessLiabilityContext.Provider value={{ excessLiabilityData }}>
            {children}
        </ExcessLiabilityContext.Provider>
    );
};

export default ExcessLiabilityDataProvider;
