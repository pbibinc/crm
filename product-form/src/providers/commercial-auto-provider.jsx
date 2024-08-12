import { CommercialAutoContext } from "../contexts/commercial-auto-context";
import CommercialAutoData from "../data/commercial-auto-data";

const CommercialAutoDataProvider = ({ children }) => {
    const { commercialAutoData } = CommercialAutoData();

    return (
        <CommercialAutoContext.Provider value={{ commercialAutoData }}>
            {children}
        </CommercialAutoContext.Provider>
    );
};

export default CommercialAutoDataProvider;
