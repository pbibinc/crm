import { useEffect, useState } from "react";

const LeadDetails = () => {
    const [lead, setLead] = useState(null);

    useEffect(() => {
        const fetchLead = async () => {
            try {
                const response = await fetch(
                    `http://insuraprime_crm.test/api/leads/lead-details`
                );
                const data = await response.json();
                setLead(data);
            } catch (error) {
                console.error("Error fetching lead", error);
            }
        };
        fetchLead();
    }, []);
    return lead;
};

export default LeadDetails;
