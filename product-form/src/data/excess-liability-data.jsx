import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";
import LeadDetails from "./lead-details";

const ExcessLiabilityData = () => {
    const [excessLiabilityData, setExcessLiability] = useState(null);
    const getLeadData = JSON.parse(sessionStorage.getItem("lead"));
    const { lead } = LeadDetails();
    useEffect(() => {
        const fetchExcessLiability = async () => {
            try {
                const respone = await axiosClient.get(
                    `api/excess-liability-data/edit/${lead?.data?.id}`
                );
                setExcessLiability(respone.data);
            } catch (error) {
                console.error(
                    "Error fetching workers compensation data",
                    error
                );
            }
        };
        fetchExcessLiability();
    }, [lead?.data?.id]);
    return { excessLiabilityData };
};

export default ExcessLiabilityData;
