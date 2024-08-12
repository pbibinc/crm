import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";

const ToolsEquipmentPreviousData = () => {
    const [toolsEquipmentPreviousData, setToolsEquipmentPreviousData] =
        useState(null);
    const getLeadData = JSON.parse(sessionStorage.getItem("lead"));

    useEffect(() => {
        const fetchToolsEquipmentPreviousData = async () => {
            try {
                const response = await axiosClient.get(
                    `/api/tools-equipment-data/get/previousToolsEquipmentInformation/${getLeadData?.data?.activityId}`
                );
                setToolsEquipmentPreviousData(response.data);
            } catch (error) {
                console.error("Error fetching Tools Equipment data", error);
            }
        };
        fetchToolsEquipmentPreviousData();
    }, [getLeadData?.data?.activityId]);
    return { toolsEquipmentPreviousData };
};

export default ToolsEquipmentPreviousData;
