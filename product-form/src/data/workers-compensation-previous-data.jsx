import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";

const WorkersCompensationPreviousData = () => {
    const [workersCompensationPreviousData, setWorkersCompenationPreviousData] =
        useState(null);
    const getLeadData = JSON.parse(sessionStorage.getItem("lead"));

    useEffect(() => {
        const fetchWorkersCompensation = async () => {
            try {
                const response = await axiosClient.get(
                    `/api/workers-comp-data/get/previousWorkersComp/${getLeadData?.data?.activityId}`
                );
                setWorkersCompenationPreviousData(response.data);
            } catch (error) {
                console.error("Error fetching commercial auto data", error);
            }
        };
        fetchWorkersCompensation();
    }, [getLeadData?.data?.activityId]);
    return { workersCompensationPreviousData };
};

export default WorkersCompensationPreviousData;