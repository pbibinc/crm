import { useEffect, useState } from "react";

const RecreationalFacilities = () => {
    const [recreationalFactilies, setRecreationalFactilies] = useState(null);
    useEffect(() => {
        const fetchRecreationalFactilies = async () => {
            try {
                const response = await fetch(
                    `http://crm.pbibinc.com/api/recreational`
                );
                const data = await response.json();
                setRecreationalFactilies(data);
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
