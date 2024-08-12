import { WorkersCompensationContext } from "../contexts/workers-compensation-context";
import WorkersCompensationData from "../data/workers-compensation-data";

const WorkersCompensationDataProvider = ({ children }) => {
    const { workersCompensationData } = WorkersCompensationData();

    return (
        <WorkersCompensationContext.Provider
            value={{ workersCompensationData }}
        >
            {children}
        </WorkersCompensationContext.Provider>
    );
};

export default WorkersCompensationDataProvider;
