import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";
import LeadDetails from "./lead-details";

const WorkersCompensationData = () => {
    const [workersCompensationData, setWorkersCompensationData] =
        useState(null);
    const getLeadData = JSON.parse(sessionStorage.getItem("lead"));
    const { lead } = LeadDetails();
    useEffect(() => {
        const fetchWokersCompensationData = async () => {
            try {
                const respone = await axiosClient.get(
                    `api/workers-comp-data/edit/${lead?.data?.id}`
                );
                setWorkersCompensationData(respone.data);
            } catch (error) {
                console.error(
                    "Error fetching workers compensation data",
                    error
                );
            }
        };
        fetchWokersCompensationData();
    }, [lead?.data?.id]);
    return { workersCompensationData };
};

export default WorkersCompensationData;
