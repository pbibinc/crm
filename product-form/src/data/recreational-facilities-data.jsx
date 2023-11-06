import { useEffect, useState } from "react";
import axiosClient from "../api/axios.client";

const RecreationalFacilities = () => {
    const [recreationalFactilies, setRecreationalFactilies] = useState(null);
    useEffect(() => {
        const fetchRecreationalFactilies = async () => {
            try {
                const response = await axiosClient.get(`/api/recreational`);
                setRecreationalFactilies(response.data);
            } catch (error) {
                console.error("Error fetching recreational facilities", error);
            }
        };
        fetchRecreationalFactilies();
    }, []);
    if (!recreationalFactilies || !recreationalFactilies.data) {
        return <div>Loading...</div>;
    }
    // console.log(recreationalFactilies.data);

    return recreationalFactilies.data.map((recreationalFacility) => ({
        id: recreationalFacility.id,
        name: recreationalFacility.name,
    }));
};

export default RecreationalFacilities;
