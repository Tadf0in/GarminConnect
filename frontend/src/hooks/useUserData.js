import { useEffect, useState } from "react"

export default function useUserData() {
    let allUserData = localStorage.getItem('user_data');
    
    const [userDataIndex, setUserDataIndex] = useState(localStorage.getItem('user_data_index'));
    const [userData, setUserData] = useState(allUserData ? JSON.parse(allUserData).results[userDataIndex] : null);
    allUserData = allUserData ? JSON.parse(allUserData).results : null;

    useEffect(() => {
        const userDataFromStorage = JSON.parse(localStorage.getItem('user_data'));
        if (userDataFromStorage && userDataFromStorage.results) {
            setUserData(userDataFromStorage.results[userDataIndex]);
        }
    }, [userDataIndex]);

    return { allUserData, userData, setUserDataIndex };
  };