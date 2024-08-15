import { BusinessOwnersPolicyPreviousDataContext } from "../contexts/business-owners-previous-data-context";
import BusinessOwnersPolicyPreviousData from "../data/business-owners-policy-previous-data";

const BusinessOwnersPreviousDataProvider = ({ children }) => {
    const { businessOwnersPolicyPreviousData } =
        BusinessOwnersPolicyPreviousData();
    return (
        <BusinessOwnersPolicyPreviousDataContext.Provider
            value={{ businessOwnersPolicyPreviousData }}
        >
            {children}
        </BusinessOwnersPolicyPreviousDataContext.Provider>
    );
};

export default BusinessOwnersPreviousDataProvider;
