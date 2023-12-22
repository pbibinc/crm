import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";

const WorkersCompensationData = () => {
    const [workersCompensationData, setWorkersCompensationData] =
        useState(null);
    const getLeadData = JSON.parse(sessionStorage.getItem("lead"));

    useEffect(() => {
        const fetchWokersCompensationData = async () => {
            try {
                const respone = await axiosClient.get(
                    `api/workers-comp-data/edit/${getLeadData?.data?.id}`
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
    }, [getLeadData?.data?.id]);
    return { workersCompensationData };
};

export default WorkersCompensationData;
