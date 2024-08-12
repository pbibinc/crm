import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";
import LeadDetails from "./lead-details";

const BusinessOwnersPolicyData = () => {
    const [businessOwnersPolicyData, setBusinessOwnersPolicyData] =
        useState(null);
    const getLeadData = JSON.parse(sessionStorage.getItem("lead"));
    const { lead } = LeadDetails();
    useEffect(() => {
        const fetchBusinessOwnersPolicyData = async () => {
            try {
                const response = await axiosClient.get(
                    `/api/business-owners-policy/edit/${lead?.data?.id}`
                );
                setBusinessOwnersPolicyData(response.data);
            } catch (error) {
                console.error(
                    "Error fetching business owners policy data",
                    error
                );
            }
        };
        fetchBusinessOwnersPolicyData();
    }, [lead?.data?.id]);
    return { businessOwnersPolicyData };
};

export default BusinessOwnersPolicyData;
