import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";
import LeadDetails from "./lead-details";
const WorkersCompensationPreviousData = () => {
    const [workersCompensationPreviousData, setWorkersCompenationPreviousData] =
        useState(null);
    const getLeadData = JSON.parse(sessionStorage.getItem("lead"));
    const { lead } = LeadDetails();
    useEffect(() => {
        const fetchWorkersCompensation = async () => {
            try {
                const response = await axiosClient.get(
                    `/api/workers-comp-data/get/previousWorkersComp/${lead?.data?.activityId}`
                );
                setWorkersCompenationPreviousData(response.data);
            } catch (error) {
                console.error("Error fetching commercial auto data", error);
            }
        };
        fetchWorkersCompensation();
    }, [lead?.data?.activityId]);
    return { workersCompensationPreviousData };
};

export default WorkersCompensationPreviousData;
