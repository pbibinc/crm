import { BusinessOwnersPolicyContext } from "../contexts/business-owners-policy-context";
import BusinessOwnersPolicyData from "../data/business-owners-policy-data";

const BusinessOwnersPolicyDataProvider = ({ children }) => {
    const { businessOwnersPolicyData } = BusinessOwnersPolicyData();
    return (
        <BusinessOwnersPolicyContext.Provider
            value={{ businessOwnersPolicyData }}
        >
            {children}
        </BusinessOwnersPolicyContext.Provider>
    );
};

export default BusinessOwnersPolicyDataProvider;
