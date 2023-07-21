import { useEffect, useState } from "react";

const LeadZipcode = () => {
    const [leadZipcode, setLeadZipcode] = useState(null);
    useEffect(() => {
        const fetchLeadZipcode = async () => {
            try {
                const response = await fetch(
                    `http://insuraprime_crm.test/api/leads/lead-details/lead-address`
                );
                const data = await response.json();
                setLeadZipcode(data);
            } catch (error) {
                console.error("Error fetching lead zipcode", error);
            }
        };
        fetchLeadZipcode();
    }, []);
    if (!leadZipcode || !leadZipcode.data) {
        return <div>Loading...</div>;
    }

    return leadZipcode.data.map((address) => address.zipcode);
};

export default LeadZipcode;
