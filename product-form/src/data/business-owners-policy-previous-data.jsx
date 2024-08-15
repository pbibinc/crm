import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";
import LeadDetails from "./lead-details";

const BusinessOwnersPolicyPreviousData = () => {
    const [
        businessOwnersPolicyPreviousData,
        setBusinessOwnersPolicyPreviousData,
    ] = useState(null);
    const getLeadData = JSON.parse(sessionStorage.getItem("lead"));
    const { lead } = LeadDetails();
    useEffect(() => {
        const fetchBusinessOwnersPolicyPreviousData = async () => {
            try {
                const response = await axiosClient.get(
                    `/api/business-owners-policy/get/previousBusinessOwnersPolicyInformation/${lead?.data?.activityId}`
                );
                setBusinessOwnersPolicyPreviousData(response.data);
            } catch (error) {
                console.error("Error fetching builders risk data", error);
            }
        };
        fetchBusinessOwnersPolicyPreviousData();
    }, [lead?.data?.activityId]);
    return { businessOwnersPolicyPreviousData };
};

export default BusinessOwnersPolicyPreviousData;
