import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";
import LeadDetails from "./lead-details";
const ToolsEquipmentPreviousData = () => {
    const [toolsEquipmentPreviousData, setToolsEquipmentPreviousData] =
        useState(null);
    const getLeadData = JSON.parse(sessionStorage.getItem("lead"));
    const { lead } = LeadDetails();
    useEffect(() => {
        const fetchToolsEquipmentPreviousData = async () => {
            try {
                const response = await axiosClient.get(
                    `/api/tools-equipment-data/get/previousToolsEquipmentInformation/${lead?.data?.activityId}`
                );
                setToolsEquipmentPreviousData(response.data);
            } catch (error) {
                console.error("Error fetching Tools Equipment data", error);
            }
        };
        fetchToolsEquipmentPreviousData();
    }, [lead?.data?.activityId]);
    return { toolsEquipmentPreviousData };
};

export default ToolsEquipmentPreviousData;
