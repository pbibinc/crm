import { useEffect, useState } from "react";
import axios from "axios";
import axiosClient from "../api/axios.client";

const ClassCodeData = () => {
    const [classCodeData, setClassCodeData] = useState(null);
    useEffect(() => {
        const fetchClassCodeData = async () => {
            try {
                const response = await axiosClient.get("/api/classcode/data");
                setClassCodeData(response.data);
            } catch (error) {
                console.error("Error fetching class code data", error);
            }
        };
        fetchClassCodeData();
    }, []);

    if (!classCodeData || !classCodeData.data) {
        return <div>Loading...</div>;
    }

    let classCodeArray = [];

    if (Array.isArray(classCodeData.data)) {
        classCodeArray = classCodeData.data.map((code) => ({
            id: code.id,
            name: code.name,
        }));
    } else if (typeof classCodeData.data === "object") {
        classCodeArray = Object.entries(classCodeData.data).map(
            ([id, name]) => ({
                id,
                name,
            })
        );
    }

    return { classCodeArray };
};

export default ClassCodeData;
