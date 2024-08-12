import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";

const BusinessOwnersPolicyPreviousData = () => {
    const [
        businessOwnersPolicyPreviousData,
        setBusinessOwnersPolicyPreviousData,
    ] = useState(null);
    const getLeadData = JSON.parse(sessionStorage.getItem("lead"));

    useEffect(() => {
        const fetchBusinessOwnersPolicyPreviousData = async () => {
            try {
                const response = await axiosClient.get(
                    `/api/business-owners-policy/get/previousBusinessOwnersPolicyInformation/${getLeadData?.data?.activityId}`
                );
                setBusinessOwnersPolicyPreviousData(response.data);
            } catch (error) {
                console.error("Error fetching builders risk data", error);
            }
        };
        fetchBusinessOwnersPolicyPreviousData();
    }, [getLeadData?.data?.activityId]);
    return { businessOwnersPolicyPreviousData };
};

export default BusinessOwnersPolicyPreviousData;
