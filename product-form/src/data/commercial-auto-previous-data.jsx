import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";
import LeadDetails from "./lead-details";

const CommercialAutoPreviousData = () => {
    const [commercialAutoPreviousData, setCommercialAutoPreviousData] =
        useState(null);
    const getLeadData = JSON.parse(sessionStorage.getItem("lead"));
    const { lead } = LeadDetails();
    useEffect(() => {
        const fetchCommercialAutoData = async () => {
            try {
                const response = await axiosClient.get(
                    `/api/commercial-auto-data/get/previousCommercialAutoInformation/${lead?.data?.activityId}`
                );
                setCommercialAutoPreviousData(response.data);
            } catch (error) {
                console.error("Error fetching commercial auto data", error);
            }
        };
        fetchCommercialAutoData();
    }, [lead?.data?.activityId]);

    return { commercialAutoPreviousData };
};

export default CommercialAutoPreviousData;
