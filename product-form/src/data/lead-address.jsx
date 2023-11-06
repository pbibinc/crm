import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";

const LeadAddress = () => {
    const [leadAddress, setLeadAddress] = useState(null);
    useEffect(() => {
        const fetchLeadAddress = async () => {
            try {
                const response = await axiosClient.get(
                    `/api/leads/lead-details/lead-address`
                );
                setLeadAddress(response.data);
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
