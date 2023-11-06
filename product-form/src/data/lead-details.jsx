import { useEffect, useState } from "react";
import axios from "axios";
import axiosClient from "../api/axios.client";

const LeadDetails = () => {
    const [lead, setLead] = useState(null);
    const [loading, setLoading] = useState(true);
    useEffect(() => {
        const fetchLead = async () => {
            try {
                const response = await axiosClient.get(
                    `/api/leads/lead-details`
                );
                setLead(response.data);
                setLoading(false);
            } catch (error) {
                console.error("Error fetching lead", error);
                setLoading(false);
            }
        };
        fetchLead();
    }, []);

    return { lead, loading };
};

export default LeadDetails;
