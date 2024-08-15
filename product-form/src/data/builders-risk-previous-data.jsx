import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";
import LeadDetails from "./lead-details";

const BuildersRiskPreviousData = () => {
    const [buildersRiskPreviousData, setBuildersRiskPreviousData] =
        useState(null);
    const getLeadData = JSON.parse(sessionStorage.getItem("lead"));
    const { lead } = LeadDetails();
    useEffect(() => {
        const fetchBuildersRiskData = async () => {
            try {
                const response = await axiosClient.get(
                    `/api/builders-risk/get/previousBuildersRiskInformation/${lead?.data?.activityId}`
                );
                setBuildersRiskPreviousData(response.data);
            } catch (error) {
                console.error("Error fetching builders risk data", error);
            }
        };
        fetchBuildersRiskData();
    }, [lead?.data?.activityId]);
    console.log("builders risk", buildersRiskPreviousData);
    return { buildersRiskPreviousData };
};

export default BuildersRiskPreviousData;
