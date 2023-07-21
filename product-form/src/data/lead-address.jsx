import { useEffect, useState } from "react";

const LeadAddress = () => {
    const [leadAddress, setLeadAddress] = useState(null);
    useEffect(() => {
        const fetchLeadAddress = async () => {
            try {
                const response = await fetch(
                    `http://insuraprime_crm.test/api/leads/lead-details/lead-address`
                );
                const data = await response.json();
                setLeadAddress(data);
            } catch (error) {
                console.error("Error fetching lead address", error);
            }
        };
        fetchLeadAddress();
    }, []);
    // console.log(leadAddress.data);
    if (!leadAddress || !leadAddress.data) {
        return <div>Loading...</div>;
    }

    return leadAddress.data;
};

export default LeadAddress;
