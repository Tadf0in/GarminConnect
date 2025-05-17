import { useEffect, useState } from "react"

export default function useUserData() {
    const [userDataIndex, setUserDataIndex] = useState(localStorage.getItem('user_data_index'));
    let allUserData = localStorage.getItem('user_data');
    const [userData, setUserData] = useState(allUserData ? JSON.parse(allUserData).results[userDataIndex] : null);
    allUserData = JSON.parse(allUserData).results

    useEffect(() => {
        const userDataFromStorage = JSON.parse(localStorage.getItem('user_data'));
        if (userDataFromStorage && userDataFromStorage.results) {
            setUserData(userDataFromStorage.results[userDataIndex]);
        }
    }, [userDataIndex]);

    return { allUserData, userData, setUserDataIndex };
  };