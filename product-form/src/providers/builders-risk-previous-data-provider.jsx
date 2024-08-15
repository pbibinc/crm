import { BuildersRiskPreviousDataContext } from "../contexts/builders-risk-previous-data-context";
import BuildersRiskPreviousData from "../data/builders-risk-previous-data";

const BuildersRiskPreviousDataProvider = ({ children }) => {
    const { buildersRiskPreviousData } = BuildersRiskPreviousData();

    return (
        <BuildersRiskPreviousDataContext.Provider
            value={{ buildersRiskPreviousData }}
        >
            {children}
        </BuildersRiskPreviousDataContext.Provider>
    );
};

export default BuildersRiskPreviousDataProvider;
