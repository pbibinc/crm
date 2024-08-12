import { BuildersRiskContext } from "../contexts/builders-risk-context";
import BuildersRiskData from "../data/builders-risk-data";

const BuildersRiskDataProvider = ({ children }) => {
    const { buildersRiskData } = BuildersRiskData();
    return (
        <BuildersRiskContext.Provider value={{ buildersRiskData }}>
            {children}
        </BuildersRiskContext.Provider>
    );
};

export default BuildersRiskDataProvider;
