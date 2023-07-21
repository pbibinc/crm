import { useEffect, useState } from "react";

const LeadCity = () => {
    const [leadCity, setLeadCity] = useState(null);
    useEffect(() => {
        const fetchLeadCity = async () => {
            try {
                const response = await fetch(
                    `http://insuraprime_crm.test/api/leads/lead-details/lead-address`
                );
                const data = await response.json();
                setLeadCity(data);
            } catch (error) {
                console.error("Error fetching lead city", error);
            }
        };
        fetchLeadCity();
    }, []);
    if (!leadCity || !leadCity.data) {
        return <div>Loading...</div>;
    }
    return leadCity.data.map((address) => address.city);
};

export default LeadCity;
