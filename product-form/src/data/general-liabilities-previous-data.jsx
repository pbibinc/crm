import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";
import LeadDetails from "./lead-details";

const GeneralLiabilitiPreviousData = () => {
    const [generalLiabilityPreviousData, setGeneralLiabilityPreviousData] =
        useState(null);
    const getLeadData = JSON.parse(sessionStorage.getItem("lead"));
    const { lead } = LeadDetails();
    useEffect(() => {
        const fetchGeneralLiability = async () => {
            try {
                const response = await axiosClient.get(
                    `api/general-liabilities-data/get/previousGeneralLiabilities/${lead?.data?.activityId}`
                );
                setGeneralLiabilityPreviousData(response.data);
            } catch (error) {
                console.error("Error fetching commercial auto data", error);
            }
        };
        fetchGeneralLiability();
    }, [lead?.data?.activityId]);
    return { generalLiabilityPreviousData };
};

export default GeneralLiabilitiPreviousData;
