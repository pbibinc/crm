import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";
import LeadDetails from "./lead-details";
const ExcessLiabilityPreviousData = () => {
    const [excessLiabilityPreviousData, setExcessLiabilityPreviousData] =
        useState(null);
    const getLeadData = JSON.parse(sessionStorage.getItem("lead"));
    const { lead } = LeadDetails();
    useEffect(() => {
        const fetchExcessLiability = async () => {
            try {
                const response = await axiosClient.get(
                    `api/general-liabilities-data/get/previousGeneralLiabilities/${lead?.data?.activityId}`
                );
                setExcessLiabilityPreviousData(response.data);
            } catch (error) {
                console.error(
                    "Error fetching excess liability previous data",
                    error
                );
            }
        };
        fetchExcessLiability();
    }, [lead?.data?.activityId]);
    return { excessLiabilityPreviousData };
};

export default ExcessLiabilityPreviousData;
