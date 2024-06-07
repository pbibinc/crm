import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";

const CommercialAutoPreviousData = () => {
    const [commercialAutoPreviousData, setCommercialAutoPreviousData] =
        useState(null);
    const getLeadData = JSON.parse(sessionStorage.getItem("lead"));

    useEffect(() => {
        const fetchCommercialAutoData = async () => {
            try {
                const response = await axiosClient.get(
                    `/api/commercial-auto-data/get/previousCommercialAutoInformation/${getLeadData?.data?.activityId}`
                );
                setCommercialAutoPreviousData(response.data);
            } catch (error) {
                console.error("Error fetching commercial auto data", error);
            }
        };
        fetchCommercialAutoData();
    }, [getLeadData?.data?.activityId]);
    console.log("commercialAutoPreviousData", commercialAutoPreviousData);
    return { commercialAutoPreviousData };
};

export default CommercialAutoPreviousData;
