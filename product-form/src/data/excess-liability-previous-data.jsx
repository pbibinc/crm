import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";

const ExcessLiabilityPreviousData = () => {
    const [excessLiabilityPreviousData, setExcessLiabilityPreviousData] =
        useState(null);
    const getLeadData = JSON.parse(sessionStorage.getItem("lead"));

    useEffect(() => {
        const fetchExcessLiability = async () => {
            try {
                const response = await axiosClient.get(
                    `api/general-liabilities-data/get/previousGeneralLiabilities/${getLeadData?.data?.activityId}`
                );
                setExcessLiabilityPreviousData(response.data);
            } catch (error) {
                console.error("Error fetching commercial auto data", error);
            }
        };
        fetchExcessLiability();
    }, [getLeadData?.data?.activityId]);
    return { excessLiabilityPreviousData };
};

export default ExcessLiabilityPreviousData;
