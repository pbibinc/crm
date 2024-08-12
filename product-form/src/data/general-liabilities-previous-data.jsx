import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";

const GeneralLiabilitiPreviousData = () => {
    const [generalLiabilityPreviousData, setGeneralLiabilityPreviousData] =
        useState(null);
    const getLeadData = JSON.parse(sessionStorage.getItem("lead"));

    useEffect(() => {
        const fetchGeneralLiability = async () => {
            try {
                const response = await axiosClient.get(
                    `api/general-liabilities-data/get/previousGeneralLiabilities/${getLeadData?.data?.activityId}`
                );
                setGeneralLiabilityPreviousData(response.data);
            } catch (error) {
                console.error("Error fetching commercial auto data", error);
            }
        };
        fetchGeneralLiability();
    }, [getLeadData?.data?.activityId]);
    return { generalLiabilityPreviousData };
};

export default GeneralLiabilitiPreviousData;
