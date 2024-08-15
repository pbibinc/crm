import { WorkersCompensationPreviousDataContext } from "../contexts/workers-compensation-previous-data-context";
import WorkersCompensationPreviousData from "../data/workers-compensation-previous-data";

const WorkersCompensationPreviousDataProvider = ({ children }) => {
    const { workersCompensationPreviousData } =
        WorkersCompensationPreviousData();

    return (
        <WorkersCompensationPreviousDataContext.Provider
            value={{ workersCompensationPreviousData }}
        >
            {children}
        </WorkersCompensationPreviousDataContext.Provider>
    );
};

export default WorkersCompensationPreviousDataProvider;
